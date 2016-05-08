<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PersonAddress;

/**
 * PersonAddressSearch represents the model behind the search form about `backend\models\PersonAddress`.
 */
class PersonAddressSearch extends PersonAddress
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'person_id'], 'integer'],
            [['postal_code', 'phone', 'fax', 'name', 'building', 'street', 'city', 'province', 'country'], 'safe'],
            [['for_billing', 'for_letternotif'], 'boolean'],
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
        $query = PersonAddress::find();

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
            'person_id' => $this->person_id,
            'for_billing' => $this->for_billing,
            'for_letternotif' => $this->for_letternotif,
        ]);

        $query->andFilterWhere(['like', 'postal_code', $this->postal_code])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }
}
