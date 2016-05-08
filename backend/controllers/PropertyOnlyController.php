<?php

namespace backend\controllers;

use Yii;
use backend\models\Property;
use backend\models\PropertySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PropertyOnlyController implements the CRUD actions for Property model.
 */
class PropertyOnlyController extends Controller
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
     * Lists all Property models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PropertySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Property model.
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
     * Creates a new Property model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Property();

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
     * Updates an existing Property model.
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
     * Deletes an existing Property model.
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
     * Finds the Property model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Property the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Property::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Untuk mengatur user login berada pada scope property tertentu
     * Diatur dalam session
     * @return mixed
     */
    public function actionScope() 
    {

        $model = new \yii\base\DynamicModel(['property_id']);
        $model->addRule(['property_id'], 'required');

        $session = Yii::$app->session;
        // $session->set('property', ['id'=>2, 'nama'=>'Nama Property']);
        // print_r($session->get('property'));

        if ($model->load(Yii::$app->request->post())) {
            $p = Property::find()->where(['id'=>$model->property_id])->one();
            // Set property session
            $session->set('property', ['id'=>$p->id, 'code'=>$p->code, 'name'=>$p->name, 'address'=>$p->address]);
            // print_r($p->name);
        } 

        if ($session->has('property')) {
            $p = $session->get('property');
            $model->property_id = $p['id'];
        }
        // $session->remove('property');
        return $this->render('set-scope', [
                'model' => $model
            ]);

    }
    
}

