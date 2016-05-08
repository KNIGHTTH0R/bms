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
class BillInvController extends Controller
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

    /**
     * Creates a new UnitChargeValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        //$model = new UnitChargeValue();
        $model = UnitChargeValue::find()->where(['inv_number'=>$id])->all();
        // $model = $this->findModel($id);

        if (UnitChargeValue::loadMultiple($model, Yii::$app->request->post()) && UnitChargeValue::validateMultiple($model)) {
            foreach ($model as $model) {
                $model->save(false);
            }
            return $this->redirect(['unit-charge-value/data-invoice']);

        // if ($model->load(Yii::$app->request->post())) {
            

        //     return $this->redirect(['unit-charge-id/data-invoice']);

        } else {

            $sql = "SELECT * FROM unit_charge_value where inv_number='$id'";
            $modelpay = UnitChargeValue::findBySql($sql)->all();
            $modelpay2 = UnitChargeValue::findBySql($sql)->one();

            return $this->render('create', [
                'model' => $modelpay,
                'model2' => $modelpay2,
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
        if (($model = UnitChargeValue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
