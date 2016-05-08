<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "deposit_tb".
 *
 * @property integer $id_deposit
 * @property integer $unit_id
 * @property integer $deposit_value
 * @property string $explan
 *
 * @property Unit $unit
 */
class DepositTb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deposit_tb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id'], 'integer'],
            [['deposit_value'], 'number'],
            [['explan'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_deposit' => 'Id Deposit',
            'unit_id' => 'Unit ID',
            'deposit_value' => 'Deposit Value',
            'explan' => 'Explan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
}
