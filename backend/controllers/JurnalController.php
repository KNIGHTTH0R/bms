<?php

namespace backend\controllers;

use Yii;
use backend\models\Jurnal;
use backend\models\Coa;
use backend\models\JurnalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\JurnalChild;
use backend\models\Model;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * JurnalController implements the CRUD actions for Jurnal model.
 */
class JurnalController extends Controller
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
     * Lists all Jurnal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JurnalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //$dataProvider->code = "code";
        //var_dump($dataProvider->code[0]);
        //die();
        $dataProvider->pagination->pageSize = 20;

        if(Yii::$app->request->isPjax){
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
    }

    /**
     * Displays a single Jurnal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelJurnalChild = $model->jurnalChildren;

        //$code = "EXP-".date('m').date('y').'-'.sprintf("%04s", $model->code);

        //$model->code = $code;
        return $this->render('view', [
            'model' => $model,
            'modelJurnalChild' => $modelJurnalChild
        ]);
    }

    /**
     * Creates a new Jurnal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jurnal();
		
        $modelJurnalChild = [new JurnalChild];
		
        if($model->load(Yii::$app->request->post())){        
            $model->date = date('Y-m-d', strtotime($model->date));
						
            $modelJurnalChild = Model::createMultiple(JurnalChild::classname());
            Model::loadMultiple($modelJurnalChild, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelJurnalChild) && $valid;
			
            //var_dump($modelJurnalChild); die();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try{
					$model->code = $this->generateCode();					
         			$model->no = (int)substr($model->code ,strlen($model->code)-4,4);
					
					$sa = 0;
					
                    foreach ($modelJurnalChild as $mjChild) {
					   if (empty($mjChild->amount)) {
					      $sa = 0;
					   } else {
					      $sa = $mjChild->amount;
					   }
                       if ($mjChild->dc == "D") {
						  $model->debit += $sa;
                       } else {
						  $model->credit += $sa;
                       }					
					}
				
				    
                    if($flag = $model->save(false)) {					    
                        foreach ($modelJurnalChild as $modelJurnalChild) {
                            $modelJurnalChild->id_jur = $model->id;
                            $modelJurnalChild->date = $model->date;
                            $modelJurnalChild->status = $model->status;
                            if(! ($flag = $modelJurnalChild->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }		
                        												
                    } 
					

                    /**
                     * Hitung Code Jurnal
                     * EXP-blnthn-no
                     * EXP-0615-0013
                     * $max = Model::find()->select('id')->max(); 
                     */
					 
                    //$model->no = $this->findMaxId()+1;	
					/*
                    $model->code = $this->generateCode();						
					$model->no = (int)substr($model->code ,strlen($model->code)-4,4);					                    
					*/
					

                    //$model->save();					
                    					 
                    if($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
					
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        
        return $this->render('create', [
            'model' => $model,
            'modelJurnalChild' => (empty($modelJurnalChild)) ? [new JurnalChild] : $modelJurnalChild
        ]);
		
    }

    /**
     * Updates an existing Jurnal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelJurnalChild = $model->jurnalChildren;

        
        if($model->load(Yii::$app->request->post())) {
		
		
            $model->date = date('Y-m-d', strtotime($model->date));

            $oldIDs = ArrayHelper::map($modelJurnalChild, 'id', 'id');
            $modelJurnalChild = Model::createMultiple(JurnalChild::classname(), $modelJurnalChild);
            Model::loadMultiple($modelJurnalChild, Yii::$app->request->post());
            $deleteIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelJurnalChild, 'id', 'id')));

            //$valid = $model->validate();
            //$valid = Model::validateMultiple($modelJurnalChild) && $valid;

            //if($valid) {
                //$transaction = \Yii::$app->db->beginTransaction();
                //try{
                    				
				    /*
                    $sd = 0;
                    $sc = 0;
                    
                    if($flag = $model->save(false)) {
                        if(! empty($deleteIDs)) {
                            JurnalChild::deleteAll(['id' => $deleteIDs]);
                        }
                        foreach($modelJurnalChild as $modelJurnalChild) {
                            $modelJurnalChild->date = $model->date;
                            $modelJurnalChild->status = $model->status;
                            $modelJurnalChild->id_jur = $model->id;

                            if ($modelJurnalChild->dc == "D") {
                                $sd = $sd + $modelJurnalChild->amount;
                            } else {
                                $sc = $sc + $modelJurnalChild->amount;
                            }

                            if(! ($flag = $modelJurnalChild->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
						*/
					   	
					   if(! empty($deleteIDs)) {
                           JurnalChild::deleteAll(['id' => $deleteIDs]);
                       } 
					   
                       $model->debit=0;
                       $model->credit=0; 					   
					   $sa = 0;					
                       foreach ($modelJurnalChild as $mjChild) {
					      if (empty($mjChild->amount)) {
					          $sa = 0;
					        } else {
					          $sa = $mjChild->amount;
					        }
							
                          if ($mjChild->dc == "D") {
						      $model->debit += $sa;
                            } else {
						      $model->credit += $sa;
                            }					
					    }
				
                        //var_dump($model->description);die();
						 
                        //$model->save();	
										        
						foreach ($modelJurnalChild as $modelJurnalChild) {
                               $modelJurnalChild->id_jur = $model->id;
                               $modelJurnalChild->date = $model->date;
                               $modelJurnalChild->status = $model->status;
                               if(! ($flag = $modelJurnalChild->save(false))) {
                                  $transaction->rollBack();
                                  break;
                               }							   
                            }		
							
                            //$transaction->commit();
                            //return $this->redirect(['view', 'id' => $model->id]);							                           
                           

                    //$model->debit = $sd;
                    //$model->credit = $sc;
					/*
                    if ($model->save() and $flag){
                       $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
					    return $this->redirect(['index', $model]);
					}
					*/					
                //} catch (Exception $e) {
                //    $transaction->rollBack();
                //}
				
            //} else {
			//    var_dump("error disini");die();
			//}
			//return $this->redirect(['index', $model]);
             										
			//}
            Yii::$app->db->createCommand()->update('jurnal', [ 'description' => $model->description,'ref' => $model->ref,'date'=> $model->date,'status'=>$model->status,'debit'=>$model->debit,'credit'=>$model->credit],'id='. $id )->execute();			
			return $this->redirect(['view', 'id' => $model->id]);							                           
        } else {
           
           $model->date = date('d-m-Y', strtotime($model->date));
           return $this->render('update', [
               'model' => $model,
               'modelJurnalChild' => (empty($modelJurnalChild)) ? [new JurnalChild] : $modelJurnalChild
            ]);
		}
    }

    /**
     * Deletes an existing Jurnal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionLists($id)
    {
        $dcCheck = Coa::find()->select('debet_credit')
                ->where(['id' => $id])
                ->all();

        if($dcCheck[0]->debet_credit == 'D') {
            echo "<option value='D' selected>DEBIT</option><option value='C'>CREDIT</option>";
        } else {
            echo "<option value='D'>DEBIT</option><option value='C' selected>CREDIT</option>";
        }

        
    }
	
	
    /*
    public function findMaxId()
    {
        $maxID = Jurnal::find()->select('MAX(no)')->scalar();		
        return $maxID;
    }
    */
	
    public function generateCode()
    {
	    $mainCode ="EXP-".date('m').date('y');
        //$number = $this->findMaxId()+1;        
		
        $maxID = Jurnal::find()->select('MAX(no)')->where(['left(code,8)'=>$mainCode])->scalar();		
        $number=$maxID +1  ; 		
        $code = $mainCode.'-'.sprintf("%04s", $number);		
        return $code;
    }

    /**
     * Finds the Jurnal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jurnal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jurnal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
