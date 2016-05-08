<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\User;

/**
 * This is the model class for table "property_owner".
 *
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $tax_reg
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $id
 *
 * @property Property[] $properties
 */
class PropertyOwner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_owner';
    }

    /**
     * @inheritdoc
     */
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
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'name', 'address', 'tax_reg'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['created_by', 'updated_by'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'address' => 'Address',
            'tax_reg' => 'Tax Reg',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['property_owner_id' => 'id']);
    }

    public function getStaffCreateName()
    {
        $staff = User::find()->where(['id'=> $this->created_by])->one();
        
        return isset($this->created_by) ? $staff->username : null;
    }

    public function getStaffUpdateName()
    {
        $staff = User::find()->where(['id'=> $this->updated_by])->one();
        
        return isset($this->updated_by) ? $staff->username : null;
    }

}
