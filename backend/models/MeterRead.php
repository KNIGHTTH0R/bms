<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\Unit;

/**
 * This is the model class for table "meter_read".
 *
 * @property integer $id
 * @property string $type
 * @property integer $date_read
 * @property string $prev_value
 * @property string $cur_value
 * @property string $delta
 * @property string $status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property string $unit_meter_id
 *
 * @property UnitMeter $unitMeter
 */
class MeterRead extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meter_read';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'date_read', 'unit_meter_id'], 'required'],
            [['created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['prev_value', 'cur_value', 'delta'], 'number'],
            [['date_read'], 'safe'],
            [['type', 'status'], 'string', 'max' => 100]
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
            'type' => 'Type',
            'date_read' => 'Date Read',
            'prev_value' => 'Prev Value',
            'cur_value' => 'Cur Value',
            'delta' => 'Delta',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'unit_meter_id' => 'Unit Meter ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitMeter()
    {
        return $this->hasOne(UnitMeter::className(), ['id' => 'unit_meter_id']);
    }

    public function getUnit()
    {
        $id = $this->unitMeter->unit_id;
        return Unit::find()->where(['id'=>$id])->all();
    }

    public function getUnitCode()
    {
        $model = $this->unit;
        return $model ? $model[0]->code: '';

        //var_dump($model[0]->code);
        //die();
    }

    
    
}
