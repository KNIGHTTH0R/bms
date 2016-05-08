<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\Person;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "unit".
 *
 * @property integer $id
 * @property integer $building_id
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $owner_id
 * @property integer $tenant_id
 * @property integer $unit_type_id
 * @property string $code
 * @property string $unit_floor
 * @property string $unit_num
 * @property string $space_size
 * @property string $space_unit
 * @property string $created_at
 * @property integer $created_by
 *
 * @property Building $building
 * @property UnitType $unitType
 * @property UnitHistory[] $unitHistories
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['building_id', 'updated_by', 'owner_id', 'tenant_id', 'unit_type_id', 'created_by','va'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['code', 'unit_floor', 'unit_num', 'building_id'], 'required'],
            [['code', 'unit_floor', 'unit_num', 'space_unit'], 'string'],
            [['space_size', 'power'], 'number'],
            [['isoccupied'], 'boolean'],
            ['code', 'unique']
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
            'building_id' => 'Building Name',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'owner_id' => 'Owner',
            'tenant_id' => 'Tenant ID',
            'unit_type_id' => 'Unit Type ID',
            'code' => 'Code',
            'unit_floor' => 'Unit Floor',
            'unit_num' => 'Unit Num',
            'power' => 'Power',
            'va' => 'Virtual Account',
            'space_size' => 'Space Size',
            'space_unit' => 'Space Unit',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'isoccupied' => 'isoccupied',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Building::className(), ['id' => 'building_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitType()
    {
        return $this->hasOne(UnitType::className(), ['id' => 'unit_type_id']);
    }

    public function getUnitTypeName()
    {
        return $this->unitType ? $this->unitType->name: null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitHistories()
    {
        return $this->hasMany(UnitHistory::className(), ['unit_id' => 'id']);
    }


    public function getUnitCharge()
    {
        return $this->hasMany(UnitCharge::className(), ['unit_id' => 'id']);
    }

    public function getPerson()
    {
        return $this->hasOne(UnitHistory::className(), ['unit_id' => 'id']);
    }

    /**
     * get Owner 
     */
    public function getOwner()
    {
        return $this->hasOne(Person::className(), ['id' => 'owner_id']);
    }

    /**
     * get OwnerName
     */
    public function getOwnerName()
    {
        return $this->owner ? $this->owner->name: null;
    }

    /**
     * get OwnerId
     */
    public function getOwnerId()
    {
        return $this->owner ? $this->owner->id: null;
    }

    /**
     * get Tenant
     */
    public function getTenant()
    {
        return $this->hasOne(Person::className(), ['id' => 'tenant_id']);
    }

    /**
     * get TenantName
     */
    public function getTenantName()
    {
        return $this->tenant ? $this->tenant->name: null;
    }

    /**
     * get TenantId
     */
    public function getTenantId()
    {
        return $this->tenant ? $this->tenant->id: null;
    }

    public function getPowerName()
    {
        return [
            ['value' => '0', 'power' => 'ELISTRIK A'],
            ['value' => '2.2', 'power'  => 'EL2.2KVA'],
            ['value' => '3.5', 'power'  => 'EL3.5KVA'],
            ['value' => '4.4', 'power'  => 'EL4.4KVA'],
            ['value' => '16.5', 'power'  => 'EL16.5KVA'],
            ['value' => '5.0', 'power'  => 'ESOHO5.0KVA'],
            ['value' => '6.6', 'power'  => 'ESOHO6.6KVA'],
            ['value' => '7.0', 'power'  => 'ESOHO7.0KVA'],
        ];
    }

    public function getPowerList()
    {
        return ArrayHelper::map($this->powerName, 'value', 'power');
    }

    public function getPowerLabel($value)
    {
        switch ($value) {
            case '0':
                return 'ELISTRIK A';
                break;
            case '2.2':
                return 'EL2.2KVA';
                break;
            case '3.5':
                return 'EL3.5KVA';
                break;
            case '4.4':
                return 'EL4.4KVA';
                break;
            case '16.5':
                return 'EL16.5KVA';
                break;
            case '5.0':
                return 'ESOHO5.0KVA';
                break;
            case '6.6':
                return 'ESOHO6.6KVA';
                break;
            case '7.0':
                return 'EL7.0KVA';
                break;
            default:
                return null;
                break;
        }
    }
}
