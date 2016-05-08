<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "employee".
 *
 * @property integer $idemployee
 * @property string $nip
 * @property string $name_employee
 * @property string $address_employee
 * @property string $phone_employee
 * @property string $email_employee
 * @property string $gender
 * @property string $religion
 * @property string $pob
 * @property integer $dob
 * @property string $section
 * @property string $position
 * @property string $marital_status
 * @property string $work_status
 * @property integer $start_work
 * @property string $photo
 * @property integer $idgroup
 *
 * @property EmployeeGroup $idgroup0
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;

    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nip'], 'required'],
            [['address_employee'], 'string'],
            [['phone_employee'], 'number'],
            [['idgroup'], 'integer'],
            [['nip', 'email_employee', 'section', 'position', 'marital_status', 'work_status'], 'string', 'max' => 100],
            [['name_employee', 'photo'], 'string', 'max' => 256],
            [['gender'], 'string', 'max' => 1],
            [['religion'], 'string', 'max' => 20],
            [['pob'], 'string', 'max' => 30],
            [['file'], 'file', 'extensions' => 'jpg, jpeg, gif, png'],
            [['nip'], 'unique']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idemployee' => 'Idemployee',
            'nip' => 'Nip',
            'name_employee' => 'Name Employee',
            'address_employee' => 'Address Employee',
            'phone_employee' => 'Phone Employee',
            'email_employee' => 'Email Employee',
            'gender' => 'Gender',
            'religion' => 'Religion',
            'pob' => 'Pob',
            'dob' => 'Dob',
            'section' => 'Section',
            'position' => 'Position',
            'marital_status' => 'Marital Status',
            'work_status' => 'Work Status',
            'start_work' => 'Start Work',
            'photo' => 'photo',
            'idgroup' => 'Idgroup',
            'file' => "Foto Karyawan",
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdgroup0()
    {
        return $this->hasOne(EmployeeGroup::className(), ['idgroup' => 'idgroup']);
    }


}
