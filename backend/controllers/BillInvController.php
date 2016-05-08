<?php

namespace backend\controllers;

use Yii;
// use backend\models\UnitChargeValue;
// use backend\models\UnitChargeValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UnitChargeValue;
use backend\models\UnitChargeValueSearch;
use backend\models\PayBilling;
use backend\models\PayBillingSearch;

/**
 * UnitChargeValueController implements the CRUD actions for UnitChargeValue model.
 */
class BillInvController extends Controller
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
     * Lists all UnitChargeValue models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UnitChargeValue model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function convert_to_number($rupiah)
     {
           return intval(preg_replace('/,.*|[^0-9]/', '', $rupiah));
     }

    /**
     * Creates a new UnitChargeValue model.
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

                    $item->total_pay = $this->convert_to_number($item->total_pay);
                    $item->total_charge = $this->convert_to_number($item->total_charge);

                    if($item->total_pay > 0 && $item->total_pay < $item->total_charge){
                        $item->status_pay = 'PARTIAL';
                    }else if($item->total_pay == 0){
                        $item->status_pay = 'NOK';
                    }else if($item->total_pay == $item->total_charge){
                        $item->status_pay = 'OK';
                    }

                    $item->balance_value=$item->total_charge-$item->total_pay;
                    $item->jenis_pembayaran = $item->jenis_pembayaran;
                    $item->coa_code = $item->coa_code;
                    $item->update();
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
     * Updates an existing UnitChargeValue model.
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
            return $this->render('create', [
                'model' => $modelpay,
                'model2' => $modelpay2,
            ]);
        }
    }

    /**
     * Deletes an existing UnitChargeValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDataInvoice(){
        
        $sql = 'SELECT distinct inv_number, bill_to, charge_month, charge_year, unit_code  FROM unit_charge_value';
        $data = UnitChargeValue::findBySql($sql)->all();


        return $this->render('dataInvoince', [
            'data' => $data,
            
        ]);

    }

    /**
     * Finds the UnitChargeValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UnitChargeValue the loaded model
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
