<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DepositTb;

/**
 * DepositTbSearch represents the model behind the search form about `backend\models\DepositTb`.
 */
class DepositTbSearch extends DepositTb
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_deposit', 'unit_id'], 'integer'],
            [['deposit_value'], 'number'],
            [['explan'], 'safe'],
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
        $query = DepositTb::find();

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
            'id_deposit' => $this->id_deposit,
            'unit_id' => $this->unit_id,
            'deposit_value' => $this->deposit_value,
        ]);

        $query->andFilterWhere(['like', 'explan', $this->explan]);

        return $dataProvider;
    }
}
