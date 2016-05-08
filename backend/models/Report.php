<?php

namespace backend\models;

use Yii;

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
class Report extends \yii\db\ActiveRecord
{
    public $debit;
    public $credit;

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
            [['date'], 'safe'],
            [['amount', 'debit', 'credit'], 'number'],
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
            'debit' => 'Debit',
            'credit' => 'Credit'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdJur()
    {
        return $this->hasOne(Jurnal::className(), ['id' => 'id_jur']);
    }
}
