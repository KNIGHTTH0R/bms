<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form about `backend\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemployee', 'dob', 'start_work', 'idgroup'], 'integer'],
            [['nip', 'name_employee', 'address_employee', 'email_employee', 'gender', 'religion', 'pob', 'section', 'position', 'marital_status', 'work_status', 'photo'], 'safe'],
            [['phone_employee'], 'number'],
            [['nip'], 'unique'],
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
        $query = Employee::find();

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
            'idemployee' => $this->idemployee,
            'phone_employee' => $this->phone_employee,
            'dob' => $this->dob,
            'start_work' => $this->start_work,
            'idgroup' => $this->idgroup,
        ]);

        $query->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'name_employee', $this->name_employee])
            ->andFilterWhere(['like', 'address_employee', $this->address_employee])
            ->andFilterWhere(['like', 'email_employee', $this->email_employee])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'religion', $this->religion])
            ->andFilterWhere(['like', 'pob', $this->pob])
            ->andFilterWhere(['like', 'section', $this->section])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'marital_status', $this->marital_status])
            ->andFilterWhere(['like', 'work_status', $this->work_status])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
