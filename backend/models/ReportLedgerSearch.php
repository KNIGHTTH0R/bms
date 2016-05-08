<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\JurnalChild;
use backend\models\Coa;
use yii\db\Query;

/**
 * ReportLedgerSearch represents the model behind the search form about `backend\models\JurnalChild`.
 */
class ReportLedgerSearch extends JurnalChild
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_jur', 'id_coa', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['date', 'dc', 'description'], 'safe'],
            [['amount'], 'number'],
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
        /**SELECT c.id,c.code,c.name,sum(debet) AS debet,sum(credit) AS credit
            FROM coa b
            LEFT JOIN coa c ON c.id=b.parent_id
            LEFT JOIN
            (SELECT *,
                CASE
                  WHEN a.dc='D' THEN
                    a.amount
                  ELSE
                    0
                  END AS debet,
                CASE
                  WHEN a.dc='C' THEN
                    a.amount
                  ELSE
                    0
                  END AS credit
                FROM jurnal_child a
            ) AS aa ON b.id=aa.id_coa
            WHERE b.parent_id IS NOT null
            AND ((aa.date IS NULL) OR (aa.date BETWEEN '2015-12-01' AND '2016-12-31'))
            GROUP BY c.id,c.code,c.name

            $connection = \Yii::$app->db;

            $model = $connection->createCommand('SELECT * FROM tbl_user');
            $users = $model->queryAll();
            $model = User::findBySql($sql)->all();

            ===============
            $subquery = JurnalChild::find()->select('*,
                        CASE WHEN jurnal_child.dc=\'D\' THEN jurnal_child.amount ELSE null END AS debet,
                        CASE WHEN jurnal_child.dc=\'C\' THEN jurnal_child.amount ELSE null END AS credit');

        */

        // $query = JurnalChild::find()->select('*,
        //         (CASE WHEN dc=\'D\' THEN amount ELSE null END) AS debit,
        //         (CASE WHEN dc=\'C\' THEN amount ELSE null END) AS credit');

        $sql = '(SELECT jurnal_child.*, CASE WHEN dc=\'D\' THEN amount ELSE null END AS debit, CASE WHEN dc=\'C\' THEN amount ELSE null END AS credit FROM jurnal_child) AS aa';
        $query = Coa::find()->select('c.id,c.code,c.name,sum(debit) AS debit, sum(credit) AS credit')
                            ->from('coa b')
                            ->leftJoin('coa c', 'c.id = b.parent_id')
                            ->leftJoin("$sql", 'b.id = aa.id_coa')
                            ->where(['not', ['b.parent_id'=>null]])
                            ->groupBy('c.id,c.code,c.name');
        
        // $query = Coa::find()->select('*')
        //                     ->leftJoin($subquery);


        
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
            'id_jur' => $this->id_jur,
            'id_coa' => $this->id_coa,
            'date' => $this->date,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'dc', $this->dc])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
