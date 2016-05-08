<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Jurnal;

/**
 * JurnalSearch represents the model behind the search form about `backend\models\Jurnal`.
 */
class JurnalSearch extends Jurnal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['debit', 'credit'], 'number'],
            [['date', 'ref', 'code', 'description', 'from_date', 'to_date'], 'safe'],
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
        $query = Jurnal::find();

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

        //$this->load($params);

        if(!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        /*$this->addCondition($query, 'id');
        $this->addCondition($query, 'status');
        $this->addCondition($query, 'code', true);
        $this->addCondition($query, 'date', true);
        $this->addCondition($query, 'ref', true);
        $this->addCondition($query, 'description', true);*/

        $request = Yii::$app->request;
        $get = $request->get();
        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');

        $this->from_date = strtotime($from_date);
        $this->to_date = strtotime($to_date);

        $query->andWhere('description LIKE \'%' . $this->description . '%\'');
        $query->andWhere('code LIKE \'%' . $this->code . '%\'');
        $query->andWhere('ref LIKE \'%' . $this->ref . '%\'');
        $query->andFilterWhere(['>=', 'date', date('Y-m-d', $this->from_date)]);
        $query->andFilterWhere(['<=', 'date', date('Y-m-d', $this->to_date)]);
        
        //$d = strtotime($this->from_date);
        //var_dump(date('Y-m-d',$this->from_date));
        //die();
        //$query->andWhere('date >= ')

        /*$query->andFilterWhere([
            'id' => $this->id,
            'debit' => $this->debit,
            'credit' => $this->credit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'date' => $this->date,
            'description' => $this->description,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ref', $this->ref])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'description', $this->description]);*/

        return $dataProvider;
    }
}

/**
 * SELECT * FROM jurnal
 * WHERE
 * date >= '2015-10-1' AND date <= '2015-10-22'
 */