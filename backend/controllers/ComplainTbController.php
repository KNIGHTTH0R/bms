<?php

namespace backend\controllers;

use Yii;
use backend\models\ComplainTb;
use backend\models\ComplainTbSearch;
use backend\models\Unit;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComplainTbController implements the CRUD actions for ComplainTb model.
 */
class ComplainTbController extends Controller
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
     * Lists all ComplainTb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComplainTbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComplainTb model.
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
     * Creates a new ComplainTb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComplainTb();

        $modelUnit = Unit::find()
        ->select(['code as value','code as label'])
        ->asArray()
        ->all();



        if ($model->load(Yii::$app->request->post())) {
    
            $model->date_complain = strtotime($model->date_complain);
            $model->date_complain_char = date('d F Y', $model->date_complain);
            $model->save();

            return $this->redirect(['view', 'id' => $model->id_complain]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelUnit' => $modelUnit,
            ]);
        }
    }

    /**
     * Updates an existing ComplainTb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $codeUnit = $model->code_unit;
        
        $modelUnit = Unit::find()
        ->select(['code as value','code as label'])
        ->where(['code' => $codeUnit])
        ->one();

        $model->date_complain = date('d F Y', $model->date_complain);

        if ($model->load(Yii::$app->request->post())) {
            
            $model->date_complain = strtotime($model->date_complain);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_complain]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelUnit' => $modelUnit
            ]);
        }
    }

    /**
     * Deletes an existing ComplainTb model.
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
     * Finds the ComplainTb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComplainTb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComplainTb::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
