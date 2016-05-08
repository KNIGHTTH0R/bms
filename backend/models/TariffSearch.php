<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tariff;

/**
 * TariffSearch represents the model behind the search form about `backend\models\Tariff`.
 */
class TariffSearch extends Tariff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'property_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['type', 'recur_period', 'recur_date', 'recur_month', 'meter_unit', 'formula', 'progressive_formula', 'tax_formula', 'admin_formula', 'penalty_formula'], 'safe'],
            [['recurring', 'progressive', 'tax', 'admin_charge', 'penalty'], 'boolean'],
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
        $query = Tariff::find();

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
            'property_id' => $this->property_id,
            'recurring' => $this->recurring,
            'progressive' => $this->progressive,
            'tax' => $this->tax,
            'admin_charge' => $this->admin_charge,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'penalty' => $this->penalty,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'recur_period', $this->recur_period])
            ->andFilterWhere(['like', 'recur_date', $this->recur_date])
            ->andFilterWhere(['like', 'recur_month', $this->recur_month])
            ->andFilterWhere(['like', 'meter_unit', $this->meter_unit])
            ->andFilterWhere(['like', 'formula', $this->formula])
            ->andFilterWhere(['like', 'progressive_formula', $this->progressive_formula])
            ->andFilterWhere(['like', 'tax_formula', $this->tax_formula])
            ->andFilterWhere(['like', 'admin_formula', $this->admin_formula])
            ->andFilterWhere(['like', 'penalty_formula', $this->penalty_formula]);

        return $dataProvider;
    }
}
