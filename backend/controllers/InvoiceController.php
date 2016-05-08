<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UnitCharge;
use backend\models\UnitChargeValue;
use backend\models\MeterRead;
use backend\models\Tariff;
use yii\Helpers\ArrayHelper;
use backend\models\UnitMeter;
use backend\models\Unit;
use kartik\mpdf\Pdf;
/**
 * PersonController implements the CRUD actions for Person model.
 */
class InvoiceController extends Controller
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
     * Lists all Person models.
     * @return mixed
     */
    
    public function actionView($id)
    {
                                $invoiceGenerate = new UnitChargeValue();
                                
                                $dataInvoice = $invoiceGenerate->find()
                                ->where(['inv_number'=>$id])
                                ->All();

                                foreach ($dataInvoice as $dataInvoice) {

                                    $detailData = UnitChargeValue::find()
                                    ->where(['inv_number'=>$dataInvoice->inv_number])
                                    ->all();


                                        $content=$this->renderPartial('_invoiceFile',[
                                        'model' => $dataInvoice,
                                        'modelDetail' => $detailData,
                                        'modelDetail2' => $detailData,
                                        ]);   
                                    // setup kartik\mpdf\Pdf component
                                        $pdf = new Pdf([
                                        // set to use core fonts only
                                        'mode' => Pdf::MODE_CORE, 
                                        // A4 paper format
                                        'format' => Pdf::FORMAT_A4, 
                                        // portrait orientation
                                        'orientation' => Pdf::ORIENT_PORTRAIT, 
                                        // stream to browser inline
                                        'destination' => Pdf::DEST_BROWSER, 
                                        // your html content input
                                        'content' => $content,  

                                        // format content from your own css file if needed or use the
                                        // enhanced bootstrap css built by Krajee for mPDF formatting 
                                        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css', 

                                         // call mPDF methods on the fly
                                        'methods' => [ 
                                            
                                            'SetFooter'=>['{PAGENO}'],
                                        ]
                                    ]);

                                    // http response
                                    $response = Yii::$app->response;
                                    $response->format = \yii\web\Response::FORMAT_RAW;
                                    $headers = Yii::$app->response->headers;
                                    $headers->add('Content-Type', 'application/pdf');

                                    // return the pdf output as per the destination setting
                                    return $pdf->render(); 
                                    // $pdf->Output($dataInvoice->inv_number.'.pdf','C:\Users\abisalwa\Desktop');
                                
                                    
                                }
    }

    
}
