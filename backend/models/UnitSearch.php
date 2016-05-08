<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Unit;

/**
 * UnitSearch represents the model behind the search form about `backend\models\Unit`.
 */
class UnitSearch extends Unit
{
    /**
     * @inheritdoc
     */
    public  $building;

    public function rules()
    {
        return [
            [['id', 'updated_by', 'owner_id', 'tenant_id', 'unit_type_id', 'created_by','va'], 'integer'],
            [['updated_at', 'code', 'building_id', 'unit_floor', 'unit_num', 'space_unit', 'created_at','code', 'building'], 'safe'],
            [['space_size', 'power'], 'number'],
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
        $query = Unit::find()->orderBy('code');

        $query->joinWith(['building']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 6,
            ],
        ]);


         $dataProvider->sort->attributes['building'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['building.name' => SORT_ASC],
            'desc' => ['building.name' => SORT_DESC],
         ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            
            'owner_id' => $this->owner_id,
            'tenant_id' => $this->tenant_id,
            'unit_type_id' => $this->unit_type_id,
            'space_size' => $this->space_size,
            'va' => $this->va,
            'power' => $this->power,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            

        ])->andFilterWhere(['like', 'code', $this->code])     
            ->andFilterWhere(['like', 'unit_floor', $this->unit_floor])     
            ->andFilterWhere(['like', 'unit_num', $this->unit_num])
            ->andFilterWhere(['like', 'space_unit', $this->space_unit])
            ->andFilterWhere(['like', 'building.name', $this->building_id]);
            

        return $dataProvider;
    }
}
