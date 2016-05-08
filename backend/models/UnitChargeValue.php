<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\models\User;
use backend\models\UnitCharge;
use backend\models\Unit;
use backend\models\MeterRead;
use backend\models\Tariff;
use backend\models\Person;
use backend\models\PersonAddress;
/**
 * This is the model class for table "unit_charge_value".
 *
 * @property integer $id
 * @property string $type
 * @property integer $unit_charge_id
 * @property string $value_charge
 * @property string $value_tax
 * @property string $value_admin
 * @property string $value_penalty
 * @property string $detail
 * @property integer $charge_date
 * @property boolean $overdue
 * @property integer $due_date
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $month
 * @property integer $year
 * @property string $inv_number
 *
 * @property UnitCharge $unitCharge
 */
class UnitChargeValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit_charge_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'unit_charge_id', 'charge_date', 'due_date'], 'required'],
            [['unit_charge_id', 'charge_date', 'due_date', 'created_by', 'created_at', 'updated_by', 'updated_at', 'value_pay','bill_to','charge_month','inv_month'], 'integer'],
            [['value_charge', 'value_tax', 'value_admin', 'value_penalty'], 'number'],
            [['detail', 'status_pay','inv_number','unit_code'], 'string'],
            [['overdue'], 'boolean'],
            [['type'], 'string', 'max' => 100]

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
            'type' => 'Type Charge',
            'unit_charge_id' => 'Unit Charge ID',
            'value_charge' => 'Value Charge',
            'value_tax' => 'Value Tax',
            'value_admin' => 'Value Admin',
            'value_penalty' => 'Value Penalty',
            'detail' => 'Detail',
            'charge_date' => 'Charge Date',
            'overdue' => 'Overdue',
            'due_date' => 'Due Date',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'charge_month' => 'Charge Month',
            'inv_month' => 'Invoice Month',
            'charge_year' => 'Year',
            'status_pay' => 'Status Pay',
            'value_pay' => 'Value Pay',
            'inv_number' => 'Invoice Number',
            'unit_code'=>'Unit Code',
            'bill_to'=> 'Bill To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitCharge()
    {
        return $this->hasOne(UnitCharge::className(), ['id' => 'unit_charge_id']);
    }

    public function getUnit()
    {
        $id = $this->unitCharge->unit_id;
        return Unit::find()->where(['id'=>$id])->all();
    }

    public function getUnitCode()
    {
        $model = $this->unit;
        return $model ? $model[0]->code: '';

        //var_dump($model[0]->code);
        //die();
    }
    

    public function getUnitData(){
        $model = $this->unit;    
        return  $model ? $model[0]->power: '';
    }

    public function getUnitSpace(){
        $model = $this->unit;    
        return  $model ? $model[0]->space_size: '';
    }

    public function getUnitSatuan(){
        $model = $this->unit;    
        return  $model ? $model[0]->space_unit: '';
    }

    public function getPersonId(){

        return $this->hasOne(Person::className(), ['id' => 'bill_to']);
    }

    public function getNamePerson(){

        return $this->personId->name;
    }

    public function getPersonAdd(){
        
        $idperson = $this->personId->id;
        return PersonAddress::find()->where(['person_id'=>$idperson])->One();
        
    }

    public function getAddress(){
        
       return $this->personAdd;
        
    }

    public function getTariff()
    {
        $id = $this->unitCharge->tariff_id;
        return Tariff::find()->where(['id'=>$id])->all();
    }

    public function getTariffPdf()
    {
        $id = $this->unitCharge->tariff_id;
        return Tariff::find()->where(['id'=>$id])->one();
    }

    public function getTariffRecur()
    {
        $model = $this->tariff;
        return $model ? $model[0]->recur_period: '';

        //var_dump($model[0]->code);
        //die();
    }
    
    public function getTariffFormula()
    {
        $model = $this->tariff;
        $model = json_decode($model[0]->formula);
        return $model ? $model->tdl: '';

    }

    public function getTariffAdmin()
    {
        $model = $this->tariff;
        $model = json_decode($model[0]->admin_formula);
        return $model ? $model->value: '';

    }

    public function getPju()
    {
        $model = $this->tariff;
        $model = json_decode($model[0]->formula);
        return $model ? $model->pju: '';

    }    

    
    public function getUsage()
    {
        $idUsage = $this->unitCharge->unit_meter_id;
        $Cmonth = $this->charge_month;
        $Cyear = $this->charge_year;
        return MeterRead::find()->where(['unit_meter_id'=>$idUsage, 'month' => $Cmonth, 'year'=>$Cyear])
        // ->andWhere(['month'=>'charge_month', 'year'=>'charge_year'])
        ->One();
    }        

    public function getUsageDelta()
    {
        $model = $this->usage;
        return $model ? $model->delta: '';
        // return $this->usage->delta;

        // var_dump($model[0]->delta);
        //die();
    }

    public function getUsageAll()
    {
        $idUsage = $this->unitCharge->unit_meter_id;
        $Cmonth = $this->charge_month;
        $Cyear = $this->charge_year;
        return MeterRead::find()->where(['unit_meter_id'=>$idUsage, 'month' => $Cmonth, 'year'=>$Cyear, 'type'=>'Electricity'])
        // ->andWhere(['month'=>'charge_month', 'year'=>'charge_year'])
        ->One();
    }

    public function getUsageAllDetail(){

        return $this->usageAll;

    }


    
}
