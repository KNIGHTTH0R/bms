<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ComplainTb;

/**
 * ComplainTbSearch represents the model behind the search form about `backend\models\ComplainTb`.
 */
class ComplainTbSearch extends ComplainTb
{
    /**
     * @inheritdoc
     */

    public $user;
    public function rules()
    {
        return [
            [['id_complain', 'user_id','created_at','created_by','updated_at','updated_by'], 'integer'],
            [['complain','solution', 'code_unit', 'date_complain','user','status_complain','date_complain_char'], 'safe'],
            
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
        $query = ComplainTb::find();
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);

        $dataProvider->sort->attributes['city'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_complain' => $this->id_complain,
            'date_complain' => $this->date_complain,
            
        ]);

        $query->andFilterWhere(['like', 'complain', $this->complain])
            ->andFilterWhere(['like', 'solution', $this->solution])
            ->andFilterWhere(['like', 'status_complain', $this->status_complain])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'code_unit', $this->code_unit])
            ->andFilterWhere(['like', 'date_complain_char', $this->date_complain_char])
            ->andFilterWhere(['like', 'user.username', $this->user]);

        return $dataProvider;
    }
}
