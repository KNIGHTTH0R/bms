<?php

namespace backend\controllers;

use Yii;
// use backend\models\UnitChargeValue;
// use backend\models\UnitChargeValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\PayBilling;
use backend\models\PayBillingSearch;
use backend\models\UnitChargeValue;
use backend\models\UnitChargeValueSearch;
use yii\filters\AccessControl;

/**
 * UnitChargeValueController implements the CRUD actions for UnitChargeValue model.
 */
class UnitChargeValueController extends Controller
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

    /**
     * Lists all UnitChargeValue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionInvoice()
    {
        $searchModel = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->cari(Yii::$app->request->queryParams);

        
        return $this->render('invoice', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionInvoiceUnit($id)
    {

        $searchModel = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->cariUnit(Yii::$app->request->queryParams, $id);

        
        return $this->render('invoice-unit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionOutstandingUnit($id)
    {

        $searchModel = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->cariUnit(Yii::$app->request->queryParams, $id);

        
        return $this->render('outstanding-unit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCollection(){

        $searchModel = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->caripay(Yii::$app->request->queryParams);
        $dn = sprintf('%01d', date('m'));
        
        $sqlPay = "SELECT * from unit_charge_value where status_pay='OK' AND inv_month=$dn";
        $sumPay = UnitChargeValue::findBySql($sqlPay)->all();
        
        
        $content1 = $this->renderPartial('datapay', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelPay' => $sumPay,
           
        
        ]);

        $searchModel2 = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2 = $searchModel2->carioutstand(Yii::$app->request->queryParams);
        
        $sqlOut = "SELECT * from unit_charge_value where status_pay IS NUll AND inv_month=$dn";
        $sumOut = UnitChargeValue::findBySql($sqlOut)->all();
        
        $content2 = $this->renderPartial('dataoutstand', [
            'searchModel' => $searchModel2,
            'dataProvider' => $dataProvider2,
            'modelOut' => $sumOut,
        ]);

    
        $searchModel3 = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider3 = $searchModel3->caripayear(Yii::$app->request->queryParams);
        $yn = date('Y');
        
        
        // $sqlPay = "SELECT SUM('value_charge') as topay from unit_charge_value where status_pay='OK' AND charge_month=date('m')";
        // $sumPay = UnitChargeValue::findBySql($sqlPay);
        $sqlPayYear = "SELECT * from unit_charge_value where status_pay='OK' AND charge_year=$yn";
        $sumPayYear = UnitChargeValue::findBySql($sqlPayYear)->all();
        // $datePay = date('m');
        // $command = Yii::$app->db->createCommand("SELECT SUM(value_charge) as topay from unit_charge_value where status_pay='OK' AND charge_month=$datePay");
        // $result = $command->queryAll();

        $content3 = $this->renderPartial('datapayear', [
            'searchModel' => $searchModel3,
            'dataProvider' => $dataProvider3,
            'modelPay' => $sumPayYear,
        
        ]);

        $searchModel4 = new UnitChargeValueSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider4 = $searchModel4->carioutyear(Yii::$app->request->queryParams);
        $yn = date('Y');
        
        
        // $sqlPay = "SELECT SUM('value_charge') as topay from unit_charge_value where status_pay='OK' AND charge_month=date('m')";
        // $sumPay = UnitChargeValue::findBySql($sqlPay);
        $sqlOutYear = "SELECT * from unit_charge_value where status_pay IS NULL AND charge_year=$yn";
        $sumOutYear = UnitChargeValue::findBySql($sqlOutYear)->all();
        // $datePay = date('m');
        // $command = Yii::$app->db->createCommand("SELECT SUM(value_charge) as topay from unit_charge_value where status_pay='OK' AND charge_month=$datePay");
        // $result = $command->queryAll();

        $content4 = $this->renderPartial('dataoutyear', [
            'searchModel' => $searchModel4,
            'dataProvider' => $dataProvider4,
            'modelOut' => $sumOutYear,
        
        ]);

        return $this->render('datavalue',[
                
                
                'content1' => $content1,
                'content2' => $content2,
                'content3' => $content3,
                'content4' => $content4,
                
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

    public function actionPrintInv($id){
            $dataModel = UnitChargeValue::find()
            ->where(['inv_number'=>$id])
            ->one();

            $modelDetail = UnitChargeValue::find()
            ->where(['inv_number'=>$id])
            ->all();

            return $this->renderPartial('invoice-print',[
                'model' => $dataModel,
                'modelDetail' => $modelDetail,
                
            ]);   
    }

    /**
     * Creates a new UnitChargeValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UnitChargeValue();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
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
            return $this->render('update', [
                'model' => $model,
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
        if (($model = UnitChargeValue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
