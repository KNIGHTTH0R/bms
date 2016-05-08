<?php

namespace backend\controllers;

use Yii;
use backend\models\MeterRead;
use backend\models\MeterReadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UploadMeter;
use yii\db\Query;
use yii\filters\AccessControl;

/**
 * MeterReadController implements the CRUD actions for MeterRead model.
 */
class MeterReadController extends Controller
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
     * Lists all MeterRead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MeterReadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MeterRead model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionUpload()
    {
        $fileUpload = new UploadMeter();

        $rowData = array();
        
        if(Yii::$app->request->post()){

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

                for($row = 1; $row <= $highestRow; $row++) {

                    $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);

                    if($row == 1) {
                        continue;
                    }    

                    $modelMeter = new MeterRead();
                    $prevMonth = $rowData[0][4]-1;
                               
                    $yearNow = $rowData[0][5];
                    $meterNumber = $rowData[0][0];

                    $meterId = \backend\models\UnitMeter::find()->where(['meter_number'=>$meterNumber])->one();
                    
                    $prevValue = $rowData[0][6];    

                    
                    $delta = $rowData[0][7] - $prevValue;
                    
                    if($rowData[0][4] == 1){
                        $monthC = 'January';
                    }
                    else if ($rowData[0][4] == 2) {
                        $monthC = 'February';
                    }
                    else if ($rowData[0][4] == 3) {
                        $monthC = 'March';
                    }
                    else if ($rowData[0][4] == 4) {
                        $monthC = 'April';
                    }
                    else if ($rowData[0][4] == 5) {
                        $monthC = 'May';
                    }
                    else if ($rowData[0][4] == 6) {
                        $monthC = 'June';
                    }
                    else if ($rowData[0][4] == 7) {
                        $monthC = 'July';
                    }
                    else if ($rowData[0][4] == 8) {
                        $monthC = 'August';
                    }
                    else if ($rowData[0][4] == 9) {
                        $monthC = 'September';
                    }
                    else if ($rowData[0][4] == 10) {
                        $monthC = 'October';
                    }
                    else if ($rowData[0][4] == 11) {
                        $monthC = 'November';
                    }
                    else if ($rowData[0][4] == 12) {
                        $monthC = 'December';
                    }

                    //$modelMeter->unit_meter_id = $rowData[0][0];
                    $modelMeter->unit_meter_id = $meterId->id;
                    $modelMeter->type = $rowData[0][2];
                    $modelMeter->date_read = strtotime($rowData[0][3].' '.$monthC.' '.$rowData[0][5]);
                    $modelMeter->month = $rowData[0][4];
                    $modelMeter->year = $rowData[0][5];
                    $modelMeter->prev_value = $prevValue;
                    $modelMeter->cur_value = $rowData[0][7];
                    $modelMeter->status = $rowData[0][8];
                    $modelMeter->delta = $delta;
                    // $modelMeter->unit_meter_id = $rowData[0][0];
                    
                    
                    $modelMeter->save();
                    
                }
                
                $searchModel = new MeterReadSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

            } else {
                Yii::$app->session->setFlash('error', 'There is no file to upload');
            }
            
        }

        return $this->render('_formupload', [
            'rowData'=>$rowData,
        ]);
    }

    public function actionDownloadElectric()
    {
        $prevMonth = date('m')-1;
        $yearNow = date('Y');
        
        $model = MeterRead::find()
                ->select('unit_meter.*, meter_read.*, unit.code')
                ->leftJoin('unit_meter', 'unit_meter.id=meter_read.unit_meter_id')
                ->leftJoin('unit', 'unit.id=unit_meter.unit_id')
                ->where(['meter_read.type'=>'ELECTRICITY', 'meter_read.month' => $prevMonth, 'meter_read.year' => $yearNow, 'meter_read.generate_status' => true])
                ->AsArray()->all();

        
        $meterNumber = \backend\models\UnitMeter::find()
                        ->select('unit_meter.*, unit.*')
                        ->leftJoin('unit', 'unit.id=unit_meter.unit_id')
                        ->where(['unit_meter.type'=>'ELECTRICITY'])
                        ->AsArray()->all();

        //var_dump($meterNumber);die();

        $objPHPExcel = new \PHPExcel();

        $sheet = 0;

        $objPHPExcel->getProperties()
                    ->setCreator("Building Management System")
                    ->setLastModifiedBy('Building Management System')
                    ->setTitle("Electric Previous Meter Reading")
                    ->setSubject("Previous Meter Reading")
                    ->setKeywords("Water, Electric, Meter")
                    ->setCategory("Meter");

        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

        $objPHPExcel->getActiveSheet()->setTitle('Electric-'.date('Ym'))
                    ->setCellValue('A1', 'METER ID')
                    ->setCellValue('B1', 'UNIT ID')
                    ->setCellValue('C1', 'TYPE')
                    ->setCellValue('D1', 'DATE READ')
                    ->setCellValue('E1', 'MONTH READ')
                    ->setCellValue('F1', 'YEAR READ')
                    ->setCellValue('G1', 'L_PREV')
                    ->setCellValue('H1', 'L_CURR')
                    ->setCellValue('I1', 'STATUS');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);

        $row = 2;

        //var_dump($model);die();

        if(empty($model)){

            foreach ($meterNumber as $data) {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data['meter_number']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $data['type']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, date('Y'));
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 0);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, null);

                $row++;
            }

            header('Content-Type: application/vnd.ms-excel');
            $filename = "Electric_Prev_".date("d-m-Y-His").".xls";
            header('Content-Disposition: attachment; filename='.$filename .' ');
            header('Cache-Control: max-age=0');

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

        } else {
            foreach ($model as $data) {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data['meter_number']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $data['type']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, date('Y'));
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data['cur_value']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, null);

                $row++;
            }

            header('Content-Type: application/vnd.ms-excel');
            $filename = "Electric_Prev_".date("d-m-Y-His").".xls";
            header('Content-Disposition: attachment; filename='.$filename .' ');
            header('Cache-Control: max-age=0');

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }

        

    }

    public function actionDownloadWater()
    {
        $prevMonth = date('m')-1;
        $yearNow = date('Y');

        $model = MeterRead::find()
                ->select('unit_meter.*, meter_read.*, unit.code')
                ->leftJoin('unit_meter', 'unit_meter.id=meter_read.unit_meter_id')
                ->leftJoin('unit', 'unit.id=unit_meter.unit_id')
                ->where(['meter_read.type'=>'WATER', 'meter_read.month' => $prevMonth, 'meter_read.year' => $yearNow, 'meter_read.generate_status' => true])
                ->AsArray()->all();
        
        $meterNumber = \backend\models\UnitMeter::find()
                        ->select('unit_meter.*, unit.*')
                        ->leftJoin('unit', 'unit.id=unit_meter.unit_id')
                        ->where(['unit_meter.type'=>'WATER'])
                        ->AsArray()->all();

        $objPHPExcel = new \PHPExcel();

        $sheet = 0;

        $objPHPExcel->getProperties()
                    ->setCreator("Building Management System")
                    ->setLastModifiedBy('Building Management System')
                    ->setTitle("Electric Previous Meter Reading")
                    ->setSubject("Previous Meter Reading")
                    ->setKeywords("Water, Electric, Meter")
                    ->setCategory("Meter");

        $objPHPExcel->setActiveSheetIndex($sheet);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

        $objPHPExcel->getActiveSheet()->setTitle('Water-'.date('Ym'))
                    ->setCellValue('A1', 'METER ID')
                    ->setCellValue('B1', 'UNIT ID')
                    ->setCellValue('C1', 'TYPE')
                    ->setCellValue('D1', 'DATE READ')
                    ->setCellValue('E1', 'MONTH READ')
                    ->setCellValue('F1', 'YEAR READ')
                    ->setCellValue('G1', 'W_PREV')
                    ->setCellValue('H1', 'W_CURR')
                    ->setCellValue('I1', 'STATUS');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);

        $row = 2;

        if(empty($model)){
            foreach ($meterNumber as $data) {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data['meter_number']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $data['type']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, date('Y'));
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 0);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, null);

                $row++;
            }

            header('Content-Type: application/vnd.ms-excel');
            $filename = "Water_Prev_".date("d-m-Y-His").".xls";
            header('Content-Disposition: attachment; filename='.$filename .' ');
            header('Cache-Control: max-age=0');

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else {
            foreach ($model as $data) {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data['meter_number']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data['code']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $data['type']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, date('Y'));
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data['cur_value']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, null);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, null);
                $row++;
            }

            header('Content-Type: application/vnd.ms-excel');
            $filename = "Water_Prev_".date("d-m-Y-His").".xls";
            header('Content-Disposition: attachment; filename='.$filename .' ');
            header('Cache-Control: max-age=0');

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
        
    }

    /**
     * Creates a new MeterRead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MeterRead();
        $options = array('type' => [
            'ELECTRICITY' => 'Electricity', 
            'WATER' => 'Water', 
            'SINKINGFUND' => 'Sinking Fund', 
            'SERVICECHARGE' => 'Service Charge', 
            'INTERNET' => ' Internet',
            'TV' => 'TV'
            ]);
        $options['recur_period'] = [
            'DAY' => 'Daily', 
            'WEEK' => 'Weekly', 
            '2WEEK' => 'Biweekly', 
            'MONTH' => 'Monthly', 
            '3MONTH' => 'Every 3 months', 
            '6MONTH' => 'Every 6 months', 
            'YEAR' => 'Yearly'
            ];
        $options['meter_unit'] = [
            'KWH' => 'KWH', 
            'M3' => 'Cubic Meter (m3)', 
            'M2' => 'Square Meter (m2)'
            ];

        $options['status'] = [
            'Normal' => 'Normal',
            'Anomali' => 'Anomali',
            'Confirmed' => 'Confirmed'

        ];

        if ($model->load(Yii::$app->request->post())) {

            $model->delta = $model->cur_value - $model->prev_value;
            $model->date_read = strtotime($model->date_read);
            $model->month = date('m', $model->date_read);
            $model->year = date('Y', $model->date_read);

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);    
            }else{
                return $this->render('create', [
                'model' => $model,
                'options' => $options
            ]);    
            }

            
        } else {
            return $this->render('create', [
                'model' => $model,
                'options' => $options
            ]);
        }
    }

    /**
     * Updates an existing MeterRead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->date_read = Yii::$app->formatter->asDate($model->date_read);
        //$model = new MeterRead();
        $options = array('type' => [
            'ELECTRICITY' => 'Electricity', 
            'WATER' => 'Water', 
            'SINKINGFUND' => 'Sinking Fund', 
            'SERVICECHARGE' => 'Service Charge', 
            'INTERNET' => ' Internet',
            'TV' => 'TV'
            ] );
        $options['recur_period'] = [
            'DAY' => 'Daily', 
            'WEEK' => 'Weekly', 
            '2WEEK' => 'Biweekly', 
            'MONTH' => 'Monthly', 
            '3MONTH' => 'Every 3 months', 
            '6MONTH' => 'Every 6 months', 
            'YEAR' => 'Yearly'
            ];
        $options['meter_unit'] = [
            'KWH' => 'KWH', 
            'M3' => 'Cubic Meter (m3)', 
            'M2' => 'Square Meter (m2)'
            ];

        $options['status'] = [
            'Normal' => 'Normal',
            'Anomali' => 'Anomali',
            'Confirmed' => 'Confirmed'

        ];
        
        //var_dump($model);

        if ($model->load(Yii::$app->request->post())) {

            $model->delta = $model->cur_value - $model->prev_value;
            $model->date_read = strtotime($model->date_read);
            $model->month = date('m', $model->date_read);
            $model->year = date('Y', $model->date_read);

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('update', [
                'model' => $model,
                'options' => $options
            ]);

            }

            
        } else {
            return $this->render('update', [
                'model' => $model,
                'options' => $options
            ]);
        }
    }

    /**
     * Deletes an existing MeterRead model.
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
     * Finds the MeterRead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MeterRead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MeterRead::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
