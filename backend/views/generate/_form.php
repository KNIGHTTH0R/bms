<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;

/* @var $this yii\web\View */
/* @var $model base\models\DynamicModel */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Generate Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Generate', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
            <!-- left column -->            
    <div class="col-md-9">          
        <?php $form = ActiveForm::begin(); ?>
        <div class="box box-primary">
      <!-- general form elements -->
            <div class="box-body">
              
                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-12">
                            
                            <?= $form->field($model, 'interval')->dropDownList($options['interval'], 
                                         ['prompt'=>'-Choose Interval-'])->label('Recuring Interval'); 
                            ?>
                    
                      </div>
                    </div>
                  </div>           

                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6 bulan">
                            <div class="bulan">
                            <?= $form->field($model, 'month')->dropDownList($options['bulan'], 
                                         ['prompt'=>'-Choose a month-', 'id'=>'pilihbulan'])->label('Month'); 
                            ?>
                                                    
                            </div>
                      </div>
                      <div class="col-md-6 bulan3">
                            <div class="bulan3">
                            <?= $form->field($model, 'month3')->dropDownList($options['bulan3'], 
                                         ['prompt'=>'-Choose a month-', 'id'=>'pilihbulan3', 'required'])->label('Month'); 
                            ?>
                                                    
                            </div>
                      </div>
                      <div class="col-md-6 bulan6">
                            <div class="bulan6">
                            <?= $form->field($model, 'month6')->dropDownList($options['bulan6'], 
                                         ['prompt'=>'-Choose a month-', 'id'=>'pilihbulan6'])->label('Month'); 
                            ?>
                                                    
                            </div>
                      </div>    
                      <div class="col-md-6 bulan12">
                            <div class="bulan12">
                            <?= $form->field($model, 'month12')->dropDownList($options['bulan12'], 
                                         ['prompt'=>'-Choose a month-', 'id'=>'pilihbulan12'])->label('Month'); 
                            ?>
                                                    
                            </div>
                      </div>
                      <div class="col-md-6">
                            
                            <?= $form->field($model, 'year')->dropDownList($options['tahun'], 
                                         ['prompt'=>'-Choose a Year-'])->label('Year'); 
                                 ?>
                                             
                      </div>    

                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6">
                        <?= Html::submitButton('Generate', ['class' => 'btn btn-primary']) ?>
                      </div>
                    </div>
                  </div>

                <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
</div>
<?php 
    $this->registerJs('
        $(window).load(function(){
            $(".bulan3, .bulan6, .bulan12").hide();
        })

        $("#dynamicmodel-interval").on("change", function() {

          if(this.value=="MONTH"){
                document.getElementById("pilihbulan3").removeAttribute("required");
                document.getElementById("pilihbulan6").removeAttribute("required");
                document.getElementById("pilihbulan12").removeAttribute("required");
                $(".bulan").show();
                $(".bulan3").hide();
                $(".bulan6").hide();
                $(".bulan12").hide();
          }

          if(this.value=="3MONTH"){
                document.getElementById("pilihbulan").removeAttribute("required");
                document.getElementById("pilihbulan6").removeAttribute("required");
                document.getElementById("pilihbulan12").removeAttribute("required");
                $(".bulan").hide();
                $(".bulan3").show();
                $(".bulan6").hide();
                $(".bulan12").hide();
                
          }
          else if(this.value=="6MONTH"){
                $(".bulan").hide();
                $(".bulan6").show();
                $(".bulan3").hide();
                $(".bulan12").hide();
                document.getElementById("pilihbulan3").removeAttribute("required");
                document.getElementById("pilihbulan").removeAttribute("required");
                document.getElementById("pilihbulan12").removeAttribute("required");
          }
          else if(this.value=="YEARLY"){
                $(".bulan").hide();
                $(".bulan3").hide();
                $(".bulan6").hide();
                $(".bulan12").show();
                document.getElementById("pilihbulan3").removeAttribute("required");
                document.getElementById("pilihbulan6").removeAttribute("required");
                document.getElementById("pilihbulan").removeAttribute("required");
          }
          

        })

    ');

?> 
