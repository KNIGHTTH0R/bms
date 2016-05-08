<?php

namespace backend\models;

use Yii;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "unit_charge".
 *
 * @property integer $id
 * @property integer $unit_id
 * @property integer $tariff_id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $bill_to
 * @property string $type
 * @property string $group_bill
 * @property integer $unit_meter_id
 *
 * @property Tariff $tariff
 * @property Unit $unit
 * @property UnitMeter $unitMeter
 * @property UnitChargeValue[] $unitChargeValues
 */
class UnitCharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit_charge';
    }

    public function behaviors()
    {
        /*return [
            TimestampBehavior::className(),
        ];*/

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function(){ return date('U'); /*unix timestamp */},
            ],
            'autouserid' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'bill_to'], 'required'],
            [['unit_id', 'tariff_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'bill_to', 'unit_meter_id'], 'integer'],
            [['type','meter_number'], 'string', 'max' => 100],
            [['group_bill'], 'string', 'max' => 10]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'tariff_id' => 'Tariff ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'bill_to' => 'Bill To',
            'type' => 'Type',
            'group_bill' => 'Group Bill',
            'unit_meter_id' => 'Unit Meter ID',
            'meter_number' => 'Meter Number',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariff()
    {
        return $this->hasOne(Tariff::className(), ['id' => 'tariff_id']);
    }

    public function getTariffName()
    {
        return $this->tariff ? $this->tariff->tariff_name : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitMeter()
    {
        return $this->hasOne(UnitMeter::className(), ['id' => 'unit_meter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitChargeValues()
    {
        return $this->hasMany(UnitChargeValue::className(), ['unit_charge_id' => 'id']);
    }
}
