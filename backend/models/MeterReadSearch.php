<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MeterRead;

/**
 * MeterReadSearch represents the model behind the search form about `backend\models\MeterRead`.
 */
class MeterReadSearch extends MeterRead
{
    /**
     * @inheritdoc
     */
    public $unitCode;

    public function rules()
    {
        return [
            [['id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['type', 'status', 'unit_meter_id', 'date_read'], 'safe'],
            [['prev_value', 'cur_value', 'delta'], 'number'],
            [['unitCode'], 'safe'],
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
        $query = MeterRead::find();

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
            'date_read' => $this->date_read,
            'prev_value' => $this->prev_value,
            'cur_value' => $this->cur_value,
            'delta' => $this->delta,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'unit_meter_id', $this->unit_meter_id]);

        return $dataProvider;
    }
}
