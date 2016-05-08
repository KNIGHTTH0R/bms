<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UnitChargeValue;

/**
 * UnitChargeValueSearch represents the model behind the search form about `app\models\UnitChargeValue`.
 */
class UnitChargeValueSearch extends UnitChargeValue
{
    /**
     * @inheritdoc
     */
    public $personId;        
    public function rules()
    {
        return [
            [['id', 'unit_charge_id', 'charge_date', 'due_date', 'created_by', 'created_at', 'updated_by', 'updated_at', 'charge_month', 'charge_year'], 'integer'],
            [['type', 'detail','inv_number','unit_code','personId','bill_to'], 'safe'],
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
        $query = UnitChargeValue::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 6,
            ],
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
            'inv_number'=>$this->inv_number,
            'unit_code'=>$this->unit_code,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'inv_number', $this->inv_number]);

        return $dataProvider;
    }



    public function cari($params)
    {
        
        $query = UnitChargeValue::find()->select('inv_number, bill_to, charge_month, charge_year, unit_code')->where(['status_pay' => null])->distinct();
        $query->joinWith(['personId']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 7,
            ],
        ]);        

        $dataProvider->sort->attributes['person'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['person.name' => SORT_ASC],
            'desc' => ['person.name' => SORT_DESC],
        ];

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
            'inv_number'=>$this->inv_number,    
            'unit_code'=>$this->unit_code,
            'bill_to'=>$this->bill_to,
            'personId'=>$this->bill_to, 

        ]);     

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'inv_number', $this->inv_number])
            ->andFilterWhere(['like', 'unit_code', $this->unit_code])
            ->andFilterWhere(['like', 'person.name', $this->personId]);
       
        return $dataProvider;
    }


    public function cariUnit($params,$id)
    {
        
        $query = UnitChargeValue::find()->select('inv_number, bill_to, charge_month, charge_year, unit_code')->where(['unit_code' => $id])->distinct();
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
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'inv_number', $this->inv_number]);


        
        return $dataProvider;
    }



}