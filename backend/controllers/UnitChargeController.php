<?php

namespace backend\controllers;

use Yii;
use backend\models\UnitCharge;
use backend\models\UnitChargeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadFile;
use backend\models\Unit;
use backend\models\Person;
use backend\models\UnitMeter;

/**
 * UnitChargeController implements the CRUD actions for UnitCharge model.
 */
class UnitChargeController extends Controller
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
     * Lists all UnitCharge models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnitChargeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UnitCharge model.
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
     * Creates a new UnitCharge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UnitCharge();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->unit_meter_id == '') $model->unit_meter_id = null;
            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);    
            }
        } else {
            return $this->render('create', [
                'model' => $model
        
            ]);
        }
        
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['index', 'id' => $model->id]);
        // } else {
        //     return $this->render('create', [
        //         'model' => $model
        
        //     ]);
        // }
    }
    /**
     * Updates an existing UnitCharge model.
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
     * Deletes an existing UnitCharge model.
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
     * Finds the UnitCharge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UnitCharge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UnitCharge::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLists($id)
     {
         $countPosts = \backend\models\UnitMeter::find()
             ->where(['unit_id' => $id])
             ->count();
             
         $posts = \backend\models\UnitMeter::find()
             ->where(['unit_id' => $id])
             ->orderBy('id DESC')
             ->all();
         
         if($countPosts>0){
            echo "<option value=''>-Choose a Unit Meter Id-</option>";
            echo "<option value=''>-None-</option>";
             foreach($posts as $post){
                echo "<option value='".$post->id."'>".$post->meter_number." ( ".$post->type." )</option>";
             }
             }
             else{
             echo "<option>-</option>";
         }
     


     }

     public function actionPlists($id)
     {
         $countPosts2 = \backend\models\Unit::find()
             ->where(['id' => $id])
             ->count();
             
         $posts2 = \backend\models\Unit::find()

             ->where(['id' => $id])
             ->orderBy('id DESC')
             ->all();
         
         if($countPosts2>0){
             foreach($posts2 as $post2){

                echo "<option value='".$post2->owner_id."'> Owner ( ID ".$post2->ownerName." )</option>";
                echo "<option value='".$post2->tenant_id."'> Tenant ( ID ".$post2->tenantName." )</option>";
             }

             }
             else{
             echo "<option>-</option>";
         }
     


     }

    public function actionUpload()
    {
        $fileUpload = new UploadFile();

        if(Yii::$app->request->post()){
            
            $fileUpload->folder='unitcharge/';

            $file = $fileUpload->uploadFile();

            if(!empty($file) && $fileUpload->validate()) {

                $path = $fileUpload->getFileUpload();
                $filexx = $file->saveAs($path);

                //Yii::$app->session->setFlash('success', 'File '.$file->name.' has been successfully uploaded');

                try{

                    $inputFileType = \PHPExcel_IOFactory::identify($path);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($path);

                }catch(Exception $e)
                {
                    die('Error');
                }

                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                for($row = 1; $row <= $highestRow; $row++) {


                    $data = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

                    if($row == 1) {
                        continue;
                    }

                    // $data[0][0] = KODE UNIT
                    // $data[0][1] = TARIFF ID
                    // $data[0][2] = BILL TO
                    // $data[0][3] = TYPE
                    // $data[0][4] = METER NUMBER

                    $unitCharge = new UnitCharge();
                    //Find Unit ID
                    $unitID = Unit::find()->where(['code'=>$data[0][0]])->one();
                    //Find Owner
                    $ownerID = Person::find()->where(['person_code'=>$data[0][2]])->one();
                    //Find Unit Meter
                    $meterID = UnitMeter::find()->where(['meter_number'=>$data[0][4]])->one();

                    $unitCharge->unit_id = $unitID ? $unitID->id : null;
                    $unitCharge->tariff_id = $data[0][1];
                    $unitCharge->bill_to = $ownerID ? $ownerID->id : null;
                    $unitCharge->type = $data[0][3];
                    $unitCharge->unit_meter_id = $meterID ? $meterID->id : null;

                    if ($unitCharge->validate()) {

                        $transaction = \Yii::$app->db->beginTransaction();

                        try {

                            if ($flag = $unitCharge->save(false)) {

                                Yii::$app->session->setFlash('success', 'File '.$file->name.' has been successfully uploaded');
                                                                
                            }

                            if($flag) {
                                $transaction->commit();
                            }

                        }catch (Exception $e) {
                            $transaction->rollBack();
                        }
                        
                    }
                }

              Yii::$app->session->setFlash('success', 'File '.$file->name.' has been successfully uploaded');

            } else {
                Yii::$app->session->setFlash('error', 'There is no file to upload');
            }

            Yii::$app->session->setFlash('success', 'File '.$file->name.' has been successfully uploaded');
        }

        return $this->render('upload');
    }
}
