<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "person_address".
 *
 * @property integer $id
 * @property integer $person_id
 * @property string $postal_code
 * @property string $phone
 * @property string $fax
 * @property string $name
 * @property boolean $for_billing
 * @property boolean $for_letternotif
 * @property string $building
 * @property string $street
 * @property string $city
 * @property string $province
 * @property string $country
 *
 * @property Person $person
 */
class PersonAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['person_id'], 'integer'],
            [['postal_code', 'phone', 'fax', 'email', 'name', 'building', 'street', 'city', 'province', 'country'], 'string'],
            [['for_billing', 'for_letternotif'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'postal_code' => 'Postal Code',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'name' => 'Name',
            'for_billing' => 'For Billing',
            'for_letternotif' => 'For Letternotif',
            'building' => 'Building',
            'street' => 'Street',
            'city' => 'City',
            'province' => 'Province',
            'country' => 'Country',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }
}
