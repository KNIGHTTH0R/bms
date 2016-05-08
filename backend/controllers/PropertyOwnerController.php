<?php

namespace backend\controllers;

use Yii;
use backend\models\PropertyOwner;
use backend\models\PropertyOwnerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\Helpers\Json;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
/**
 * PropertyOwnerController implements the CRUD actions for PropertyOwner model.
 */
class PropertyOwnerController extends Controller
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
     * Lists all PropertyOwner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PropertyOwnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        print_r(Yii::$app->getRequest()->getUserIP());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PropertyOwner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->address = json_decode($model->address, true);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new PropertyOwner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {
        $model = new PropertyOwner();
        
        
        if ($model->load(Yii::$app->request->post())) {
            $model->address = json_encode($model->address);
            if($model->save()){
            
                return $this->redirect(['index', 'id' => $model->id]);    

            }else{
                return $this->render('create', [
                'model' => $model,
            ]);    
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                
            ]);
        }
    }


    /**
     * Updates an existing PropertyOwner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->address = json_decode($model->address, true);

        if ($model->load(Yii::$app->request->post())) {
            $model->address = json_encode($model->address);
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PropertyOwner model.
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
     * Finds the PropertyOwner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropertyOwner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropertyOwner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
