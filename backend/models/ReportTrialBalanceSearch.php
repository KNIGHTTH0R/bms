<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ReportTrialBalance;

/**
 * ReportTrialBalanceSearch represents the model behind the search form about `backend\models\ReportTrialBalance`.
 */
class ReportTrialBalanceSearch extends ReportTrialBalance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_jur', 'id_coa', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['date', 'dc', 'description', 'from_date', 'to_date'], 'safe'],
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
        // Faq::find()->select('chapter')->distinct()->all();
        // $query = ReportTrialBalance::find();
        $query = ReportTrialBalance::find()
                ->select('id_coa,coa_type.type')
                ->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('coa');
        
        $query->leftJoin('coa_type', '"coa_type"."id" = "coa"."type"');

        $query->where(['status' => 10]);

        $dataProvider->setSort([
            'attributes' => [
                'coa.type' => [
                    'asc' => ['coa_type.type' => SORT_ASC],
                    'desc' => ['coa_type.type' => SORT_DESC]
                ]
            ],
            'defaultOrder' => ['coa.type'=>SORT_ASC]
        ]);

        $request = Yii::$app->request;
        $get = $request->get();
        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');

        $this->from_date = strtotime($from_date);
        $this->to_date = strtotime($to_date);

        $query->andWhere(['>=', 'date', date('Y-m-d', $this->from_date)]);
        $query->andWhere(['<=', 'date', date('Y-m-d', $this->to_date)]);

        $query->andFilterWhere([
            'id' => $this->id,
            'id_jur' => $this->id_jur,
            'id_coa' => $this->id_coa,
            'date' => $this->date,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'dc', $this->dc])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
