<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UnitChargeValue;

/**
 * UnitChargeValueSearch represents the model behind the search form about `app\models\UnitChargeValue`.
 */
class UnitChargeValueSearch extends UnitChargeValue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'unit_charge_id', 'charge_date', 'due_date', 'created_by', 'created_at', 'updated_by', 'updated_at', 'charge_month', 'charge_year'], 'integer'],
            [['type', 'detail'], 'safe'],
            [['value_charge', 'value_tax', 'value_admin', 'value_penalty'], 'number'],
            [['overdue'], 'boolean'],
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
        $sql = 'SELECT distinct inv_number, bill_to, charge_month, charge_year, unit_code FROM unit_charge_value';
        $query = UnitChargeValue::findBySql($sql)->all();    
        // $query = UnitChargeValue::find();

        $dataProvider = new ActiveDataProvider([
            // 'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'unit_charge_id' => $this->unit_charge_id,
            'value_charge' => $this->value_charge,
            'value_tax' => $this->value_tax,
            'value_admin' => $this->value_admin,
            'value_penalty' => $this->value_penalty,
            'charge_date' => $this->charge_date,
            'overdue' => $this->overdue,
            'due_date' => $this->due_date,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'charge_month' => $this->charge_month,
            'charge_year' => $this->charge_year,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
