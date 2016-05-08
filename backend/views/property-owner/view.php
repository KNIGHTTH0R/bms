<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PropertyOwner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Property Owners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-owner-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p>
                        <?= Html::a('Index', ['index'], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <table class="table table-striped table-bordered detail-view">
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td><?=$model->id ?></td>
                            </tr>
                            <tr>
                                <td>Code</td>
                                <td><?=$model->code ?></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?=$model->name ?></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>
                                    <p><label for="building" class="col-md-2">Building</label><?=$model->address['building_name'] ?></p>
                                    <p><label for="street" class="col-md-2">Street</label><?=$model->address['street'] ?></p>
                                    <p><label for="city" class="col-md-2">City</label><?=$model->address['city'] ?></p>
                                    <p><label for="province" class="col-md-2">Province</label><?=$model->address['Province'] ?></p>
                                    <p><label for="country" class="col-md-2">Country</label><?=$model->address['contry'] ?></p>
                                    <p><label for="postal_code" class="col-md-2">Postal Code</label><?=$model->address['postal_code'] ?></p>
                                    <p><label for="email" class="col-md-2">Email</label><?=$model->address['email'] ?></p>
                                    <p><label for="phone" class="col-md-2">Phone</label><?=$model->address['phone'] ?></p>
                                    <p><label for="fax" class="col-md-2">Fax</label><?=$model->address['fax'] ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>Tax Reg</td>
                                <td><?=$model->tax_reg ?></td>
                            </tr>
                            <tr>
                                <td>Create At</td>
                                <td><?=Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                            </tr>
                            <tr>
                                <td>Create By</td>
                                <td><?=$model->staffCreateName ?></td>
                            </tr>
                            <tr>
                                <td>Update At</td>
                                <td>
                                    <?=Yii::$app->formatter->asDatetime($model->updated_at) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Update By</td>
                                <td><?=$model->staffUpdateName ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
