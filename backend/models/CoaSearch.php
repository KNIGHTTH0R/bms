<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Coa;

/**
 * CoaSearch represents the model behind the search form about `backend\models\Coa`.
 */
class CoaSearch extends Coa
{
    public $parentName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'type', 'debet_credit', 'bank_acc_number', 'bank_acc_name'], 'safe'],
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
        $query = Coa::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       /*$query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);*/

        $query->andFilterWhere(['=', 'parent_id', $this->parent_id])
        //$query->andWhere('name LIKE \'%' . $this->name . '%\'');

            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'bank_acc_name', $this->bank_acc_name])
            ->andFilterWhere(['like', 'bank_acc_number', $this->bank_acc_number])
            ->andFilterWhere(['like', 'debet_credit', $this->debet_credit]);
        
        
        return $dataProvider;
    }
    
}
