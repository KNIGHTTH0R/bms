<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "tariff".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $type
 * @property boolean $recurring
 * @property string $recur_period
 * @property string $recur_date
 * @property string $recur_month
 * @property boolean $progressive
 * @property string $meter_unit
 * @property string $formula
 * @property string $progressive_formula
 * @property boolean $tax
 * @property string $tax_formula
 * @property boolean $admin_charge
 * @property string $admin_formula
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property boolean $penalty
 * @property string $penalty_formula
 *
 * @property Property $property
 * @property UnitCharge[] $unitCharges
 */
class Tariff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'type', 'tariff_name'], 'required'],
            [['tariff_name'], 'unique'],
            [['property_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['recurring', 'progressive', 'tax', 'admin_charge', 'penalty'], 'boolean'],
            [['formula', 'tariff_name', 'progressive_formula', 'tax_formula', 'admin_formula', 'penalty_formula'], 'string'],
            [['type', 'recur_period', 'recur_date', 'recur_month', 'meter_unit'], 'string', 'max' => 100]
        ];
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
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'type' => 'Type',
            'recurring' => 'Recurring',
            'recur_period' => 'Recur Period',
            'recur_date' => 'Recur Date',
            'recur_month' => 'Recur Month',
            'progressive' => 'Progressive',
            'meter_unit' => 'Meter Unit',
            'formula' => 'Formula',
            'progressive_formula' => 'Progressive Formula',
            'tax' => 'Tax',
            'tax_formula' => 'Tax Formula',
            'admin_charge' => 'Admin Charge',
            'admin_formula' => 'Admin Formula',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'penalty' => 'Penalty',
            'penalty_formula' => 'Penalty Formula',
            'tariff_name' => 'Tariff Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitCharges()
    {
        return $this->hasMany(UnitCharge::className(), ['tariff_id' => 'id']);
    }
}
