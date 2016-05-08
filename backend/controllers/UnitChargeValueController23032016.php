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
