<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_transaction".
 *
 * @property integer $id_transaction
 * @property integer $idemployee
 * @property integer $atten_day
 * @property integer $overtime_day
 * @property integer $debt_value
 *
 * @property Employee $idemployee0
 */
class EmployeeTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemployee'], 'required'],
            [['idemployee', 'atten_day', 'overtime_day', 'debt_value', 'emp_trans_month'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_transaction' => 'Id Transaction',
            'idemployee' => 'Idemployee',
            'atten_day' => 'Attendance Day',
            'overtime_day' => 'Overtime Day',
            'debt_value' => 'Debt Value',
            'emp_trans_month' => 'Month',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdemployee()
    {
        return $this->hasOne(Employee::className(), ['idemployee' => 'idemployee']);
    }
}
