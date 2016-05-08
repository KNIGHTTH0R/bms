<?php

namespace backend\controllers;

use Yii;
use backend\models\Unit;
use backend\models\UnitSearch;
use backend\models\UploadFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use backend\models\Model;
use backend\models\Person;
use backend\models\PersonAddress;
use backend\models\Building;
use backend\models\UnitType;
use backend\models\UnitMeter;
Use backend\models\UnitCharge;
Use backend\models\UnitChargeValue;
Use backend\models\UnitChargeValueSearch;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\base\DynamicModel;
use backend\models\PayBilling;
use yii\helpers\ArrayHelper;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends Controller
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
     * Lists all Unit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionManagement()
    {
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('management', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Unit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unit();
        $modelUc = [new UnitCharge];
        
        

        if ($model->load(Yii::$app->request->post())) {
            
            $modelUc = Model::createMultiple(UnitCharge::classname());
            Model::loadMultiple($modelUc, Yii::$app->request->post());

            // $modelMeter = Model::createMultiple(UnitMeter::classname());
            // Model::loadMultiple($modelMeter, Yii::$app->request->post());

            // ajax validation
            
            // validate all models
            // $valid = $model->validate();
            // $valid = Model::validateMultiple($modelUc) && $valid;

            // if ($valid) {
            //     $transaction = \Yii::$app->db->beginTransaction();
            //     try {
            //         if ($flag = $model->save(false)) {
            //             foreach ($modelUc as $modelUc) {
            //                 $modelMeter = new UnitMeter();

            //                 $modelMeter->type=$modelUc->type;
            //                 $modelMeter->unit_id=$model->id;
            //                 $modelMeter->meter_number=$modelUc->unit_meter_id;
            //                 $modelUc->unit_meter_id=$modelMeter->id;
            //                 $modelUc->unit_id=$model->id;

            //                 var_dump($modelMeter->type);
            //                 die();

            //                 if (! ($flag = $modelUc->save(false))) {
            //                     $transaction->rollBack();
            //                     break;
            //                 }
            //             }
            //         }
            //         if ($flag) {
            //             $transaction->commit();
            //             return $this->redirect(['view', 'id' => $model->id]);
            //         }
            //     } catch (Exception $e) {
            //         $transaction->rollBack();
            //     }
            // }
            $model->save();

            foreach ($modelUc as $modelUc) {
                  
                  if($modelUc->meter_number==""){
                               
                    $modelUc->unit_meter_id =null;                        
                    $modelUc->unit_id = $model->id;
                    $modelUc->save();

                  }else{

                    $modelMeter = new UnitMeter();

                    $modelMeter->type = $modelUc->type;
                    $modelMeter->meter_number = $modelUc->meter_number;
                    $modelMeter->unit_id = $model->id;

                    $modelMeter->save();

                    $modelUc->unit_meter_id = $modelMeter->id;
                    $modelUc->unit_id = $model->id;    

                    $modelUc->save();

                  }                              

                  

                                                                        
            }
            
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelUc' => $modelUc,
                
            ]);
        }
    }

    /**
     * Updates an existing Unit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUc = $model->unitCharge;
        

        if ($model->load(Yii::$app->request->post())) {
            
            $oldIDs = ArrayHelper::map($modelUc, 'id', 'id');
            $modelUc = Model::createMultiple(UnitCharge::classname(), $modelUc);
            Model::loadMultiple($modelUc, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelUc, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelUc) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            UnitCharge::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelUc as $modelUc) {
                            $modelUc->unit_id = $model->id;
                            if (! ($flag = $modelUc->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelUc' => (empty($modelUc)) ? [new UnitCharge] : $modelUc
        ]);
    }


    /**
     * Deletes an existing Unit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $modelUc = UnitCharge::find()->where(['unit_id'=>$id])->all();
        foreach ($modelUc as $modelUc) {
            $modelUc->delete();
        }

        $modelUm = UnitMeter::find()->where(['unit_id'=>$id])->all();
        foreach ($modelUm as $modelUm) {
            $modelUm->delete();
        }
        
        $this->findModel($id)->delete();
            return $this->redirect(['index']);
    }

    public function actionDetailUnit($id){

        $model = $this->findModel($id);
        $person = Person::find()->where(['id'=>$model->owner_id])->one();
        $detailAddress = PersonAddress::find()->where(["person_id" => $person->id])->all();

        $person2 = Person::find()->where(['id'=>$model->tenant_id])->one();
        if($person2==null){
            $detailAddress2=null;    
            $content2=null;
        }else{
            $detailAddress2 = PersonAddress::find()->where(["person_id" => $person2->id])->all();    
            $content2 = $this->renderPartial(
                '//person/viewtenant',
                array(
                    // 'data'=>'Welcome',
                    'model'=>$person2,
                    'detailAddress' => $detailAddress2,
                    
                ));
        

        }
        

        $code=$model->code;   

        $content = $this->renderPartial(
                '/unit/view',
                array(
                    // 'data'=>'Welcome',
                    'model'=>$model,
                                        
                ));


        $content1 = $this->renderPartial(
                '//person/viewtab',
                array(
                    // 'data'=>'Welcome',
                    'model'=>$person,
                    'detailAddress' => $detailAddress,
                    
                ));

        
        $queryD = UnitChargeValue::find()->select('inv_number, bill_to, charge_month, charge_year, unit_code')->where(['unit_code' => $code])->distinct();
        
        $dataProvider = new ActiveDataProvider([
                'query'=>$queryD,
        ]);
    
      
     
        $content3 = $this->renderPartial(
                '//unit-charge-value/invoice-unit',
                array(

                        'dataProvider'=>$dataProvider,
                        'model'=>$queryD,
                        'searchModel'=>'',
                ));

        $queryOut = PayBilling::find()->select('inv_number, unit_code, total_charge, total_pay, balance_value, status_pay')->where(['unit_code' => $code, 'status_pay'=>'NOK'])->orWhere(['unit_code'=> $code, 'status_pay'=>'PARTIAL']);
        
        $dataProvider = new ActiveDataProvider([
                'query'=>$queryOut,
        ]);
    
      
     
        $content4 = $this->renderPartial(
                '//unit-charge-value/outstanding-unit',
                array(

                        'dataProvider'=>$dataProvider,
                        'model'=>$queryOut,
                        'searchModel'=>'',
                ));

        // $content2='test';

        return $this->render('detailunit',[
                'model' => $model,
                'content' => $content,
                'content1' => $content1,
                'content2' => $content2,
                'content3' => $content3,
                'content4' => $content4,
            ]);

    }


    /**
     * get Owner Detail
     */
    public function actionOwnerdetail($id)
    {
        $model = $this->findModel($id);
        $person = Person::find()->where(['id'=>$model->owner_id])->one();

        $detailAddress = PersonAddress::find()->where(["person_id" => $model->id])->all();
        
        return $this->render('ownerdetail', [
            'model' => $model,
            'detailAddress' => $detailAddress,
            'person' => $person,
        ]);
    }

    public function actionUploadUnit()
    {
        $fileUpload = new UploadFile();

        if(Yii::$app->request->post()){
            
            $fileUpload->folder='unit/';

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


                    $dataUnit = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

                    if($row == 1) {
                        continue;
                    }

                    $unit = new Unit();
                    
                    $unit->code = $dataUnit[0][0];

                    $building = Building::find()->where(['code'=>$dataUnit[0][1]])->one();
                    $unit->building_id = $building ? $building->id: null;

                    $unit->unit_floor = $dataUnit[0][2];
                    $unit->unit_num = $dataUnit[0][3];
                    $unit->space_size = $dataUnit[0][5];
                    $unit->space_unit = $dataUnit[0][6];
                    $unit->power = $dataUnit[0][12];
                    $unit->va = $dataUnit[0][14];

                    $owner = Person::find()->where(['person_code'=>$dataUnit[0][7]])->one();
                    $unit->owner_id = $dataUnit[0][7] ? $owner->id : null;

                    $tenant = Person::find()->where(['person_code'=>$dataUnit[0][8]])->one();
                    $unit->tenant_id = $dataUnit[0][8] ? $tenant->id : null;
                    
                    $unitType = UnitType::find()->where(['code'=>$dataUnit[0][9]])->one();
                    $unit->unit_type_id = $unitType ? $unitType->id : null;

                    //$unit->electricity_meter_number = $dataUnit[0][10];
                    //$unit->water_meter_number = $dataUnit[0][11];
                    //$meterNumber = array($dataUnit[0][10], $dataUnit[0][11]);

                    //$electricity = $dataUnit[0][10] ? explode('-', $dataUnit[0][10]) : null;
                    //$water = $dataUnit[0][11] ? explode('-', $dataUnit[0][11]) : null;

                    //Baca header Electric dan Water
                    $cellElec = $objPHPExcel->getActiveSheet()->getCell('K1');
                    $cellWater = $objPHPExcel->getActiveSheet()->getCell('L1');
                    //echo $cellWater; die();

                    $electricity = $dataUnit[0][10] ? $dataUnit[0][10] : 'EL_'.$dataUnit[0][0];
                    $water = $dataUnit[0][11] ? $dataUnit[0][11] : 'WA_'.$dataUnit[0][0];

                    //$meterNumber = array($electricity, $water);

                    if ($unit->validate()) {

                        $transaction = \Yii::$app->db->beginTransaction();

                        try {

                            if ($flag = $unit->save(false)) {

                                $unitMeterElec = new UnitMeter();
                                $unitMeterElec->unit_id = $unit->id;
                                $unitMeterElec->type = "ELECTRICITY";
                                $unitMeterElec->meter_number = $electricity;

                                if(! $flag = $unitMeterElec->save(false)){
                                  $transaction->rollBack();
                                  break;
                                }

                                $unitMeterWater = new UnitMeter();
                                $unitMeterWater->unit_id = $unit->id;
                                $unitMeterWater->type = "WATER";
                                $unitMeterWater->meter_number = $water;

                                if(! $flag = $unitMeterWater->save(false)){
                                  $transaction->rollBack();
                                  break;
                                }
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

        return $this->render('uploadunit');
    }

    /**
     * Finds the Unit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Unit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLists($id)
     {
         $countPosts = \backend\models\UnitType::find()
             ->where(['building_id' => $id])
             ->count();
             
         $posts = \backend\models\UnitType::find()
             ->where(['building_id' => $id])
             ->orderBy('id DESC')
             ->all();
         
         if($countPosts>0){
             foreach($posts as $post){
                echo "<option value='".$post->id."'>".$post->name."</option>";
             }
             }
             else{
             echo "<option>-</option>";
         }
     


     }
}
