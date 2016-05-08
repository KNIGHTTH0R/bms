<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\JurnalChild;

/**
 * ReportBalanceSearch represents the model behind the search form about `backend\models\JurnalChild`.
 */
class ReportBalanceSearch extends JurnalChild
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

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
