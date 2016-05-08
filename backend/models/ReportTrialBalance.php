<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\Coa;
use backend\models\CoaType;

/**
 * This is the model class for table "jurnal_child".
 *
 * @property integer $id
 * @property integer $id_jur
 * @property integer $id_coa
 * @property string $date
 * @property string $amount
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $dc
 * @property string $description
 * @property integer $status
 *
 * @property Jurnal $idJur
 */
class ReportTrialBalance extends \yii\db\ActiveRecord
{
    public $from_date;
    public $to_date;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jurnal_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jur', 'id_coa', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['from_date', 'to_date','date'], 'safe'],
            [['amount'], 'number'],
            [['dc'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_jur' => 'Id Jur',
            'id_coa' => 'Id Coa',
            'date' => 'Date',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'dc' => 'Dc',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoa()
    {
        return $this->hasOne(Coa::className(), ['id' => 'id_coa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoaParent()
    {
        $coaParent = Coa::find()->where(['id' => $this->coa['parent_id']]);
        return $coaParent ? $coaParent : 'Kosong';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoaType()
    {
        $coaType = CoaType::find()->where(['id' => $this->coa['type']]);
        return $coaType ? $coaType : 'Kosong';
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getDebitAmount()
    {
        $debit = $this->find()->where(['dc'=>'D', 'id_coa' => $this->id_coa])->sum('amount');
        return $debit ? $debit : 0;
    }

    // public function debitAmount($id)
    // {
    //     $debit = $this->find()->where(['dc'=>'D', 'id_coa' => $id])->sum('amount');
    //     return $debit ? $debit : 0;
    // }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCreditAmount()
    {
        $credit = $this->find()->where(['dc'=>'C', 'id_coa' => $this->id_coa])->sum('amount');
        return $credit ? $credit : 0;
    }

    // public function creditAmount($id)
    // {
    //     $credit = $this->find()->where(['dc'=>'C', 'id_coa' => $id])->sum('amount');
    //     return $credit ? $credit : 0;
    // }

    // public function getCoaCode($type)
    // {
    //     $coaCode = $this->find()
    //                     ->where(['id_coa' => $type])
    //                     ->all();
    //     return $coaCode;
    // }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdJur()
    {
        return $this->hasOne(Jurnal::className(), ['id' => 'id_jur']);
    }
}
