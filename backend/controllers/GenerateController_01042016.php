<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UnitCharge;
use backend\models\UnitChargeValue;
use backend\models\MeterRead;
use backend\models\Tariff;
use yii\Helpers\ArrayHelper;
use backend\models\UnitMeter;
use backend\models\Unit;
use backend\models\Jurnal;
use backend\models\JurnalChild;
use backend\models\PayBilling;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use backend\models\Coa;
use yii\base\DynamicModel;
/**
 * TariffController implements the CRUD actions for Tariff model.
 */
class GenerateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function findMaxId()
    {
        $maxID = Jurnal::find()->select('MAX(no)')->scalar();

        return $maxID;
    }

    public function generateCode()
    {
        $number = $this->findMaxId()+1;
        
        $code = "EXP-".date('m').date('y').'-'.sprintf("%04s", $number);
        return $code;
    }

    /**
     * Creates a new Tariff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreate()
    {
        $model = new \yii\base\DynamicModel([
            'month', 'year', 'interval', 'month3', 'month6', 'month12'
        ]);
        $model->addRule(['month','year','month3','month6','month12'], 'required');
        $model->addRule(['interval'], 'string');

        $options['bulan'] = [
            '01' => 'January', 
            '02' => 'February', 
            '03' => 'March', 
            '04' => 'April', 
            '05' => 'May', 
            '06' => 'June', 
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
            ];
        $options['bulan3'] = [
            '03' => 'January - March', 
            '06' => 'April - June', 
            '09' => 'July - September',
            '12' => 'October - December',
            ];
        $options['bulan6'] = [
            '06' => 'January - June', 
            '12' => 'July - December',
            ];
        $options['bulan12'] = [
            '12' => 'January - December',
            ];    


        $options['tahun'] =[
        '2015' => '2015',
        '2016' => '2016',
        '2017' => '2017',
        
        ];

        $options['type'] = [
            'ALL' => 'All',    
            'ELECTRICITY' => 'Electricity', 
            'WATER' => 'Water', 
            'SINKINGFUND' => 'Sinking Fund', 
            'SERVICECHARGE' => 'Service Charge', 
            'INTERNET' => ' Internet',
            'TV' => 'TV'
            ];

        $options['interval'] = [
            'MONTHLY' => 'Monthly',    
            '3MONTH' => 'Every 3 Month', 
            '6MONTH' => 'Every 6 Month', 
            'YEARLY' => 'Yearly'            
            ];
            

        if ($model->load(Yii::$app->request->post())) {

                if($model->interval=='MONTHLY'){

                $modelMeter = new MeterRead();
                
                $queryMeter = $modelMeter->find()
                ->where(['month' => $model->month, 'year' => $model->year, 'generate_status' => FALSE])
                ->all();

                if($queryMeter==null) {

                    Yii::$app->session->setFlash('error', 'Bulan Atau Tahun yang ada masukan tidak ada dalam data meter read, Proses generate Gagal');
                    return $this->redirect(['unit-charge-value/index']);

                }
                else{
                        foreach ($queryMeter as $queryMeter) {
                            
                        
                            $getUmId = UnitMeter::findOne($queryMeter->unit_meter_id);
                            $getUnit = Unit::findOne($getUmId->unit_id);
                            $codeUnit = substr($getUnit->code,0,2);
                            
                            $getUnitCharge = UnitCharge::find()
                            ->where(['unit_meter_id' => $getUmId->id])
                            ->One();

                            $getTariff = $getUnitCharge->tariff;
                            $formula = json_decode($getTariff->formula);
                            $formulaAdmin = json_decode($getTariff->admin_formula);

                                if($getTariff->type === 'ELECTRICITY' AND $codeUnit=='OF'){
                                    $tariffValue = $formula->tdl;
                                    $pju = $formula->pju;
                                    $rumus = $formula->formula;
                                    $adminCharge = ($tariffValue * $queryMeter->delta)*($formulaAdmin->value/100); 
                                    $pjuValue = ($tariffValue * $queryMeter->delta)*($pju/100);
                                    $vcharge = ($tariffValue * $queryMeter->delta);
                                    $totalCharge = ($tariffValue * $queryMeter->delta) + $pjuValue + $adminCharge;
                                    $dataCoa = Coa::find()->where(['name' => 'A/R ELECTRICITY'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME ELECTRICITY'])->one();
                     
                                }else if($getTariff->type === 'ELECTRICITY' AND $codeUnit<>'OF'){
                                    $tariffValue = $formula->tdl;
                                    $pju = $formula->pju;
                                    $rumus = $formula->formula;
                                    $adminCharge = ($tariffValue * $queryMeter->delta)*($formulaAdmin->value/100); 
                                    $pjuValue = ($tariffValue * $queryMeter->delta)*($pju/100);
                                    $vcharge = (40*1153)*$getUnit->power;
                                    $totalCharge = $vcharge;
                                    $dataCoa = Coa::find()->where(['name' => 'A/R ELECTRICITY'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME ELECTRICITY'])->one();
                     
                                }
                                else if ($getTariff->type === 'WATER') {
                                    $tariffValue = $formula->tdl;
                                    $rumus = $formula->formula;
                                    $vcharge = ($tariffValue * $queryMeter->delta);
                                    $dataCoa = Coa::find()->where(['name' => 'A/R WATER'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME WATER'])->one();
                                    $totalCharge = $vcharge;
                                    $adminCharge = ($tariffValue * $queryMeter->delta)*($formulaAdmin->value/100);         
                                }
                                // else{
                                    
                                //     $tariffValue = $formula->tdl;
                                //     $rumus = $formula->formula;
                                //     $vcharge = ($tariffValue * $queryMeter->delta);
                                //     $dataCoa = Coa::find()->where(['name' => 'A/R WATER'])->one();
                                //     $dataCoaPiutang = Coa::find()->where(['name' => 'PIUTANG USAHA'])->one();
                                //     $totalCharge = $vcharge;
                                //     $adminCharge = ($tariffValue * $queryMeter->delta)*($formulaAdmin->value/100);                                             

                                // }
                                

                            $taxValueJson = json_decode($getTariff->tax_formula);
                            $taxValue = $taxValueJson->percent;
                            
                            $penaltyValueJson = json_decode($getTariff->penalty_formula);

                                if($penaltyValueJson == null){
                                    $penaltyValue = 0;
                                }else{
                                    $penaltyValue = $penaltyValueJson;
                                }

                            $inv_num = $queryMeter->month.substr($queryMeter->year,2,2).'-'.$getUnitCharge->group_bill.'-'.sprintf("%04s",$getUnit->code);

                            $modelChargeValue =  new UnitChargeValue();
                            $modelChargeValue->type = $getTariff->type;
                            $modelChargeValue->unit_charge_id = $getUnitCharge->id;
                            $modelChargeValue->value_charge = $vcharge;
                            $modelChargeValue->value_tax = ($taxValue/100)*$tariffValue;
                            $modelChargeValue->value_admin = $adminCharge;
                            $modelChargeValue->value_penalty = $penaltyValue;
                            $modelChargeValue->detail = $rumus;
                            $modelChargeValue->charge_date =strtotime($getTariff->recur_date.' '.date('F').' '.date('Y'));
                            $modelChargeValue->due_date = mktime(0,0,0,date('n'),$getTariff->recur_date+20,date('Y'));
                            $modelChargeValue->charge_year = $model->year;
                            $modelChargeValue->charge_month = $model->month;
                            $modelChargeValue->inv_month = $model->month;
                            $modelChargeValue->group_bill = $getUnitCharge->group_bill;
                            $modelChargeValue->bill_to = $getUnitCharge->bill_to;
                            $modelChargeValue->inv_number = $inv_num;
                            $modelChargeValue->unit_code = $getUnit->code;
                            

                            $modelChargeValue->save();
                            

                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $totalCharge;
                            $modelJurnal->credit = $totalCharge;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $modelJurnal->description = $modelChargeValue->type.' '.$modelJurnal->date.' '.$modelChargeValue->unit_code;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();
                            // echo $modelJurnal->id;
                            // die();

                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $dataCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $totalCharge;
                            $modelJurnalChild->dc = 'D';
                            $modelJurnalChild->description = $dataCoa->name.' '.$modelChargeValue->unit_code.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();

                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaPiutang->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $totalCharge;
                            $modelJurnalChild2->dc = 'C';
                            $modelJurnalChild2->description = $dataCoaPiutang->name.' '.$modelChargeValue->type.' '.$modelChargeValue->unit_code.' '.$modelJurnalChild2->date;
                            $modelJurnalChild2->status = '10';

                            $modelJurnalChild2->save();

                            $payModel = new PayBilling();

                            $payModel->type = $getTariff->type;
                            $payModel->unit_code = $getUnit->code;
                            $payModel->unit_charge_value_id = $modelChargeValue->id;
                            $payModel->total_charge = $totalCharge;
                            $payModel->total_pay = 0;
                            $payModel->balance_value = 0;
                            $payModel->status_pay = 'NOK';
                            $payModel->inv_number = $inv_num;
                            $payModel->save();

                            
                            // echo $modelChargeValue->type.'-'.$modelChargeValue->unit_charge_id.'-'.$modelChargeValue->value_charge.'-'.$modelChargeValue->value_tax.'-'.$modelChargeValue->value_admin.'-'.$modelChargeValue->value_penalty.'-'.$modelChargeValue->detail.'-'.$modelChargeValue->charge_date.'-'.$modelChargeValue->due_date.'-'.$modelChargeValue->overdue.'-'.$modelChargeValue->charge_month.'-'.$modelChargeValue->charge_year.'<br />';
                            // echo "-----------------------------------------------------------------------------------------------------------------<br />";
                            $modelUpdateMeter = MeterRead::findOne($queryMeter->id);
                            $modelUpdateMeter->generate_status = 'TRUE';
                            $modelUpdateMeter->update();            
                            // echo $getTariff->type .' : '.$queryMeter->delta .'x' .$tariffValue. ' : '.$vcharge;
                            // echo '<br />';

                        } // foreach query meter
                        
                        // die();
                        // $modelCharge = new Unit();

                        // $queryCharge = $modelCharge->find()
                        // ->all();

                        // foreach ($queryCharge as $queryCharge) {

                        //     $queryOther = Tariff::find()
                        //     ->where(['!=', 'type', 'ELECTRICITY'])
                        //     ->andWhere(['!=', 'type', 'WATER'])
                        //     ->andWhere(['==', 'recur_period', 'MONTH'])
                        //     ->all();

                        //     foreach ($queryOther as $queryOther) {

                        //         $formula2 = json_decode($queryOther->formula);
                        //         if ($queryOther->type == 'SINKINGFUND') {
                        //             $tariffValue2 = $formula2->tdl;
                        //             $rumus2 = null;
                        //             $getUnitCharge2 = UnitCharge::find()
                        //             ->where(['unit_id' => $queryCharge->id])
                        //             ->andWhere(['tariff_id'=> $queryOther->id])
                        //             ->One
                        //             ();    

                        //             $dataCoa = Coa::find()->where(['name' => 'A/R SINKING FUND'])->one();
                        //             $dataCoaPiutang = Coa::find()->where(['name' => 'PIUTANG USAHA'])->one();
                                    
                        //         }
                        //         elseif ($queryOther->type == 'SERVICECHARGE') {
                        //             $tariffValue2 = $formula2->tdl;
                        //             $rumus2 = null;
                        //             $getUnitCharge2 = UnitCharge::find()
                        //             ->where(['unit_id' => $queryCharge->id])
                        //             ->andWhere(['tariff_id'=> $queryOther->id])
                        //             ->One();       

                        //             $dataCoa = Coa::find()->where(['name' => 'A/R IURAN PEMELIHARAAN LINGKUNGAN'])->one();
                        //             $dataCoaPiutang = Coa::find()->where(['name' => 'PIUTANG USAHA'])->one();
                                    
                        //         }

                                
                        //         $taxValueJson2 = json_decode($queryOther->tax_formula);
                        //         $taxValue2 = $taxValueJson2->percent;
                        //         $adminValuePra2 = json_decode($queryOther->admin_formula);
                        //         $adminValue2= $adminValuePra2->value;

                        //         if($adminValue2==null){
                        //             $adminValue2=0;
                        //         }

                        //         $penaltyValueJson2 = json_decode($queryOther->penalty_formula);
                        //         if($penaltyValueJson2 == null){
                        //             $penaltyValue2 = 0;
                        //         }else{
                        //             $penaltyValue2 = $penaltyValueJson2;
                        //         }

                        //         if($getUnitCharge2==null){
                        //             continue;
                        //         }

                        //         $inv_num2 = $model->month.substr($model->year,2,2).'-'.$getUnitCharge2->group_bill.'-'.sprintf("%04s",$queryCharge->code);

                        //         $modelChargeValue2 =  new UnitChargeValue();
                        //         $ddFor2 =$queryOther->recur_date+3;
                        //         // $dueDateFormula2 = strtotime($queryOther->recur_date.' '.date('F').' '.date('Y'))+strtotime($ddFor2.' '.date('F').' '.date('Y'));
                        //         $dueDateFormula2 = mktime(0,0,0,date('n'),$queryOther->recur_date+20,date('Y'));
                        //         $modelChargeValue2->type = $queryOther->type;
                        //         $modelChargeValue2->unit_charge_id = $getUnitCharge2->id;
                        //         $modelChargeValue2->value_charge = $tariffValue2;
                        //         $modelChargeValue2->value_tax = ($taxValue2/100)*$tariffValue2;
                        //         $modelChargeValue2->value_admin = $adminValue2;
                        //         $modelChargeValue2->value_penalty = $penaltyValue2;
                        //         $modelChargeValue2->detail = $rumus2;
                        //         $modelChargeValue2->charge_date =strtotime($queryOther->recur_date.' '.date('F').' '.date('Y'));
                        //         $modelChargeValue2->due_date = $dueDateFormula2;
                        //         $modelChargeValue2->charge_year = $model->year;
                        //         $modelChargeValue2->charge_month = $model->month;
                        //         $modelChargeValue2->group_bill = $getUnitCharge2->group_bill;
                        //         $modelChargeValue2->bill_to = $getUnitCharge2->bill_to;
                        //         $modelChargeValue2->inv_number = $inv_num2;
                        //         $modelChargeValue2->unit_code = $queryCharge->code;
                        //         $modelChargeValue2->save();
                                

                        //         $modelJurnalNoNumber = new Jurnal();
                        //         $modelJurnalNoNumber->debit = $totalCharge;
                        //         $modelJurnalNoNumber->credit = $totalCharge;
                        //         $modelJurnalNoNumber->date = date('Y-m-d');
                        //         $modelJurnalNoNumber->code = $this->generateCode();
                        //         $modelJurnalNoNumber->no = $this->findMaxId()+1;
                        //         $modelJurnalNoNumber->description = $modelChargeValue2->type.' '.$modelJurnalNoNumber->date.' '.$modelChargeValue->unit_code;
                        //         $modelJurnalNoNumber->status = '10';

                        //         $modelJurnalNoNumber->save();

                        //         $modelJurnalChildNoNumber = new JurnalChild();

                        //         $modelJurnalChildNoNumber->id_jur = $modelJurnalNoNumber->id;
                        //         $modelJurnalChildNoNumber->id_coa = $dataCoa->id;
                        //         $modelJurnalChildNoNumber->date = date('Y-m-d');
                        //         $modelJurnalChildNoNumber->amount = $totalCharge;
                        //         $modelJurnalChildNoNumber->dc = 'D';
                        //         $modelJurnalChildNoNumber->description = $dataCoa->name.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber->date;
                        //         $modelJurnalChildNoNumber->status = '10';

                        //         $modelJurnalChildNoNumber->save();

                        //         $modelJurnalChildNoNumber2 = new JurnalChild();

                        //         $modelJurnalChildNoNumber2->id_jur = $modelJurnalNoNumber->id;
                        //         $modelJurnalChildNoNumber2->id_coa = $dataCoaPiutang->id;
                        //         $modelJurnalChildNoNumber2->date = date('Y-m-d');
                        //         $modelJurnalChildNoNumber2->amount = $totalCharge;
                        //         $modelJurnalChildNoNumber2->dc = 'C';
                        //         $modelJurnalChildNoNumber2->description = $dataCoaPiutang->name.' '.$modelChargeValue2->type.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber2->date;

                        //         $modelJurnalChildNoNumber2->status = '10';

                        //         $modelJurnalChildNoNumber2->save();
                        //     } // foreach queryOther

                            
                        // } // foreach queryCharge

                            return $this->redirect(['unit-charge-value/invoice']);     
                    }

                }

                else if($model->interval=='3MONTH'){
                
                        
                        $cekTariff = Tariff::find()->where(['=', 'recur_period', '3MONTH'])->count();

                        
                        if($cekTariff <= 0 ){
                            Yii::$app->session->setFlash('error', 'Tidak ada Tagihan Dengan Interval 3 Bulan');
                            return $this->redirect(['generate/create']);
                        }else{
                        
                        $queryCharge = UnitCharge::find()
                        ->joinWith('tariff')
                        ->where(['recur_period'=>'3MONTH'])
                        ->all();

                        foreach ($queryCharge as $queryCharge) {

                               $cekCount = UnitChargeValue::find()->where(['charge_month'=>$model->month3, 'type'=>$queryCharge->type, 'unit_code'=>$queryCharge->unit->code])->count();
                                
                               

                                if($cekCount<=0){

                                $formula2 = json_decode($queryCharge->tariff->formula);
                                if ($queryCharge->type == 'SINKINGFUND') {
                                    $tariffValue2 = ($formula2->tdl*3)*$queryCharge->unit->space_size;
                                    $rumus2 = null;
                                    
                                    $dataCoa = Coa::find()->where(['name' => 'A/R SINKINGFUND'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME SINKINGFUND'])->one();
                                    
                                }
                                elseif ($queryCharge->type == 'SERVICECHARGE') {
                                    
                                    $tariffValue2 = ($formula2->tdl*3)*$queryCharge->unit->space_size;
                                    $rumus2 = null;
                                    

                                    $dataCoa = Coa::find()->where(['name' => 'A/R IURAN PEMELIHARAAN LINGKUNGAN'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME IURAN PEMELIHARAAN LINGKUNGAN'])->one();
                                    
                                }

                                $taxValueJson2 = json_decode($queryCharge->tariff->tax_formula);
                                $taxValue2 = $tariffValue2*($taxValueJson2->percent/100);
                                $adminValuePra2 = json_decode($queryCharge->tariff->admin_formula);
                                $adminValue2= $tariffValue2*($adminValuePra2->value/100);

                                if($adminValue2==null){
                                    $adminValue2=0;
                                }

                                $penaltyValueJson2 = json_decode($queryCharge->tariff->penalty_formula);
                                if($penaltyValueJson2 == null){
                                    $penaltyValue2 = 0;
                                }else{
                                    $penaltyValue2 = $penaltyValueJson2;
                                }

                                
                                $inv_num2 = date('m').substr($model->year,2,2).'-'.$queryCharge->group_bill.'-'.sprintf("%04s",$queryCharge->unit->code);

                                $inv_month=$model->month3-2;
                              
                                $modelChargeValue2 =  new UnitChargeValue();

                                $ddFor2 =$queryCharge->tariff->recur_date+3;
                                

                                // $dueDateFormula2 = strtotime($queryCharge->recur_date.' '.date('F').' '.date('Y'))+strtotime($ddFor2.' '.date('F').' '.date('Y'));
                                $dueDateFormula2 = mktime(0,0,0,$inv_month,$queryCharge->tariff->recur_date+20,date('Y'));
                                $modelChargeValue2->type = $queryCharge->tariff->type;
                                $modelChargeValue2->unit_charge_id = $queryCharge->id;
                                $modelChargeValue2->value_charge = $tariffValue2;
                                $modelChargeValue2->value_tax = ($taxValue2/100)*$tariffValue2;
                                $modelChargeValue2->value_admin = $adminValue2;
                                $modelChargeValue2->value_penalty = $penaltyValue2;
                                $modelChargeValue2->detail = $rumus2;
                                $modelChargeValue2->charge_date =strtotime($queryCharge->tariff->recur_date.'.'.$inv_month.'.'.date('Y'));
                                $modelChargeValue2->due_date = $dueDateFormula2;
                                $modelChargeValue2->charge_year = $model->year;
                                $modelChargeValue2->charge_month = $model->month3;
                                $modelChargeValue2->inv_month = $inv_month;
                                $modelChargeValue2->group_bill = $queryCharge->group_bill;
                                $modelChargeValue2->bill_to = $queryCharge->bill_to;
                                $modelChargeValue2->inv_number = $inv_num2;
                                $modelChargeValue2->unit_code = $queryCharge->unit->code;
                                $modelChargeValue2->save();
                               
                                $totalCharge = $tariffValue2+$adminValue2+$modelChargeValue2->value_tax;

                                $modelJurnalNoNumber = new Jurnal();
                                $modelJurnalNoNumber->debit = $totalCharge;
                                $modelJurnalNoNumber->credit = $totalCharge;
                                $modelJurnalNoNumber->date = date('Y-m-d');
                                $modelJurnalNoNumber->code = $this->generateCode();
                                $modelJurnalNoNumber->no = $this->findMaxId()+1;
                                $modelJurnalNoNumber->description = $modelChargeValue2->type.' '.$modelJurnalNoNumber->date.' '.$modelChargeValue2->unit_code;
                                $modelJurnalNoNumber->status = '10';

                                $modelJurnalNoNumber->save();

                                $modelJurnalChildNoNumber = new JurnalChild();

                                $modelJurnalChildNoNumber->id_jur = $modelJurnalNoNumber->id;
                                $modelJurnalChildNoNumber->id_coa = $dataCoa->id;
                                $modelJurnalChildNoNumber->date = date('Y-m-d');
                                $modelJurnalChildNoNumber->amount = $totalCharge;
                                $modelJurnalChildNoNumber->dc = 'D';
                                $modelJurnalChildNoNumber->description = $dataCoa->name.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber->date;
                                $modelJurnalChildNoNumber->status = '10';

                                $modelJurnalChildNoNumber->save();

                                $modelJurnalChildNoNumber2 = new JurnalChild();

                                $modelJurnalChildNoNumber2->id_jur = $modelJurnalNoNumber->id;
                                $modelJurnalChildNoNumber2->id_coa = $dataCoaPiutang->id;
                                $modelJurnalChildNoNumber2->date = date('Y-m-d');
                                $modelJurnalChildNoNumber2->amount = $totalCharge;
                                $modelJurnalChildNoNumber2->dc = 'C';
                                $modelJurnalChildNoNumber2->description = $dataCoaPiutang->name.' '.$modelChargeValue2->type.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber2->date;
                                $modelJurnalChildNoNumber2->status = '10';

                                $modelJurnalChildNoNumber2->save();

                                $payModel = new PayBilling();

                                $payModel->type = $queryCharge->tariff->type;
                                $payModel->unit_code = $queryCharge->unit->code;
                                $payModel->unit_charge_value_id = $modelChargeValue2->id;
                                $payModel->total_charge = $totalCharge;
                                $payModel->total_pay = 0;
                                $payModel->balance_value = 0;
                                $payModel->status_pay = 'NOK';
                                $payModel->inv_number = $inv_num2;
                                $payModel->save();


                                }

                                else{

                                    Yii::$app->session->setFlash('error', 'Tagihan 3 Bulan Sudah dilakukan Proses Generate Atau tidak ada Tagihan Dengan Interval 3 Bulan');
                                    return $this->redirect(['generate/create']);

                                }

                               // echo $queryCharge->tariff_id.'--'.$queryCharge->unit_id.'<br />';

                            // } // foreach queryOther

                            
                        } // foreach queryCharge
                        

                        return $this->redirect(['unit-charge-value/invoice']);     
                    
                        }
                        
                }//end of interval 3 month

                else if($model->interval=='6MONTH'){
                
                        $cekTariff = Tariff::find()->where(['=', 'recur_period', '6MONTH'])->count();
                        
                        if($cekTariff <= 0 ){
                            Yii::$app->session->setFlash('error', 'Tidak ada Tagihan Dengan Interval 6 Bulan');
                            return $this->redirect(['generate/create']);
                        }else{
                        
                        $queryCharge = UnitCharge::find()
                        ->joinWith('tariff')
                        ->where(['recur_period'=>'6MONTH'])
                        ->all();

                        foreach ($queryCharge as $queryCharge) {

                                $cekCount = UnitChargeValue::find()->where(['charge_month'=>$model->month6, 'type'=>$queryCharge->type, 'unit_code'=>$queryCharge->unit->code])->count();
                         
                                if($cekCount<=0){

                                $formula2 = json_decode($queryCharge->tariff->formula);
                                if ($queryCharge->type == 'SINKINGFUND') {
                                    $tariffValue2 = ($formula2->tdl*6)*$queryCharge->unit->space_size;
                                    $rumus2 = null;
                                    
                                    $dataCoa = Coa::find()->where(['name' => 'A/R SINKINGFUND'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME SINKINGFUND'])->one();
                                    
                                }
                                elseif ($queryCharge->type == 'SERVICECHARGE') {
                                    
                                    $tariffValue2 = ($formula2->tdl*6)*$queryCharge->unit->space_size;
                                    $rumus2 = null;
                                    

                                    $dataCoa = Coa::find()->where(['name' => 'A/R IURAN PEMELIHARAAN LINGKUNGAN'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME IURAN PEMELIHARAAN LINGKUNGAN'])->one();
                                    
                                }

                                $taxValueJson2 = json_decode($queryCharge->tariff->tax_formula);
                                $taxValue2 = $tariffValue2*($taxValueJson2->percent/100);
                                $adminValuePra2 = json_decode($queryCharge->tariff->admin_formula);
                                $adminValue2= $tariffValue2*($adminValuePra2->value/100);

                                if($adminValue2==null){
                                    $adminValue2=0;
                                }

                                $penaltyValueJson2 = json_decode($queryCharge->tariff->penalty_formula);
                                if($penaltyValueJson2 == null){
                                    $penaltyValue2 = 0;
                                }else{
                                    $penaltyValue2 = $penaltyValueJson2;
                                }

                                
                                $inv_num2 = date('m').substr($model->year,2,2).'-'.$queryCharge->group_bill.'-'.sprintf("%04s",$queryCharge->unit->code);

                                $modelChargeValue2 =  new UnitChargeValue();

                                $ddFor2 =$queryCharge->tariff->recur_date+3;
                                $inv_month = $model->month6-5;

                                // $dueDateFormula2 = strtotime($queryCharge->recur_date.' '.date('F').' '.date('Y'))+strtotime($ddFor2.' '.date('F').' '.date('Y'));
                                $dueDateFormula2 = mktime(0,0,0,$inv_month,$queryCharge->tariff->recur_date+20,date('Y'));
                                $modelChargeValue2->type = $queryCharge->tariff->type;
                                $modelChargeValue2->unit_charge_id = $queryCharge->id;
                                $modelChargeValue2->value_charge = $tariffValue2;
                                $modelChargeValue2->value_tax = ($taxValue2/100)*$tariffValue2;
                                $modelChargeValue2->value_admin = $adminValue2;
                                $modelChargeValue2->value_penalty = $penaltyValue2;
                                $modelChargeValue2->detail = $rumus2;
                                $modelChargeValue2->charge_date =strtotime($queryCharge->tariff->recur_date.'.'.$inv_month.'.'.date('Y'));
                                $modelChargeValue2->due_date = $dueDateFormula2;
                                $modelChargeValue2->charge_year = $model->year;
                                $modelChargeValue2->charge_month = $model->month6;
                                $modelChargeValue2->inv_month = $inv_month;
                                $modelChargeValue2->group_bill = $queryCharge->group_bill;
                                $modelChargeValue2->bill_to = $queryCharge->bill_to;
                                $modelChargeValue2->inv_number = $inv_num2;
                                $modelChargeValue2->unit_code = $queryCharge->unit->code;
                                $modelChargeValue2->save();

                               
                                $totalCharge = $tariffValue2+$adminValue2+$modelChargeValue2->value_tax;


                                $payModel = new PayBilling();

                                $payModel->type = $queryCharge->tariff->type;
                                $payModel->unit_code = $queryCharge->unit->code;
                                $payModel->unit_charge_value_id = $modelChargeValue2->id;
                                $payModel->total_charge = $totalCharge;
                                $payModel->total_pay = 0;
                                $payModel->balance_value = 0;
                                $payModel->status_pay = 'NOK';
                                $payModel->inv_number = $inv_num2;
                                $payModel->save();

                                $modelJurnalNoNumber = new Jurnal();
                                $modelJurnalNoNumber->debit = $totalCharge;
                                $modelJurnalNoNumber->credit = $totalCharge;
                                $modelJurnalNoNumber->date = date('Y-m-d');
                                $modelJurnalNoNumber->code = $this->generateCode();
                                $modelJurnalNoNumber->no = $this->findMaxId()+1;
                                $modelJurnalNoNumber->description = $modelChargeValue2->type.' '.$modelJurnalNoNumber->date.' '.$modelChargeValue2->unit_code;
                                $modelJurnalNoNumber->status = '10';

                                $modelJurnalNoNumber->save();

                                $modelJurnalChildNoNumber = new JurnalChild();

                                $modelJurnalChildNoNumber->id_jur = $modelJurnalNoNumber->id;
                                $modelJurnalChildNoNumber->id_coa = $dataCoa->id;
                                $modelJurnalChildNoNumber->date = date('Y-m-d');
                                $modelJurnalChildNoNumber->amount = $totalCharge;
                                $modelJurnalChildNoNumber->dc = 'D';
                                $modelJurnalChildNoNumber->description = $dataCoa->name.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber->date;
                                $modelJurnalChildNoNumber->status = '10';

                                $modelJurnalChildNoNumber->save();

                                $modelJurnalChildNoNumber2 = new JurnalChild();

                                $modelJurnalChildNoNumber2->id_jur = $modelJurnalNoNumber->id;
                                $modelJurnalChildNoNumber2->id_coa = $dataCoaPiutang->id;
                                $modelJurnalChildNoNumber2->date = date('Y-m-d');
                                $modelJurnalChildNoNumber2->amount = $totalCharge;
                                $modelJurnalChildNoNumber2->dc = 'C';
                                $modelJurnalChildNoNumber2->description = $dataCoaPiutang->name.' '.$modelChargeValue2->type.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber2->date;
                                $modelJurnalChildNoNumber2->status = '10';

                                $modelJurnalChildNoNumber2->save();
                                

                                }

                                else{

                                    Yii::$app->session->setFlash('error', 'Tagihan 6 Bulan Sudah dilakukan Proses Generate Atau tidak ada Tagihan Dengan Interval 6 Bulan');
                                    return $this->redirect(['generate/create']);

                                }

                               // echo $queryCharge->tariff_id.'--'.$queryCharge->unit_id.'<br />';

                            // } // foreach queryOther

                            
                        } // foreach queryCharge
                        

                        return $this->redirect(['unit-charge-value/invoice']);     
                    
                        }
                        
                }//end of interval 6 month


                else if($model->interval=='YEARLY'){
                
                        $cekTariff = Tariff::find()->where(['=', 'recur_period', 'YEAR'])->count();
                        
                        if($cekTariff <= 0 ){
                            Yii::$app->session->setFlash('error', 'Tidak ada Tagihan Dengan Interval 1 Tahun');
                            return $this->redirect(['generate/create']);
                        }else{
                        
                        $queryCharge = UnitCharge::find()
                        ->joinWith('tariff')
                        ->where(['recur_period'=>'YEAR'])
                        ->all();

                        foreach ($queryCharge as $queryCharge) {

                                $cekCount = UnitChargeValue::find()->where(['charge_month'=>$model->month12, 'type'=>$queryCharge->type, 'unit_code'=>$queryCharge->unit->code])->count();
                                

                                if($cekCount<=0){

                                $formula2 = json_decode($queryCharge->tariff->formula);
                                if ($queryCharge->type == 'SINKINGFUND') {
                                    $tariffValue2 = ($formula2->tdl*12)*$queryCharge->unit->space_size;
                                    $rumus2 = null;
                                    
                                    $dataCoa = Coa::find()->where(['name' => 'A/R SINKINGFUND'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME SINKINGFUND'])->one();
                                    
                                }
                                elseif ($queryCharge->type == 'SERVICECHARGE') {
                                    
                                    $tariffValue2 = ($formula2->tdl*12)*$queryCharge->unit->space_size;
                                    $rumus2 = null;
                                    

                                    $dataCoa = Coa::find()->where(['name' => 'A/R IURAN PEMELIHARAAN LINGKUNGAN'])->one();
                                    $dataCoaPiutang = Coa::find()->where(['name' => 'INCOME IURAN PEMELIHARAAN LINGKUNGAN'])->one();
                                    
                                }

                                $taxValueJson2 = json_decode($queryCharge->tariff->tax_formula);
                                $taxValue2 = $tariffValue2*($taxValueJson2->percent/100);
                                $adminValuePra2 = json_decode($queryCharge->tariff->admin_formula);
                                $adminValue2= $tariffValue2*($adminValuePra2->value/100);

                                if($adminValue2==null){
                                    $adminValue2=0;
                                }

                                $penaltyValueJson2 = json_decode($queryCharge->tariff->penalty_formula);
                                if($penaltyValueJson2 == null){
                                    $penaltyValue2 = 0;
                                }else{
                                    $penaltyValue2 = $penaltyValueJson2;
                                }

                                
                                $inv_num2 = date('m').substr($model->year,2,2).'-'.$queryCharge->group_bill.'-'.sprintf("%04s",$queryCharge->unit->code);

                                $modelChargeValue2 =  new UnitChargeValue();
                                $ddFor2 =$queryCharge->tariff->recur_date+3;
                                $inv_month = $model->month12-11;

                                // $dueDateFormula2 = strtotime($queryCharge->recur_date.' '.date('F').' '.date('Y'))+strtotime($ddFor2.' '.date('F').' '.date('Y'));
                                $dueDateFormula2 = mktime(0,0,0,$inv_month,$queryCharge->tariff->recur_date+20,date('Y'));
                                $modelChargeValue2->type = $queryCharge->tariff->type;
                                $modelChargeValue2->unit_charge_id = $queryCharge->id;
                                $modelChargeValue2->value_charge = $tariffValue2;
                                $modelChargeValue2->value_tax = ($taxValue2/100)*$tariffValue2;
                                $modelChargeValue2->value_admin = $adminValue2;
                                $modelChargeValue2->value_penalty = $penaltyValue2;
                                $modelChargeValue2->detail = $rumus2;
                                $modelChargeValue2->charge_date =strtotime($queryCharge->tariff->recur_date.'.'.$inv_month.'.'.date('Y'));
                                $modelChargeValue2->due_date = $dueDateFormula2;
                                $modelChargeValue2->charge_year = $model->year;
                                $modelChargeValue2->charge_month = $model->month12;
                                $modelChargeValue2->inv_month = $inv_month;
                                $modelChargeValue2->group_bill = $queryCharge->group_bill;
                                $modelChargeValue2->bill_to = $queryCharge->bill_to;
                                $modelChargeValue2->inv_number = $inv_num2;
                                $modelChargeValue2->unit_code = $queryCharge->unit->code;
                                $modelChargeValue2->save();
                               
                                $totalCharge = $tariffValue2+$adminValue2+$modelChargeValue2->value_tax;

                                $modelJurnalNoNumber = new Jurnal();
                                $modelJurnalNoNumber->debit = $totalCharge;
                                $modelJurnalNoNumber->credit = $totalCharge;
                                $modelJurnalNoNumber->date = date('Y-m-d');
                                $modelJurnalNoNumber->code = $this->generateCode();
                                $modelJurnalNoNumber->no = $this->findMaxId()+1;
                                $modelJurnalNoNumber->description = $modelChargeValue2->type.' '.$modelJurnalNoNumber->date.' '.$modelChargeValue2->unit_code;
                                $modelJurnalNoNumber->status = '10';

                                $modelJurnalNoNumber->save();

                                $modelJurnalChildNoNumber = new JurnalChild();

                                $modelJurnalChildNoNumber->id_jur = $modelJurnalNoNumber->id;
                                $modelJurnalChildNoNumber->id_coa = $dataCoa->id;
                                $modelJurnalChildNoNumber->date = date('Y-m-d');
                                $modelJurnalChildNoNumber->amount = $totalCharge;
                                $modelJurnalChildNoNumber->dc = 'D';
                                $modelJurnalChildNoNumber->description = $dataCoa->name.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber->date;
                                $modelJurnalChildNoNumber->status = '10';

                                $modelJurnalChildNoNumber->save();

                                $modelJurnalChildNoNumber2 = new JurnalChild();

                                $modelJurnalChildNoNumber2->id_jur = $modelJurnalNoNumber->id;
                                $modelJurnalChildNoNumber2->id_coa = $dataCoaPiutang->id;
                                $modelJurnalChildNoNumber2->date = date('Y-m-d');
                                $modelJurnalChildNoNumber2->amount = $totalCharge;
                                $modelJurnalChildNoNumber2->dc = 'C';
                                $modelJurnalChildNoNumber2->description = $dataCoaPiutang->name.' '.$modelChargeValue2->type.' '.$modelChargeValue2->unit_code.' '.$modelJurnalChildNoNumber2->date;
                                $modelJurnalChildNoNumber2->status = '10';

                                $modelJurnalChildNoNumber2->save();

                                $payModel = new PayBilling();

                                $payModel->type = $queryCharge->tariff->type;
                                $payModel->unit_code = $queryCharge->unit->code;
                                $payModel->unit_charge_value_id = $modelChargeValue2->id;
                                $payModel->total_charge = $totalCharge;
                                $payModel->total_pay = 0;
                                $payModel->balance_value = 0;
                                $payModel->status_pay = 'NOK';
                                $payModel->inv_number = $inv_num2;
                                $payModel->save();


                                }

                                else{

                                    Yii::$app->session->setFlash('error', 'Tagihan 6 Bulan Sudah dilakukan Proses Generate Atau tidak ada Tagihan Dengan Interval 6 Bulan');
                                    return $this->redirect(['generate/create']);

                                }

                               // echo $queryCharge->tariff_id.'--'.$queryCharge->unit_id.'<br />';

                            // } // foreach queryOther

                            
                        } // foreach queryCharge
                        

                        return $this->redirect(['unit-charge-value/invoice']);     
                    
                        }
                            
                        
                }//end of interval 1 Year
                                
        }
        
        else {
            return $this->render('_form', [
                'model' => $model,
                'options' => $options
            ]);
        }

    }

}
