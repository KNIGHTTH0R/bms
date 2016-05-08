<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UnitHistory;

/**
 * UnitHistorySearch represents the model behind the search form about `backend\models\UnitHistory`.
 */
class UnitHistorySearch extends UnitHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'unit_id', 'person_id', 'date_start', 'date_end'], 'integer'],
            [['data'], 'safe'],
            [['as_owner'], 'boolean'],
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
        $query = UnitHistory::find();

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
            'unit_id' => $this->unit_id,
            'person_id' => $this->person_id,
            'as_owner' => $this->as_owner,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
