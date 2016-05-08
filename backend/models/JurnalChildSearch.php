<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\JurnalChild;

/**
 * JurnalChildSearch represents the model behind the search form about `backend\models\JurnalChild`.
 */
class JurnalChildSearch extends JurnalChild
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_jur', 'id_coa', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['date', 'dc', 'description'], 'safe'],
            [['amount'], 'number'],
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
        $query = JurnalChild::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'status' => [
                    'asc' => ['status'=>SORT_ASC],
                    'desc' => ['status'=>SORT_DESC],
                    'label' => 'Status',
                    'default' => SORT_ASC
                ],
                'code' => [
                    'asc' => ['code'=>SORT_ASC],
                    'desc' => ['code'=>SORT_DESC],
                    'label' => 'Code',
                    'default' => SORT_ASC
                ],
                'date' => [
                    'asc' => ['date'=>SORT_ASC],
                    'desc' => ['date'=>SORT_DESC],
                    'label' => 'Date',
                    'default' => SORT_ASC
                ],
                'ref' => [
                    'asc' => ['ref'=>SORT_ASC],
                    'desc' => ['ref'=>SORT_DESC],
                    'label' => 'Ref',
                    'default' => SORT_ASC
                ],
            ]
        ]);

        /*$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        if(!($this->load($params) && $this->validate())){
            $query->joinWith(['jurnal']);
            return $dataProvider;
        }

        /*$this->addCondition($query, 'id');
        $this->addCondition($query, 'status');
        $this->addCondition($query, 'code', true);
        $this->addCondition($query, 'date', true);
        $this->addCondition($query, 'ref', true);
        $this->addCondition($query, 'description', true);*/

        $query->andWhere('description LIKE \'%' . $this->description . '%\'');

        $query->joinWith(['jurnal' => function($q){
            $q->where('jurnal.description LIKE \'%' . $this->description . '%\'');
        }]);

        /*$query->andFilterWhere([
            'id' => $this->id,
            'id_jur' => $this->id_jur,
            'id_coa' => $this->id_coa,
            'date' => $this->date,
            'amount' => $this->amount,
            'dc' => $this->dc,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);*/

        return $dataProvider;
    }
}
