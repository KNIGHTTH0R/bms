<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    public $fullname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'fullname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' =>[
                'username' => [
                    'asc' => ['username' => SORT_ASC],
                    'desc' => ['username' => SORT_DESC],
                    'label' => 'Username',
                    'default' => SORT_ASC
                ],
                'fullname' =>[
                    'asc' => ['fullname' => SORT_ASC],
                    'desc' => ['fullname' => SORT_DESC],
                    'label' => 'Fullname',
                    'default' => SORT_ASC
                ],
                'email',
                'status',
            ],
        ]);

        /*$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        if(!($this->load($params) && $this->validate())) {
            $query->joinWith(['profile']);
            return $dataProvider;
        }

        //$this->addCondition($query, 'id');
        //$this->addCondition($query, 'username', true);
        //$this->addCondition($query, 'fullname', true);

        if($this->fullname){
            $query->joinWith(['profile' => function($q){
                $q->where('"profile_user"."fullname" LIKE \'%' . $this->fullname . '%\'');
            }]);
        }

        $query->andFilterWhere([
            //'id' => $this->id,
            'user.status' => $this->status,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            //'created_by' => $this->created_by,
            //'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);
        

        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        if(($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;
        if(trim($value) === '') {
            return;
        }

        /**
         * The following line is additionally added for right aliasing
         * of columns so filtering happen correctly in the self join
         */
        $attribute = "profile_user.$attribute";
        if($partialMatch){
            $query->andWhere(['like', $attribute, $value]);
        }else{
            $query->andWhere([$attribute => $value]);
        }
    }
}
