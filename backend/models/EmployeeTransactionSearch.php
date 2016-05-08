<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EmployeeTransaction;

/**
 * EmployeeTransactionSearch represents the model behind the search form about `backend\models\EmployeeTransaction`.
 */
class EmployeeTransactionSearch extends EmployeeTransaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_transaction', 'idemployee', 'atten_day', 'overtime_day', 'debt_value', 'emp_trans_month'], 'integer'],
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
        $query = EmployeeTransaction::find();

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
            'id_transaction' => $this->id_transaction,
            'idemployee' => $this->idemployee,
            'atten_day' => $this->atten_day,
            'overtime_day' => $this->overtime_day,
            'debt_value' => $this->debt_value,
            'emp_trans_month' => $this->emp_trans_month
        ]);

        return $dataProvider;
    }
}
