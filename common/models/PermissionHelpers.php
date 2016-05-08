<?php
namespace common\models;

use yii;
use yii\web\Controller;
use common\models\User;
use yii\helpers\Url;

class PermissionHelpers
{

  public static function userMustBeOwner($model_name, $model_id)
  {
    $connection = Yii::$app->db;

    $userid = Yii::$app->user->identity->id;

    $sql = "SELECT id FROM $model_name WHERE user_id=:userid AND id=:model_id";

    $command = $connection->createCommand($sql);
    $command->bindValue(":userid", $userid);
    $command->bindValue(":model_id", $model_id);

    if($result = $command->queryOne()){
      return true;
    } else {
      return false;
    }
  }

}