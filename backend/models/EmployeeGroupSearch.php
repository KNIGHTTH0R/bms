<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EmployeeGroup;

/**
 * EmployeeGroupSearch represents the model behind the search form about `backend\models\EmployeeGroup`.
 */
class EmployeeGroupSearch extends EmployeeGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idgroup', 'basic_salary', 'overtime_value', 'transport_value', 'meal_allow'], 'integer'],
            [['group_name', 'allowance1', 'allowance2', 'allowance3'], 'safe'],
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
        $query = EmployeeGroup::find();

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
            'idgroup' => $this->idgroup,
            'basic_salary' => $this->basic_salary,
            'overtime_value' => $this->overtime_value,
            'transport_value' => $this->transport_value,
            'meal_allow' => $this->meal_allow,
        ]);

        $query->andFilterWhere(['like', 'group_name', $this->group_name])
            ->andFilterWhere(['like', 'allowance1', $this->allowance1])
            ->andFilterWhere(['like', 'allowance2', $this->allowance2])
            ->andFilterWhere(['like', 'allowance3', $this->allowance3]);

        return $dataProvider;
    }
}
