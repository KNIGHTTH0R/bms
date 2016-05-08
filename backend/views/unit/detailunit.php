<?php

use kartik\tabs\TabsX;
use yii\helpers\Html;
use backend\models\Person;
use backend\models\PersonAddress;
use yii\base\View;

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Data Detail Unit '. $this->title;

        
        
?>
<?php

echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'bordered' => TRUE,
    'fade' => TRUE,
    'encodeLabels'=>TRUE,
    'items' => [
        [
            'label' => 'Detail Unit',
            'content' => $content,
            'active' => true
        ],
        [
            'label' => 'Data Owner',
            'headerOptions' => ['style'=>'font-weight:bold'],
            'content' => $content1,
        ],
        [
            'label' => 'Data Tenant',
            'content' => $content2,
            'headerOptions' => ['style'=>'font-weight:bold'],
           
        ],
        [
            'label' => 'Data Invoice',
            'content' => $content3,
            'headerOptions' => ['style'=>'font-weight:bold'],
            
        ],

        [
            'label' => 'Data Outstanding',
            'content' => $content4,
            'headerOptions' => ['style'=>'font-weight:bold'],
            
        ],
        
    ],
]);

?>