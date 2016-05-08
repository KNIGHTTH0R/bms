<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "property".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $property_owner_id
 * @property integer $property_management_id
 *
 * @property Building[] $buildings
 * @property PropertyManagement $propertyManagement
 * @property PropertyOwner $propertyOwner
 * @property UnitType[] $unitTypes
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'property_owner_id', 'property_management_id'], 'required'],
            [['code', 'name', 'address'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'property_owner_id', 'property_management_id'], 'integer'],
            [['code'], 'unique']
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
            'code' => 'Code',
            'name' => 'Name',
            'address' => 'Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'property_owner_id' => 'Property Owner ID',
            'property_management_id' => 'Property Management ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuildings()
    {
        return $this->hasMany(Building::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyManagement()
    {
        return $this->hasOne(PropertyManagement::className(), ['id' => 'property_management_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyOwner()
    {
        return $this->hasOne(PropertyOwner::className(), ['id' => 'property_owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitTypes()
    {
        return $this->hasMany(UnitType::className(), ['property_id' => 'id']);
    }
}
