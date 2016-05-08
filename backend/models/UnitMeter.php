<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "unit_meter".
 *
 * @property integer $id
 * @property integer $unit_id
 * @property string $type
 * @property string $meter_number
 *
 * @property UnitCharge[] $unitCharges
 */
class UnitMeter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit_meter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id'], 'integer'],
            [['type', 'meter_number'], 'string', 'max' => 100],
            ['meter_number', 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit Code',
            'type' => 'Type',
            'meter_number' => 'Meter Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitCharges()
    {
        return $this->hasMany(UnitCharge::className(), ['unit_meter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeterReads()
    {
        return $this->hasMany(MeterRead::className(), ['unit_meter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    public function getUnitCode()
    {
        return $this->unit ? $this->unit->code: null;
    }
}
