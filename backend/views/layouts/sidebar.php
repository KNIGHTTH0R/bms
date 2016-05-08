<?php 

use yii\helpers\Html;
use yii\helpers\Url;
?>
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <?=Html::img(isset(Yii::$app->user->identity->avatar) ? Yii::$app->user->identity->avatar : Yii::$app->params['uploadUrl'] . 'profiles/' . 'default_user.png', ['class' => 'img-circle',]) ?>
            </div>
            <div class="pull-left info"><?php
            if (Yii::$app->user->isGuest) {
                
            } else {
              echo '<p>'.Yii::$app->user->identity->fullname.'</p>';
            }

            ?>
              
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..." />
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->


          <?php 
          /*
          
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="#"><i class="fa fa-gear text-red"></i> <span>Setup</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                
                <li><a href="<?php echo Url::to(['property-owner/index']);?>">Property Owner</a></li>
                <li><a href="<?php echo Url::to(['property-man/index']);?>">Property Management</a></li>
                <li><a href="<?php echo Url::to(['property-only/index']);?>">Property</a></li>
                //<li><a href="<?php echo Url::to(['property-only/scope']);?>">Set Property Scope</a></li>
                <li><a href="<?php echo Url::to(['building/index']);?>">Building</a></li>
                <li><a href="<?php echo Url::to(['unit-type/index']);?>">Unit Type</a></li>
                <li><a href="<?php echo Url::to(['unit/index']);?>">Unit</a></li>
                <li><a href="<?php echo Url::to(['unit-charge/index']);?>">Unit Charge</a></li>
                <li><a href="<?php echo Url::to(['unit-charge-value/index']);?>">Unit Charge Value</a></li>
                <li><a href="<?php echo Url::to(['unit-meter/index']);?>">Unit Meter</a></li>
                <li><a href="<?php echo Url::to(['meter-read/index']);?>">Meter Read</a></li>
                <li><a href="<?php echo Url::to(['tariff/index']);?>">Tariff</a></li>
                <li><a href="<?php echo Url::to(['person/index']);?>">Person</a></li>
                <li><a href="<?php echo Url::to(['unit-history/index']);?>">Unit History</a></li>
                
                
                             </ul>
            </li>
            <li><a href="setting.php"><i class="fa fa-gear text-green"></i> <span>Management</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                
                
                <!-- <li><a href="tariffstand.php">Tariff</a></li>
                <li><a href="unitchrstand.php">Unit Charge</a></li>
                <li><a href="crmstand.php">Charge Record Meter</a></li>
                <li><a href="crostand.php">Charge Record Other</a></li>
                <li><a href="meterstand.php">Meter Read</a></li> -->
                <li><a href="<?php echo Url::to(['generate/create']);?>">Generate Billing</a></li>
                <li><a href="datagenerate.php">Invoice Data</a></li>
                <li><a href="staffstand.php">Staff</a></li>
              </ul>
            </li>

            <li><a href="#"><i class="fa fa-money text-yellow"></i> <span>Accounting</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?= Url::to(['coa/index']) ?>">Setting COA</a></li>
                <li><a href="<?= Url::to(['jurnal/index']) ?>">Jurnal</a></li>
              </ul>
            </li>
            
          </ul><!-- /.sidebar-menu -->

          */ ?>

          <?php
          echo \yii\widgets\Menu::widget([
              'items' => [
                ['label' => 'MENU', 'options' => ['class' => 'header']],
                ['label'=>'Home', 'url'=>['dashboard/index'], 'template' => '<a href="{url}"><i class="fa fa-home text-green"></i><span>{label}</span></a>'],
                ['label' => 'Setup', 
                    'template' => '<a href="#"><i class="fa fa-gear text-red"></i><span>{label}</span><i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label'=>'Property Owner', 'url'=>['property-owner/index']],
                        ['label'=>'Property Management', 'url'=>['property-man/index']],
                        ['label'=>'Property', 'url'=>['property-only/index']],
                        //['label'=>'Set Property Scope', 'url'=>['property-only/scope']],
                        ['label'=>'Building', 'url'=>['building/index']],
                        ['label'=>'Unit Type', 'url'=>['unit-type/index']],
                        ['label'=>'Unit', 'url'=>['unit/index']],
                        ['label'=>'Type Charge', 'url'=>['type-charge/index']],
                        ['label'=>'Unit Charge', 'url'=>['unit-charge/index']],
                        // ['label'=>'Unit Charge Value', 'url'=>['unit-charge-value/index']],
                        ['label'=>'Unit Meter', 'url'=>['unit-meter/index']],
                        ['label'=>'Tariff', 'url'=>['tariff/index']],
                        ['label'=>'Person', 'url'=>['person/index']],
                        //['label'=>'unit-history', 'url'=>['unit-history/index']]
                    ]
                ],
                ['label' => 'Management',
                    'template' => '<a href="#"><i class="fa fa-cubes text-green"></i><span>{label}</span><i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label'=>'Unit Detail', 'url'=>['unit/management']],
                        ['label'=>'Meter Read', 'url'=>['meter-read/index']],
                        ['label'=>'Generate Billing', 'url'=>['generate/create']],
                        ['label'=>'Invoice Data', 'url'=>['unit-charge-value/invoice']],
                        ['label'=>'Collection Data', 'url'=>['unit-charge-value/collection']],
                        //['label'=>'Invoice Data', 'url'=>'#'],
                        ['label'=>'Staff', 'url'=>['staff/index']]
                    ]
                ],

                ['label' => 'SDM',
                    'template' => '<a href="#"><i class="fa fa-users text-white"></i><span>{label}</span><i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label'=>'Employee Group', 'url'=>['employee-group/index']],
                        ['label'=>'Employee Data', 'url'=>['employee/index']],
                        ['label'=>'Employee Transaction', 'url'=>['employee-transaction/index']]
                        
                    ]
                ],
                ['label' => 'Customer Care',
                    'template' => '<a href="#"><i class="fa fa-thumbs-up text-yellow"></i><span>{label}</span><i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label'=>'Complain', 'url'=>['complain-tb/index']],
                        
                    ]
                ],

                ['label' => 'Accounting',
                    'template' => '<a href="#"><i class="fa fa-money text-blue"></i><span>{label}</span><i class="fa fa-angle-left pull-right"></i></a>',
                    'items' => [
                        ['label'=>'Setting COA', 'url'=>['coa/index']],
                        ['label'=>'Jurnal', 'url'=>['jurnal/index']],
                        ['label'=>'Ledger', 'url'=>['report-ledger/index']]
                    ]
                ]
              ],
              'options' => [
                'class' => 'sidebar-menu'
              ],
              'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
              'activateParents' => true
          ]);

          ?>

        </section>
    </aside>
