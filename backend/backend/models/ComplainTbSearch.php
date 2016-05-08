<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ComplainTb;

/**
 * ComplainTbSearch represents the model behind the search form about `backend\models\ComplainTb`.
 */
class ComplainTbSearch extends ComplainTb
{
    /**
     * @inheritdoc
     */

    
    public function rules()
    {
        return [
            [['id_complain', 'user_id','created_at','created_by','updated_at','updated_by'], 'integer'],
            [['complain', 'solution', 'code_unit', 'date_complain'], 'safe'],
            [['status'], 'boolean'],
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
        $query = ComplainTb::find();

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
            'id_complain' => $this->id_complain,
            'code_unit' => $this->code_unit,
            'date_complain' => $this->date_complain,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'complain', $this->complain])
            ->andFilterWhere(['like', 'solution', $this->solution])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'code_unit', $this->code_unit]);

        return $dataProvider;
    }
}
