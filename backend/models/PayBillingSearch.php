<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PayBilling;

/**
 * PayBillingSearch represents the model behind the search form about `backend\models\PayBilling`.
 */
class PayBillingSearch extends PayBilling
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'unit_charge_value_id'], 'integer'],
            [['type', 'unit_code', 'status_pay', 'inv_number','jenis_pembayaran', 'coa_code'], 'safe'],
            [['total_charge', 'total_pay', 'balance_value'], 'number'],
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
        $query = PayBilling::find();

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
            'unit_charge_value_id' => $this->unit_charge_value_id,
            'total_charge' => $this->total_charge,
            'total_pay' => $this->total_pay,
            'balance_value' => $this->balance_value,
            'inv_number' => $this->inv_number,
            'jenis_pembayaran' => $this->jenis_pembayaran,
            'coa_code' => $this->coa_code,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'unit_code', $this->unit_code])
            ->andFilterWhere(['like', 'status_pay', $this->status_pay]);

        return $dataProvider;
    }
}
