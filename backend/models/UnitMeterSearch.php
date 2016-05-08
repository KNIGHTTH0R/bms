<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UnitMeter;

/**
 * UnitMeterSearch represents the model behind the search form about `backend\models\UnitMeter`.
 */
class UnitMeterSearch extends UnitMeter
{
    /**
     * @inheritdoc
     */
    public $unit;

    public function rules()
    {
        return [
            
            [['type', 'meter_number','unit_id','unit'], 'safe'],
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
        $query = UnitMeter::find();
        $query->joinWith(['unit']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 6,
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
            'unit_id' => $this->unit_id,
            'unit' => $this->unit_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'meter_number', $this->meter_number])
            ->andFilterWhere(['like', 'unit.code', $this->unit]);

        return $dataProvider;
    }
}
