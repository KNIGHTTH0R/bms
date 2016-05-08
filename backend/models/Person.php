<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property string $name
 * @property boolean $is_company
 * @property string $tax_reg
 * @property string $detail_person
 * @property string $detail_private
 *
 * @property PersonAddress[] $personAddresses
 * @property UnitHistory[] $unitHistories
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'tax_reg', 'detail_person', 'person_code'], 'string'],
            ['person_code', 'unique'],
            [['is_company'], 'boolean']
        ];
    }

   /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_company' => 'Is Company',
            'tax_reg' => 'Tax Reg',
            'detail_person' => 'Detail Person',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonAddresses()
    {
        return $this->hasMany(PersonAddress::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitHistories()
    {
        return $this->hasMany(UnitHistory::className(), ['person_id' => 'id']);
    }

    /**
     * get Unit Owner
     */
    public function getUnitOwner()
    {
        return $this->hasMany(Unit::className(), ['owner_id' => 'id']);
    }

    /**
     * get Unit Tenant
     */
    public function getUnitTenant()
    {
        return $this->hasMany(Unit::className(), ['tenant_id' => 'id']);
    }
}
