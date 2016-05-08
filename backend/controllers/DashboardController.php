<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Unit;
use backend\models\PayBilling;
use backend\models\ComplainTb;

class DashboardController extends \yii\web\Controller
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

    public function actionIndex()
    {
        $this->layout = 'dashboard';
        
        $month=date('m');    
        $modelUnit = Unit::find()->count();
        $modelHuni = Unit::find()->where(['isoccupied'=>true])->count();
        $modelTagihan = PayBilling::find()->innerJoin('unit_charge_value', 'pay_billing.unit_charge_value_id=unit_charge_value.id')->where(['unit_charge_value.inv_month'=>$month])->all();
        $modelPembayaran = PayBilling::find()->innerJoin('unit_charge_value', 'pay_billing.unit_charge_value_id=unit_charge_value.id')->where(['unit_charge_value.inv_month'=>$month, 'pay_billing.status_pay'=>'OK'])->all();

        $modelComplain = ComplainTb::find()->orderBy('date_complain')->all();
        // foreach ($modelComplain as $modelComplain) {
        //     echo $modelComplain->complain;
        // }

        // die();

        return $this->render('index',[
            
            'modelUnit' => $modelUnit,
            'modelHuni' => $modelHuni,
            'modelTagihan' => $modelTagihan,    
            'modelPembayaran' => $modelPembayaran,
            'modelComplain' => $modelComplain,

            ]);
    }

}
