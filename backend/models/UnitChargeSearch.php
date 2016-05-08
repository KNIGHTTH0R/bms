<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UnitCharge;

/**
 * UnitChargeSearch represents the model behind the search form about `backend\models\UnitCharge`.
 */
class UnitChargeSearch extends UnitCharge
{
    /**
     * @inheritdoc
     */
    public $unit;

    public function rules()
    {
        return [
            [['id', 'tariff_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'bill_to', 'unit_meter_id'], 'integer'],
            [['type','unit_id','unit'], 'safe'],
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
        $query = UnitCharge::find();
        $query->joinWith(['unit']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 7,
            ],
        ]);

        $dataProvider->sort->attributes['unit'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
            'asc' => ['unit.code' => SORT_ASC],
            'desc' => ['unit.code' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'unit_id' => $this->unit_id,
            'tariff_id' => $this->tariff_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'bill_to' => $this->bill_to,
            'unit'=>$this->unit_id,

        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'unit_meter_id', $this->unit_meter_id])
            ->andFilterWhere(['like', 'unit.code', $this->unit]);

        return $dataProvider;
    }
}
