<?php

namespace backend\controllers;

use Yii;
use backend\models\ProfileUser;
use backend\models\ProfileUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;
use common\models\RecordHelpers;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * ProfileController implements the CRUD actions for ProfileUser model.
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
       return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view','create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProfileUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        if($already_exists = RecordHelpers::userHas('profile_user')){

            return $this->render('view', [
                                'model' => $this->findModel($already_exists),
            ]);

        } else {

            return $this->redirect(['create']);

        }

    }

    /**
     * Displays a single ProfileUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        if($already_exists = RecordHelpers::userHas('profile_user')) {

            return $this->render('view', [
                                'model' => $this->findModel($already_exists),
            ]);

        } else {

            return $this->redirect(['create']);

        }
    }

    /**
     * Creates a new ProfileUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfileUser();

        $model->birthdate = date('d-m-Y', strtotime($model->birthdate));
        $model->user_id = \Yii::$app->user->identity->id;

        if($already_exists = RecordHelpers::userHas('profile_user')) {

            return $this->render('view', [
                    'model' => $this->findModel($already_exists),
                ]);

        } elseif ($model->load(Yii::$app->request->post())) {

            $image = $model->uploadImage();

            if($model->save()) {
                // upload only if valid uploaded file instance found

                if($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }

                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                return $this->render('create', ['model'=>$model]);
            }

        } else {

            return $this->render('create', [
                                'model' => $model,
                ]);

        }
    }

    /**
     * Updates an existing ProfileUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = ProfileUser::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        $oldFile = $model->getImageFile();

        $oldAvatar = $model->avatar;
        $oldFileName = $model->filename;


        if($model) {

            $model->birthdate = date('d-m-Y', strtotime($model->birthdate));

            if($model->load(Yii::$app->request->post())) {

                $image = $model->uploadImage();

                // revert back if no valid file instance uploaded
                if($image === false) {
                    $model->avatar = $oldAvatar;
                    $model->filename = $oldFileName;
                }

                if($model->save()) {
                    // upload only if valid uploaded file instance found
                    if ($image !== false && $oldFile == null) {

                        $path = $model->getImageFile();
                        $image->saveAs($path);

                    } elseif ($image !== false && unlink($oldFile)) {
                        $path = $model->getImageFile();
                        $image->saveAs($path);
                    }
                    return $this->redirect(['view']);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                    ]);   
                }

            } else {

                return $this->render('update', [
                                    'model' => $model,
                    ]);

            }

        } else {

            throw new NotFoundHttpException('No Such Profile');

        }
    }

    /**
     * Deletes an existing ProfileUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();

        return $this->redirect(['index']);*/
        
        /*$model = Profile::find()->where([
                'user_id' => Yii::$app->user->identity->id
            ])->one();

        $this->findModel($model->id)->delete();*/

        $model = $this->findModel($id);

        // validate deletion and on failure process any exception
        // e.g. display an error message
        if($model->delete()){
            if(!$model->deleteImage()){
                Yii::$app->session->setFlash('error', 'Error deleting image');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProfileUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProfileUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProfileUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
