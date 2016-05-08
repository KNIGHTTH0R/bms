<?php

namespace backend\controllers;

use Yii;
use backend\models\Coa;
use backend\models\CoaType;
use backend\models\UploadFile;
use backend\models\CoaSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CoaController implements the CRUD actions for Coa model.
 */
class CoaController extends Controller
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
     * Lists all Coa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Coa model.
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
     * Creates a new Coa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Coa();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {

            $listParent = $model->find()->asArray()->all();

            for($i=0; $i<count($listParent); $i++) {
              $code[] = explode('-', $listParent[$i]['code']);

              $parentCode[] = $code[$i][0];
			  $parentId[] = $listParent[$i]['id'];
            }
            
            $request = Yii::$app->request;
            $post = $request->post();

            if(empty($request->post('Coa')['code'])) {
                if(empty($request->post('Coa')['parent_id'])){
                    $maxnumber = max($parentCode);
                    
                    $nextNumber = $maxnumber + 1000;
                    $model->code = $nextNumber .'-0000';
                    $model->type = $request->post('Coa')['type'];
                    $model->name = $request->post('Coa')['name'];
                    $model->debet_credit = $request->post('Coa')['debet_credit'];
                    $model->parent_id = $request->post('Coa')['parent_id'];

                    if($model->save()){
                        return $this->redirect(['index', $model]);
                    }
                } else {
				    /** mendapatkan kode parent **/
				    for ($i=0;$i<count($parentId);$i++) {
					    if ($parentId[$i]==$request->post('Coa')['parent_id']) {
						     $parentCodeX = $parentCode[$i];
						}
					}
					
					/** mendapatkan kode child **/
					$mychild = $model->find()->where(['parent_id' => $request->post('Coa')['parent_id']])->asArray()->all();
					
					for ($i=0;$i<count($mychild);$i++){
					    $myCode[] = explode('-', $mychild[$i]['code']);
						$childCode[] = $myCode[$i][1];
					}
					if (empty($childCode)) {
					   $nextnum="0001";
					} else {
					   $nextnum = "0000" . (max($childCode) +1);					
					}
					$nextcode =  $parentCodeX . "-". substr($nextnum ,strlen($nextnum)-4,4);
					
                     
					$model->code = $nextcode;
					$model->type = $request->post('Coa')['type'];
                    $model->name = $request->post('Coa')['name'];
                    $model->debet_credit = $request->post('Coa')['debet_credit'];
                    $model->parent_id = $request->post('Coa')['parent_id'];
                      
                    // $myvardump="id:" . $request->post('Coa')['parent_id'] . " - maincode:" . $parentCodeX . "  - subcode: " . $nextcode ;  										
                    // var_dump($myvardump);die();

                    // $group = $model->find()->where(['id' => $request->post('Coa')['parent_id']])->asArray()->all();

                    // for($j=0; $j<count($group); $j++) {
                    //   $code2[] = explode('-', $group[$j]['code']);

                    //   $code3[] = $code2[$j][1];
                    // }

                    // $nextCode = max($code3);

                    // $x = $nextCode + 1;
                    // $y = '0000'.$x;
                    // $y = substr($y, strlen($y)-4, 4);

                    // $model->code = $code2[0][0] .'-'.$y;
                    // $model->type = $request->post('Coa')['type'];
                    // $model->name = $request->post('Coa')['name'];
                    // $model->debet_credit = $request->post('Coa')['debet_credit'];
                    // $model->parent_id = $request->post('Coa')['parent_id'];

                    if($model->save()){
                         return $this->redirect(['index', $model]);
                    }
                }

               
            } else {
                if($model->save()){
                    return $this->redirect(['index', $model]);
                }
            }
            
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Coa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		
        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }		
	
        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
	     */
		
		//return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Coa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUploadCoa()
    {
        if(Yii::$app->request->post()){

            if(empty($_POST["bulkcoa"])){
                return $this->redirect(['coa/excell']);    
            } else {
                $data = $_POST["bulkcoa"];
                
                for ($i=0; $i < count($data); $i++) { 
                    $dataExp[] = explode('_', $data[$i]);
                }

                for($j=0; $j < count($dataExp); $j++) {

                    $xxx = array(
                        'type' => $dataExp[$j][0],
                        'code' => $dataExp[$j][1],
                        'name' => $dataExp[$j][2],
                        'debet_credit' => $dataExp[$j][3],
                        'parent' => $dataExp[$j][4],
                    );

                    $model = new Coa();
                    
                    if($xxx['type'] == '-' OR $xxx['type'] == ''){
                        $model->type = null;
                    } else {
                        $tId = CoaType::find()->where(['type'=>$xxx['type']])->one();
                        $model->type = $tId->id;
                    }

                    $model->code = $xxx['code'];
                    $model->name = $xxx['name'];
                    $model->debet_credit = $xxx['debet_credit'];

                    if($xxx['parent'] == '-' or $xxx['parent'] =='') {
                        $model->parent_id = null;
                    } else {
                        $pid = $model->find()->where(['code'=>$xxx['parent']])->one();

                        $model->parent_id = $pid->id;
                    }
                   
                    $model->save();    
                }

            }

        } else {
            return $this->redirect(['coa/excell']);
        }

        return $this->redirect(['coa/excell']);
    }

    public function actionExcell()
    {
        $fileUpload = new UploadFile();

        $dataCoa = array();
        
        if(Yii::$app->request->post()){

            $fileUpload->folder='coa/';

            $file = $fileUpload->uploadFile();
            if(!empty($file) && $fileUpload->validate()) {

                $path = $fileUpload->getFileUpload();
                $filexx = $file->saveAs($path);

                Yii::$app->session->setFlash('success', 'File '.$file->name.' has been successfully uploaded');

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

                    $dataCoa[] = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

                    if($row == 1) {
                        continue;
                    }    
                }
                
                return $this->render('_formuploadcoa', [
                    'model' => $path,
                    'rowData'=>$dataCoa,
                ]);

            } else {
                Yii::$app->session->setFlash('error', 'There is no file to upload');
            }
            
        }

        return $this->render('excell', [
            'rowData'=>$dataCoa,
        ]);
    }

    /**
     * Finds the Coa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Coa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
