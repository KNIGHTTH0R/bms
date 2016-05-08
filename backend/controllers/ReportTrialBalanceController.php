<?php

namespace backend\controllers;

use Yii;
use backend\models\ReportTrialBalance;
use backend\models\ReportTrialBalanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportTrialBalanceController implements the CRUD actions for ReportTrialBalance model.
 */
class ReportTrialBalanceController extends Controller
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
     * Lists all ReportTrialBalance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportTrialBalanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $types = \backend\models\CoaType::find()->all();

        // var_dump($dataProvider->models[0]->debitAmount); die();
        

        // var_dump($credit); die();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'types' => $types,
        ]);
    }

    // public function actionIndex()
    // {
    //     $query = \backend\models\ReportTrialBalance::find()
    //             ->select('id_coa,coa_type.type')
    //             ->distinct();
    //     $query->joinWith('coa');
        
    //     $query->leftJoin('coa_type', '"coa_type"."id" = "coa"."type"');

    //     $query->where(['status' => 10]);
        
    //     return $this->render('index', [
    //         'data' => $query,
    //     ]);
    // }

    /**
     * Displays a single ReportTrialBalance model.
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
     * Creates a new ReportTrialBalance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReportTrialBalance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ReportTrialBalance model.
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
     * Deletes an existing ReportTrialBalance model.
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
     * Finds the ReportTrialBalance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportTrialBalance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportTrialBalance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
