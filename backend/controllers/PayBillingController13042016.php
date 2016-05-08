<?php

namespace backend\controllers;

use Yii;
use backend\models\PayBilling;
use backend\models\PayBillingSearch;
use backend\models\UnitChargeValue;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Jurnal;
use backend\models\JurnalChild;
use backend\models\Coa;
use backend\models\CoaType;
use backend\models\DepositTb;
/**
 * PayBillingController implements the CRUD actions for PayBilling model.
 */
class PayBillingController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PayBilling models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayBillingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayBilling model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PayBilling model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLists($id)
     {
         $countPosts = \backend\models\Coa::find()
             ->where(['name' => $id])
             ->count();

         $postAwal=\backend\models\Coa::find()->where(['name'=>$id])->one();

         $posts = \backend\models\Coa::find()
             ->where(['parent_id' => $postAwal->id])
             ->orderBy('id DESC')
             ->all();
         
         if($countPosts>0){
            echo "<option value=''>- Choose COA -</option>";
            echo "<option value=''>None</option>";
                 foreach($posts as $post){
                    echo "<option value='".$post->code."'>".$post->name." ( ".$post->code." )</option>";
                 }
             }
             else if($countPosts<=0){
             echo "<option value=''>- Choose COA -</option>";
             echo "<option value=''>None</option>";
         }
     


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
     * Updates an existing PayBilling model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /*

    Membuat action baru yang menggabungkan seluruh jenis charge dalam satu invoice
    jika sudah berhasil hapus function createnya..
    
    */
    public function actionPay($invnumber){

        $options = array('payMetod' => [
            'CASH' => 'Cash', 
            'BANK' => 'Transfer', 
            'EBANKING' => 'Ebanking'            
            ] );
        
        $model = PayBilling::find()->where(['inv_number'=>$invnumber])->one();
        $modelTambah = new UnitChargeValue();
        $dataDeposit = new DepositTb();
        
        if ($model->load(Yii::$app->request->post())) {

            $modelTambah = new UnitChargeValue();
            $modelCoa = new CoaType();
            $findCoa = Coa::find()->where(['name'=>'TENANT DEPOSIT'])->one();
            $findCoaAdmin = Coa::find()->where(['name'=>'TENANT DEPOSIT'])->one();
            $dataCoaDeposit = Coa::find()->where(['name' => 'PIUTANG LAIN-LAIN'])->one();

            if ($modelTambah->load(Yii::$app->request->post())) {

                $dataDeposit->load(Yii::$app->request->post());
                
                if($dataDeposit->explan==TRUE){

                     
                     $model->total_pay = str_replace('.', '', $model->total_pay);
                     
                     $newDeposit = ($model->total_pay + $dataDeposit->deposit_value) - $modelTambah->value_charge;
                     
                     if($newDeposit < 0 ){

                        $newDeposit =  $model->total_pay + $dataDeposit->deposit_value;

                     }else if($newDeposit == 0) {

                        $newDeposit = 0;    

                     }else if($newDeposit > 0){
                         $newDeposit = $newDeposit;   
                     }

                     // $dataDeposit = DepositTb::find()->where(['unit_id'=>$dataDeposit->unit_id])->one();
                     
                     // $dataDeposit->deposit_value = $newDeposit;
                     // $dataDeposit->update();


                     if($model->total_pay < $modelTambah->value_charge){
                        
                        $modelDeposit = new DepositTb();
                        $modelDeposit->unit_id = $model->unitId->id;
                        $modelDeposit->deposit_value = $newDeposit;
                        $modelDeposit->save();
                        // $modelDeposit->explan = 'Deposit Pembayaran inv '.$model->inv_number;

                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $model->total_pay;
                            $modelJurnal->credit = $model->total_pay;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $modelJurnal->description = 'Deposit Invoice '.$model->inv_number.' '.$modelJurnal->date;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();
        
                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $findCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $model->total_pay;
                            $modelJurnalChild->dc = 'C';
                            $modelJurnalChild->description = 'Deposit Invoice '.$model->inv_number.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();

                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaDeposit->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $pecahModel->value_charge;
                            $modelJurnalChild2->dc = 'D';
                            $modelJurnalChild2->description = $findCoa->name.' pada Deposit Invoice '.$model->inv_number.' '.$modelJurnalChild2->date;
                            
                            $modelJurnalChild2->status = '10';

                            $modelJurnalChild2->save();

                            Yii::$app->session->setFlash('success', "Processed Pay successfully.");
                            
                            $sqlPay="SELECT * FROM pay_billing where inv_number='$invnumber' AND status_receipt=0";
                            $modelReceipt=PayBilling::findBySql($sqlPay)->all();

                            $sqlPay2="SELECT * FROM pay_billing where inv_number='$invnumber'";
                            $modelReceipt2=PayBilling::findBySql($sqlPay2)->ONE();

                            $modelPrintDeposit = $model->total_pay;

                            return $this->render('deposit', [
                                'model' => $modelReceipt,
                                'model2'=> $modelReceipt2,
                                'modelDeposit' => $modelPrintDeposit,
                            ]); // redirect to your next desired page

                    }

                    else if($model->total_pay == $modelTambah->value_charge){

                        $pecahModel = UnitChargeValue::find()->where(['inv_number'=>$model->inv_number])->all();
                        $dataDeposit = DepositTb::find()->where(['unit_id'=>$dataDeposit->unit_id])->one();
                     
                        $dataDeposit->deposit_value = $newDeposit;
                        $dataDeposit->update();
                        
                        foreach ($pecahModel as $pecahModel) {
                            
                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $pecahModel->value_charge;
                            $modelJurnal->credit = $pecahModel->value_charge;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $modelJurnal->description = $pecahModel->type.' '.$modelJurnal->date.' '.$pecahModel->unit_code;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();
                            $dataCoa = Coa::find()->where(['code' => $model->coa_code])->one();
                            $dataCoaBayar = Coa::find()->where(['name' => 'A/R '.$pecahModel->type])->one();
                            // echo $modelJurnal->id;
                            // die();

                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $dataCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $pecahModel->value_charge;
                            $modelJurnalChild->dc = 'D';
                            $modelJurnalChild->description = $dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();

                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaBayar->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $pecahModel->value_charge;
                            $modelJurnalChild2->dc = 'C';
                            $modelJurnalChild2->description = 'A/R'. $pecahModel->type.' '.$dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild2->date;
                            
                            $modelJurnalChild2->status = '10';

                            $modelJurnalChild2->save();

                            $pecahModel->status_pay = 'OK';
                            $pecahModel->update();

                            $modelPayBill = PayBilling::find()->where(['unit_charge_value_id'=>$pecahModel->id])->one();
                            $modelPayBill->status_pay = 'OK';
                            $modelPayBill->total_pay = $pecahModel->value_charge;
                            $modelPayBill->balance_value = $modelPayBill->total_pay - $modelPayBill->total_charge;
                            $modelPayBill->jenis_pembayaran = $model->jenis_pembayaran;
                            $modelPayBill->coa_code = $model->coa_code;
                            $modelPayBill->update();

                            /* Jika sudah menemukan format yg pas untuk memasukan biaya admin ke dalam coa baris kode ini di aktfikan

                            if($modelTambah->value_admin>0){

                            }else{

                            }

                            */
                        }

                        Yii::$app->session->setFlash('success', "Processed Pay successfully.");
                        

                        $sqlPay="SELECT * FROM pay_billing where inv_number='$invnumber' AND status_pay='OK' AND status_receipt=0";
                        $modelReceipt=PayBilling::findBySql($sqlPay)->all();

                        $sqlPay2="SELECT * FROM pay_billing where inv_number='$invnumber'";
                        $modelReceipt2=PayBilling::findBySql($sqlPay2)->ONE();
                        
                        return $this->render('receipt', [
                            'model' => $modelReceipt,
                            'model2'=> $modelReceipt2,
                        ]); // redirect to your next desired page

                    }

                    else if($model->total_pay > $modelTambah->value_charge){

                        $pecahModel = UnitChargeValue::find()->where(['inv_number'=>$model->inv_number])->all();
                        

                        $dataDeposit = DepositTb::find()->where(['unit_id'=>$dataDeposit->unit_id])->one();
                     
                        $dataDeposit->deposit_value = $newDeposit;
                        $dataDeposit->update();

                        $jurnalDeposit = new Jurnal();

                        $jurnalDeposit->debit = $newDeposit;
                        $jurnalDeposit->credit = $newDeposit;
                        $jurnalDeposit->date = date('Y-m-d');
                        $jurnalDeposit->code = $this->generateCode();
                        $jurnalDeposit->no = $this->findMaxId()+1;
                        $jurnalDeposit->description = 'Deposit Invoice '.$model->inv_number.' '.$jurnalDeposit->date;
                        $jurnalDeposit->status = '10';

                        $jurnalDeposit->save();

                        $JurnalDepositChild = new JurnalChild();

                        $JurnalDepositChild->id_jur = $jurnalDeposit->id;
                        $JurnalDepositChild->id_coa = $findCoa->id;
                        $JurnalDepositChild->date = date('Y-m-d');
                        $JurnalDepositChild->amount = $newDeposit;
                        $JurnalDepositChild->dc = 'C';
                        $JurnalDepositChild->description = 'Deposit Invoice '.$model->inv_number.' '.$JurnalDepositChild->date;
                        $JurnalDepositChild->status = '10';

                        $JurnalDepositChild->save();

                        $JurnalDepositChild2 = new JurnalChild();

                        $JurnalDepositChild2->id_jur = $jurnalDeposit->id;
                        $JurnalDepositChild2->id_coa = $dataCoaDeposit->id;
                        $JurnalDepositChild2->date = date('Y-m-d');
                        $JurnalDepositChild2->amount = $model->value_charge;
                        $JurnalDepositChild2->dc = 'D';
                        $JurnalDepositChild2->description = $findCoa->name.' pada Deposit Invoice '.$model->inv_number.' '.$JurnalDepositChild2->date;
                        $JurnalDepositChild2->status = '10';    

                        $JurnalDepositChild2->save();
                        
                        foreach ($pecahModel as $pecahModel) {
                            
                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $pecahModel->value_charge;
                            $modelJurnal->credit = $pecahModel->value_charge;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $modelJurnal->description = $pecahModel->type.' '.$modelJurnal->date.' '.$pecahModel->unit_code;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();

                            $dataCoa = Coa::find()->where(['code' => $model->coa_code])->one();
                            $dataCoaBayar = Coa::find()->where(['name' => 'A/R '.$pecahModel->type])->one();
                            // echo $modelJurnal->id;
                            // die();

                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $dataCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $pecahModel->value_charge;
                            $modelJurnalChild->dc = 'D';
                            $modelJurnalChild->description = $dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();

                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaBayar->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $pecahModel->value_charge;
                            $modelJurnalChild2->dc = 'C';
                            $modelJurnalChild2->description = 'A/R'. $pecahModel->type.' '.$dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild2->date;
                            
                            $modelJurnalChild2->status = '10';

                            $modelJurnalChild2->save();

                            $pecahModel->status_pay = 'OK';
                            $pecahModel->update();

                            $modelPayBill = PayBilling::find()->where(['unit_charge_value_id'=>$pecahModel->id])->one();
                            $modelPayBill->status_pay = 'OK';
                            $modelPayBill->total_pay = $pecahModel->value_charge;
                            $modelPayBill->balance_value = $modelPayBill->total_pay - $modelPayBill->total_charge;
                            $modelPayBill->jenis_pembayaran = $model->jenis_pembayaran;
                            $modelPayBill->coa_code = $model->coa_code;
                            $modelPayBill->update();                                

                            /* Jika sudah menemukan format yg pas untuk memasukan biaya admin ke dalam coa baris kode ini di aktfikan

                            if($modelTambah->value_admin>0){

                            }else{

                            }

                            */
                        }

                    Yii::$app->session->setFlash('success', "Processed Pay successfully.");
                    

                    $sqlPay="SELECT * FROM pay_billing where inv_number='$invnumber' AND status_pay='OK' AND status_receipt=0";
                    $modelReceipt=PayBilling::findBySql($sqlPay)->all();

                    $sqlPay2="SELECT * FROM pay_billing where inv_number='$invnumber'";
                    $modelReceipt2=PayBilling::findBySql($sqlPay2)->ONE();
                    
                    return $this->render('receipt', [
                        'model' => $modelReceipt,
                        'model2'=> $modelReceipt2,
                    ]); // redirect to your next desired page    

                    }

                     
                     
                }else{
                     
                     $model->total_pay = str_replace('.', '', $model->total_pay);
                     $modelTambah->value_charge = str_replace('.', '', $modelTambah->value_charge);


                    if($model->total_pay < $modelTambah->value_charge){
                        
                        $modelDeposit = new DepositTb();
                        $modelDeposit->unit_id = $model->unitId->id;
                        $modelDeposit->deposit_value = $model->total_pay;
                        $modelDeposit->save();
                        // $modelDeposit->explan = 'Deposit Pembayaran inv '.$model->inv_number;

                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $model->total_pay;
                            $modelJurnal->credit = $model->total_pay;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $modelJurnal->description = 'Deposit Invoice '.$model->inv_number.' '.$modelJurnal->date;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();
        
                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $findCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $model->total_pay;
                            $modelJurnalChild->dc = 'C';
                            $modelJurnalChild->description = 'Deposit Invoice '.$model->inv_number.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();

                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaDeposit->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $model->total_pay;
                            $modelJurnalChild2->dc = 'D';
                            $modelJurnalChild2->description = $findCoa->name.' pada Deposit Invoice '.$model->inv_number.' '.$modelJurnalChild2->date;
                            
                            $modelJurnalChild2->status = '10';

                            $modelJurnalChild2->save();

                            Yii::$app->session->setFlash('success', "Processed Pay successfully.");
                            

                            $sqlPay="SELECT * FROM pay_billing where inv_number='$invnumber' AND status_receipt=0";
                            $modelReceipt=PayBilling::findBySql($sqlPay)->all();

                            $sqlPay2="SELECT * FROM pay_billing where inv_number='$invnumber'";
                            $modelReceipt2=PayBilling::findBySql($sqlPay2)->ONE();

                            $modelPrintDeposit = $model->total_pay;
                            
                            return $this->render('deposit', [
                                'model' => $modelReceipt,
                                'model2'=> $modelReceipt2,
                                'modelDeposit' => $modelPrintDeposit,
                            ]); // redirect to your next desired page

                    }

                    else if($model->total_pay == $modelTambah->value_charge){

                        $pecahModel = UnitChargeValue::find()->where(['inv_number'=>$model->inv_number])->all();
                        
                        foreach ($pecahModel as $pecahModel) {
                            
                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $pecahModel->value_charge;
                            $modelJurnal->credit = $pecahModel->value_charge;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $modelJurnal->description = $pecahModel->type.' '.$modelJurnal->date.' '.$pecahModel->unit_code;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();
                            $dataCoa = Coa::find()->where(['code' => $model->coa_code])->one();
                            $dataCoaBayar = Coa::find()->where(['name' => 'A/R '.$pecahModel->type])->one();
                            // echo $modelJurnal->id;
                            // die();

                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $dataCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $pecahModel->value_charge;
                            $modelJurnalChild->dc = 'D';
                            $modelJurnalChild->description = $dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();

                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaBayar->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $pecahModel->value_charge;
                            $modelJurnalChild2->dc = 'C';
                            $modelJurnalChild2->description = 'A/R'. $pecahModel->type.' '.$dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild2->date;
                            
                            $modelJurnalChild2->status = '10';

                            $modelJurnalChild2->save();

                            $pecahModel->status_pay = 'OK';
                            $pecahModel->update();

                            $modelPayBill = PayBilling::find()->where(['unit_charge_value_id'=>$pecahModel->id])->one();
                            $modelPayBill->status_pay = 'OK';
                            $modelPayBill->total_pay = $pecahModel->value_charge;
                            $modelPayBill->balance_value = $modelPayBill->total_pay - $modelPayBill->total_charge;
                            $modelPayBill->jenis_pembayaran = $model->jenis_pembayaran;
                            $modelPayBill->coa_code = $model->coa_code;
                            $modelPayBill->update();

                            /* Jika sudah menemukan format yg pas untuk memasukan biaya admin ke dalam coa baris kode ini di aktfikan

                            if($modelTambah->value_admin>0){

                            }else{

                            }

                            */
                        }

                        Yii::$app->session->setFlash('success', "Processed Pay successfully.");
                        

                        $sqlPay="SELECT * FROM pay_billing where inv_number='$invnumber' AND status_pay='OK' AND status_receipt=0";
                        $modelReceipt=PayBilling::findBySql($sqlPay)->all();

                        $sqlPay2="SELECT * FROM pay_billing where inv_number='$invnumber'";
                        $modelReceipt2=PayBilling::findBySql($sqlPay2)->ONE();
                        
                        return $this->render('receipt', [
                            'model' => $modelReceipt,
                            'model2'=> $modelReceipt2,
                        ]); // redirect to your next desired page

                    }

                    else if($model->total_pay > $modelTambah->value_charge){

                        $pecahModel = UnitChargeValue::find()->where(['inv_number'=>$model->inv_number])->all();
                        $deposit = $model->total_pay - $modelTambah->value_charge;    

                        $selectDep = DepositTb::find()->where(['unit_id'=>$dataDeposit->unit_id])->one();
                        if($selectDep == null){
                           
                           $modelDeposit = new DepositTb();
                           $modelDeposit->unit_id = $model->unitId->id;
                           $modelDeposit->deposit_value = $deposit;
                           $modelDeposit->save();

                        }else{
                           $selectDep->deposit_value = $deposit+$selectDep->deposit_value;
                           $selectDep->update();      
                        }

                        
                        $jurnalDeposit = new Jurnal();

                        $jurnalDeposit->debit = $deposit;
                        $jurnalDeposit->credit = $deposit;
                        $jurnalDeposit->date = date('Y-m-d');
                        $jurnalDeposit->code = $this->generateCode();
                        $jurnalDeposit->no = $this->findMaxId()+1;
                        $jurnalDeposit->description = 'Deposit Invoice '.$model->inv_number.' '.$jurnalDeposit->date;
                        $jurnalDeposit->status = '10';

                        $jurnalDeposit->save();

                        $JurnalDepositChild = new JurnalChild();

                        $JurnalDepositChild->id_jur = $jurnalDeposit->id;
                        $JurnalDepositChild->id_coa = $findCoa->id;
                        $JurnalDepositChild->date = date('Y-m-d');
                        $JurnalDepositChild->amount = $deposit;
                        $JurnalDepositChild->dc = 'C';
                        $JurnalDepositChild->description = 'Deposit Invoice '.$model->inv_number.' '.$JurnalDepositChild->date;
                        $JurnalDepositChild->status = '10';

                        $JurnalDepositChild->save();

                        $modelJurnalChild2 = new JurnalChild();
                        $modelJurnalChild2->id_jur = $jurnalDeposit->id;
                        $modelJurnalChild2->id_coa = $dataCoaDeposit->id;
                        $modelJurnalChild2->date = date('Y-m-d');
                        $modelJurnalChild2->amount = $deposit;
                        $modelJurnalChild2->dc = 'D';
                        $modelJurnalChild2->description = $findCoa->name.' pada Deposit Invoice '.$model->inv_number.' '.$modelJurnalChild2->date;
                        $modelJurnalChild2->status = '10';

                        $modelJurnalChild2->save();

                        
                        foreach ($pecahModel as $pecahModel) {
                            
                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $pecahModel->value_charge;
                            $modelJurnal->credit = $pecahModel->value_charge;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $modelJurnal->description = $pecahModel->type.' '.$modelJurnal->date.' '.$pecahModel->unit_code;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();

                            $dataCoa = Coa::find()->where(['code' => $model->coa_code])->one();
                            $dataCoaBayar = Coa::find()->where(['name' => 'A/R '.$pecahModel->type])->one();
                            // echo $modelJurnal->id;
                            // die();

                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $dataCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $pecahModel->value_charge;
                            $modelJurnalChild->dc = 'D';
                            $modelJurnalChild->description = $dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();

                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaBayar->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $pecahModel->value_charge;
                            $modelJurnalChild2->dc = 'C';
                            $modelJurnalChild2->description = 'A/R'. $pecahModel->type.' '.$dataCoa->name.' '.$pecahModel->unit_code.' '.$modelJurnalChild2->date;
                            
                            $modelJurnalChild2->status = '10';

                            $modelJurnalChild2->save();

                            $pecahModel->status_pay = 'OK';
                            $pecahModel->update();

                            $modelPayBill = PayBilling::find()->where(['unit_charge_value_id'=>$pecahModel->id])->one();
                            $modelPayBill->status_pay = 'OK';
                            $modelPayBill->total_pay = $pecahModel->value_charge;
                            $modelPayBill->balance_value = $modelPayBill->total_pay - $modelPayBill->total_charge;
                            $modelPayBill->jenis_pembayaran = $model->jenis_pembayaran;
                            $modelPayBill->coa_code = $model->coa_code;
                            $modelPayBill->update();                                

                            /* Jika sudah menemukan format yg pas untuk memasukan biaya admin ke dalam coa baris kode ini di aktfikan

                            if($modelTambah->value_admin>0){

                            }else{

                            }

                            */
                        }


                        Yii::$app->session->setFlash('success', "Processed Pay successfully.");
                        

                        $sqlPay="SELECT * FROM pay_billing where inv_number='$invnumber' AND status_pay='OK' AND status_receipt=0";
                        $modelReceipt=PayBilling::findBySql($sqlPay)->all();

                        $sqlPay2="SELECT * FROM pay_billing where inv_number='$invnumber'";
                        $modelReceipt2=PayBilling::findBySql($sqlPay2)->ONE();
                        
                        return $this->render('receipt', [
                            'model' => $modelReceipt,
                            'model2'=> $modelReceipt2,
                        ]); // redirect to your next desired page
                    }

                }
                
            }


        } else {

            $sql = "SELECT * FROM pay_billing where inv_number='$invnumber' AND status_pay='NOK'";
            $modelpay = PayBilling::findBySql($sql)->all();
            $sql2 = "SELECT * FROM pay_billing where inv_number='$invnumber'";
            $modelpay2 = PayBilling::findBySql($sql2)->one();
            $idUnit = $modelpay2->unitId->id;
            $sqlDeposit = "SELECT * FROM deposit_tb where unit_id='$idUnit'";
            $dataDeposit = DepositTb::findBySql($sqlDeposit)->one();
            
            
            return $this->render('create', [
                'modelpay' => $modelpay,
                'model' => $modelpay2,
                'options'=> $options,
                'modelTambah' => $modelTambah,
                'dataDeposit' => $dataDeposit,
            ]);
        }


    }

    /**
     * Deletes an existing PayBilling model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PayBilling model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayBilling the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayBilling::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
