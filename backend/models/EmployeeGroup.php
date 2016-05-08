<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_group".
 *
 * @property integer $idgroup
 * @property string $group_name
 * @property integer $basic_salary
 * @property integer $overtime_value
 * @property integer $transport_value
 * @property integer $meal_allow
 * @property string $allowance1
 * @property string $allowance2
 * @property string $allowance3
 *
 * @property Employee[] $employees
 */
class EmployeeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['basic_salary', 'overtime_value', 'transport_value', 'meal_allow'], 'integer'],
            [['allowance1', 'allowance2', 'allowance3'], 'string'],
            [['group_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idgroup' => 'Idgroup',
            'group_name' => 'Group Name',
            'basic_salary' => 'Basic Salary',
            'overtime_value' => 'Overtime Value',
            'transport_value' => 'Transport Value',
            'meal_allow' => 'Meal Allow',
            'allowance1' => 'Allowance1',
            'allowance2' => 'Allowance2',
            'allowance3' => 'Allowance3',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['idgroup' => 'idgroup']);
    }
}
