<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pay_billing".
 *
 * @property integer $id
 * @property string $type
 * @property string $unit_code
 * @property integer $unit_charge_value_id
 * @property string $total_charge
 * @property string $total_pay
 * @property string $balance_value
 * @property string $status_pay
 *
 * @property UnitChargeValue $unitChargeValue
 */
class PayBilling extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_billing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_code'], 'string'],
            [['unit_charge_value_id'], 'integer'],
            [['total_pay', 'balance_value'], 'number'],
            [['type', 'inv_number', 'jenis_pembayaran', 'coa_code'], 'string', 'max' => 100],
            [['total_charge'], 'safe'],
            [['status_pay'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'unit_code' => 'Unit Code',
            'unit_charge_value_id' => 'Unit Charge Value ID',
            'total_charge' => 'Total Charge',
            'total_pay' => 'Total Pay',
            'balance_value' => 'Balance Value',
            'status_pay' => 'Status Pay',
            'inv_number' => 'Invoice Number',
            'jenis_pembayaran' => 'Jenis Pembayaran',
            'coa_code'=>'Coa Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitChargeValue()
    {
        return $this->hasOne(UnitChargeValue::className(), ['id' => 'unit_charge_value_id']);
    
    }

    public function getUnitId()
    {
        return $this->hasOne(Unit::className(), ['code' => 'unit_code']);
    
    }

    public function getUnit(){

        return $this->unitChargeValue->unit_code;
    }

    public function getChargeDate()
    {
    
        return $this->UnitChargeValue->charge_date;
    
    }

    public function getTariffPeriod()
    {
        $id = $this->unitChargeValue->unit_charge_id;
        $tarId = UnitCharge::find()->where(['id'=>$id])->one();
        
        $tariff = Tariff::find()->where(['id'=> $tarId['tariff_id']])->one();
        return  $tariff->recur_period;
    }

    
}
