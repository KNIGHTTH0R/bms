<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "unit_history".
 *
 * @property integer $id
 * @property integer $unit_id
 * @property integer $person_id
 * @property string $data
 * @property boolean $as_owner
 * @property integer $date_start
 * @property integer $date_end
 *
 * @property Person $person
 * @property Unit $unit
 */
class UnitHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'person_id', 'data', 'date_start', 'date_end'], 'required'],
            [['unit_id', 'person_id', 'date_start', 'date_end'], 'integer'],
            [['data'], 'string'],
            [['as_owner'], 'boolean']
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
            'person_id' => 'Person ID',
            'data' => 'Data',
            'as_owner' => 'As Owner',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
}
