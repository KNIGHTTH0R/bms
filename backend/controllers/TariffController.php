<?php

namespace backend\controllers;

use Yii;
use backend\models\Tariff;
use backend\models\TariffSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TariffController implements the CRUD actions for Tariff model.
 */
class TariffController extends Controller
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
     * Lists all Tariff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TariffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tariff model.
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
     * Creates a new Tariff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tariff();
        $options = array('type' => [
            'ELECTRICITY' => 'Electricity', 
            'WATER' => 'Water', 
            'SINKINGFUND' => 'Sinking Fund', 
            'SERVICECHARGE' => 'Service Charge', 
            'INTERNET' => ' Internet',
            'TV' => 'TV'
            ] );
        $options['recur_period'] = [
            'DAY' => 'Daily', 
            'WEEK' => 'Weekly', 
            '2WEEK' => 'Biweekly', 
            'MONTH' => 'Monthly', 
            '3MONTH' => 'Every 3 months', 
            '6MONTH' => 'Every 6 months', 
            'YEAR' => 'Yearly'
            ];
        $options['meter_unit'] = [
            'KWH' => 'KWH', 
            'M3' => 'Cubic Meter (m3)', 
            'M2' => 'Square Meter (m2)'
            ];




        if ($model->load(Yii::$app->request->post())) {

            
            if($model->type =="ELECTRICITY"){
                $model->formula = json_encode($model->formula['elec']);
            }
            elseif ($model->type=="WATER") {
                $model->formula = json_encode($model->formula['water']);
            }
            elseif ($model->type=="SINKINGFUND") {
                $model->formula = json_encode($model->formula['sf']);
            }
            elseif ($model->type=="IURAN PEMELIHARAAN LINGKUNGAN") {
                $model->formula = json_encode($model->formula['sc']);
            }
            elseif ($model->type=="INTERNET") {
                $model->formula = json_encode($model->formula['internet']);
            }
            elseif ($model->type=="TV") {
                $model->formula = json_encode($model->formula['tv']);
            }

            $model->tax_formula = json_encode($model->tax_formula);
            $model->admin_formula = json_encode($model->admin_formula);

            if($model->save()){

            return $this->redirect(['index', 'id' => $model->id]);
                
            }
            else{
                return $this->render('create', [
                'model' => $model,
                'options' => $options
            ]);    
            
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'options' => $options
            ]);

            
        }
    }

    /**
     * Updates an existing Tariff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $options = array('type' => [
            'ELECTRICITY' => 'Electricity', 
            'WATER' => 'Water', 
            'SINKINGFUND' => 'Sinking Fund', 
            'SERVICECHARGE' => 'Service Charge', 
            'INTERNET' => ' Internet',
            'TV' => 'TV'
            ] );
        $options['recur_period'] = [
            'DAY' => 'Daily', 
            'WEEK' => 'Weekly', 
            '2WEEK' => 'Biweekly', 
            'MONTH' => 'Monthly', 
            '3MONTH' => 'Every 3 months', 
            '6MONTH' => 'Every 6 months', 
            'YEAR' => 'Yearly'
            ];
        $options['meter_unit'] = [
            'KWH' => 'KWH', 
            'M3' => 'Cubic Meter (m3)', 
            'M2' => 'Square Meter (m2)'
            ];


        if ($model->load(Yii::$app->request->post())) {

            
            if($model->type =="ELECTRICITY"){
                $model->formula = json_encode($model->formula['elec']);
            }
            elseif ($model->type=="WATER") {
                $model->formula = json_encode($model->formula['water']);
            }
            elseif ($model->type=="SINKINGFUND") {
                $model->formula = json_encode($model->formula['sf']);
            }
            elseif ($model->type=="IURAN PEMELIHARAAN LINGKUNGAN") {
                $model->formula = json_encode($model->formula['sc']);
            }
            elseif ($model->type=="INTERNET") {
                $model->formula = json_encode($model->formula['internet']);
            }
            elseif ($model->type=="TV") {
                $model->formula = json_encode($model->formula['tv']);
            }

            $model->tax_formula = json_encode($model->tax_formula);
            $model->admin_formula = json_encode($model->admin_formula);

            if($model->save()){

            return $this->redirect(['index', 'id' => $model->id]);
                
            }
            else{
                return $this->render('update', [
                'model' => $model,
                'options' => $options
            ]);    
            
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'options' => $options,
                'json'=>json_decode($model->formula),
            ]);

            
        }
    }

    /**
     * Deletes an existing Tariff model.
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
     * Finds the Tariff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tariff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tariff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
