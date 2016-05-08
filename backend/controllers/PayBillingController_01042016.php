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


    public function actionCreate($invnumber)
    {

        $options = array('payMetod' => [
            'CASH' => 'Cash', 
            'BANK' => 'Transfer', 
            'EBANKING' => 'Ebanking'            
            ] );
        //$model = new UnitChargeValue();
        $model = PayBilling::find()->where(['inv_number'=>$invnumber])->all();       
        
        if (PayBilling::loadMultiple($model, Yii::$app->request->post())) {
            
            $count = 0;
            foreach ($model as $item) {
               // populate and save records for each model

                if($item->status_pay==0){
                    continue;
                }else if($item->status_pay==1){

                    // $item->total_pay = $this->convert_to_number($item->total_pay);
                    // $item->total_charge = $this->convert_to_number($item->total_charge);
                 $item->total_pay = str_replace('.', '', $item->total_pay);
                 $item->total_charge = str_replace('.', '', $item->total_charge);
    
                    
                // echo $item->total_pay.'<br />';
                // echo $item->total_charge;
                // die();    
                    if($item->total_pay > 0 && $item->total_pay < $item->total_charge){
                        $item->status_pay = 'PARTIAL';
                    }else if($item->total_pay == 0){
                        $item->status_pay = 'NOK';
                    }else if($item->total_pay == $item->total_charge){
                        $item->status_pay = 'OK';
                    }

                    $modelUc = UnitChargeValue::find()->where(['id'=>$item->unit_charge_value_id])->one();
                    $modelUc->status_pay = $item->status_pay;
                    $modelUc->update();


                    $item->balance_value=$item->total_charge - $item->total_pay;
                    $item->jenis_pembayaran = $item->jenis_pembayaran;
                    $item->coa_code = $item->coa_code;
                    $item->update();

                    $dataUnit = PayBilling::find()->where(['id'=>$item->id])->one();

                            $modelJurnal = new Jurnal();
                            $modelJurnal->debit = $item->total_pay;
                            $modelJurnal->credit = $item->total_pay;
                            $modelJurnal->date = date('Y-m-d');
                            $modelJurnal->code = $this->generateCode();
                            $modelJurnal->no = $this->findMaxId()+1;
                            $dataCoa = Coa::find()->where(['code' => $item->coa_code])->one();
                            $dataCoaBayar = Coa::find()->where(['name' => 'A/R '.$item->type])->one();
                            $modelJurnal->description ='Pay'. $item->type.' '.date('Y-m-d').' '.$dataUnit->unit;
                            $modelJurnal->status = '10';

                            $modelJurnal->save();

                            $modelJurnalChild = new JurnalChild();

                            $modelJurnalChild->id_jur = $modelJurnal->id;
                            $modelJurnalChild->id_coa = $dataCoa->id;
                            $modelJurnalChild->date = date('Y-m-d');
                            $modelJurnalChild->amount = $item->total_pay;
                            $modelJurnalChild->dc = 'D';
                            $modelJurnalChild->description = $dataCoa->name.' '.$dataUnit->unit.' '.$modelJurnalChild->date;
                            $modelJurnalChild->status = '10';

                            $modelJurnalChild->save();


                            $modelJurnalChild2 = new JurnalChild();

                            $modelJurnalChild2->id_jur = $modelJurnal->id;
                            $modelJurnalChild2->id_coa = $dataCoaBayar->id;
                            $modelJurnalChild2->date = date('Y-m-d');
                            $modelJurnalChild2->amount = $item->total_pay;
                            $modelJurnalChild2->dc = 'C';
                            $modelJurnalChild2->description = 'A/R'. $item->type.' '.$dataCoa->name.' '.$dataUnit->unit.' '.$modelJurnalChild2->date;
                            $modelJurnalChild2->status = '10';
                            $modelJurnalChild2->save();

                            $count++;
                    
                }                 
                    
               
            }
            

            Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            return $this->redirect(['unit-charge-value/invoice']); // redirect to your next desired page
        } else {

            $sql = "SELECT * FROM pay_billing where inv_number='$invnumber' AND status_pay='NOK'";
            $modelpay = PayBilling::findBySql($sql)->all();
            $sql2 = "SELECT * FROM pay_billing where inv_number='$invnumber'";
            $modelpay2 = PayBilling::findBySql($sql2)->one();
            // var_dump($modelpay2);
            // die();
            
            return $this->render('create', [
                'model' => $modelpay,
                'model2' => $modelpay2,
                'options'=> $options,
            ]);
        }
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
