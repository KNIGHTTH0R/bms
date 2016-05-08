<?php

namespace backend\controllers;

use Yii;
use backend\models\Person;
use backend\models\PersonAddress;
use backend\models\PersonSearch;
use backend\models\UploadFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
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
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionLihat($id)
    {
        return $this->render('lihat', [
            'modelLihat' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Person();
        $modelsAdd = [new PersonAddress];
        if ($model->load(Yii::$app->request->post())) {

            $model->detail_person = json_encode($model->detail_person);
            //$model->detail_private = json_encode($model->detail_private);       
            
            $modelsAdd = Model::createMultiple(PersonAddress::classname());
            Model::loadMultiple($modelsAdd, Yii::$app->request->post());

            // ajax validation
            
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsAdd) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsAdd as $modelAdd) {
                            $modelAdd->person_id = $model->id;
                            if (! ($flag = $modelAdd->save(false))) {
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
            
        }else{

            return $this->render('create', [
                'model' => $model,
                'modelsAdd' => (empty($modelAdd)) ? [new PersonAddress] : $modelAdd
            ]);
        }
    }
    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsAdd = $model->personAddresses;
        $model->detail_person = json_decode($model->detail_person, true); 
        //$model->detail_private = json_decode($model->detail_private, true);       

        if ($model->load(Yii::$app->request->post())) {
            
            $model->detail_person = json_encode($model->detail_person);    
            //$model->detail_private = json_encode($model->detail_private);    

            $oldIDs = ArrayHelper::map($modelsAdd, 'id', 'id');
            $modelsAdd = Model::createMultiple(PersonAddress::classname(), $modelsAdd);
            Model::loadMultiple($modelsAdd, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAdd, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsAdd) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            PersonAddress::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsAdd as $modelAdd) {
                            $modelAdd->person_id = $model->id;
                            if (! ($flag = $modelAdd->save(false))) {
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
            'modelsAdd' => (empty($modelsAdd)) ? [new PersonAddress] : $modelsAdd
        ]);
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUploadTenant()
    {
        $fileUpload = new UploadFile();

        if(Yii::$app->request->post()){
            
            $fileUpload->folder='tenant/';

            $file = $fileUpload->uploadFile();

            if(!empty($file) && $fileUpload->validate()) {

                $path = $fileUpload->getFileUpload();
                $filexx = $file->saveAs($path);


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

                //var_dump($highestRow); die();

                for($row = 1; $row <= $highestRow; $row++) {

                    $dataPerson = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

                    if($row == 1) {
                        continue;
                    }

                    //Cek Person Code, apakah sudah ada atau belum. 
                    //Jika sudah ada, record itu tidak disimpan
                    //Jika belum ada, record itu disimpan

                    $person = new Person();
                    $person->person_code = $dataPerson[0][0];
                    $person->name = $dataPerson[0][1];
                    $person->is_company = $dataPerson[0][2];
                    $person->tax_reg = $dataPerson[0][3];
                    $detail_person = '{"dob": "'.$dataPerson[0][4].'", "fax": "'.$dataPerson[0][5].'", "sex": "'.$dataPerson[0][6].'", 
                                        "phone": "'.$dataPerson[0][7].'", "id_type": "'.$dataPerson[0][8].'", "position": "'.$dataPerson[0][9].'", 
                                        "religion": "'.$dataPerson[0][10].'", "id_number": "'.$dataPerson[0][11].'", "salutation": "'.$dataPerson[0][12].'", 
                                        "nationality": "'.$dataPerson[0][13].'", "contact_name": "'.$dataPerson[0][14].'", "marital_status": "'.$dataPerson[0][15].'"}';
                    $person->detail_person = $detail_person;

                    $personAddress = new PersonAddress();
                    
                    $personAddress->postal_code = $dataPerson[0][16];
                    $personAddress->phone = $dataPerson[0][17];
                    $personAddress->fax = $dataPerson[0][18];
                    $personAddress->name = $dataPerson[0][19];
                    $personAddress->for_billing = $dataPerson[0][20];
                    $personAddress->for_letternotif = $dataPerson[0][21];
                    $personAddress->building = $dataPerson[0][22];
                    $personAddress->street = $dataPerson[0][23];
                    $personAddress->city = $dataPerson[0][24];
                    $personAddress->province = $dataPerson[0][25];
                    $personAddress->country = $dataPerson[0][26];
                    $personAddress->email = $dataPerson[0][27];

                    $valid = $person->validate() && $personAddress->validate();
                    if ($valid) {

                        $transaction = \Yii::$app->db->beginTransaction();
                        try {

                            if ($flag = $person->save(false)) {

                                $personAddress->person_id = $person->id;

                                if (! ($flag = $personAddress->save(false))) {

                                    $transaction->rollBack();
                                    break;

                                }

                            }
                            if ($flag) {
                                $transaction->commit();   
                            }

                        }catch (Exception $e) {
                            $transaction->rollBack();
                        }
                    }

                }

                Yii::$app->session->setFlash('success', 'File '.$file->name.' has been successfully uploaded');
                return $this->render('uploadtenant');

            } else {
                Yii::$app->session->setFlash('error', 'There is no file to upload');
            }
        }
        return $this->render('uploadtenant');
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
