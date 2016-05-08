<?php

use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\base\View;

$this->title = 'Data pembayaran tagihan dan oustanding seluruh unit';
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

        
        
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
            'label' => 'Monthly Data Payment All Unit',
            'headerOptions' => ['style'=>'font-weight:bold'],
            'content' => $content1,
        ],
        [
            'label' => 'Monthly Data Oustanding All Unit',
            'content' => $content2,
            'headerOptions' => ['style'=>'font-weight:bold'],
           
        ],
        [
            'label' => 'Year to Date Data Payment All Unit',
            'content' => $content3,
            'headerOptions' => ['style'=>'font-weight:bold'],
           
        ],
        [
            'label' => 'Year to Date Data Oustanding All Unit',
            'content' => $content4,
            'headerOptions' => ['style'=>'font-weight:bold'],
           
        ],
       
        
    ],
]);

?>