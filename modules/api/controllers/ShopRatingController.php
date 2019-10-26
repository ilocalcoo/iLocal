<?php


namespace app\modules\api\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class ShopRatingController extends ActiveController
{
  public $modelClass = 'app\models\ShopRating';

  public function behaviors()
  {
    $behaviors = parent::behaviors();
    // Добавляем атунтификацию через BasicAuth. Токен доступа отправляется как имя пользователя.
    $behaviors['authenticator'] = [
      'class' => HttpBasicAuth::className(),
      'except' => ['update'],
    ];
    return $behaviors;
  }

  public function actions()
  {
    $actions = parent::actions();
    unset($actions['index'], $actions['view']);
    return $actions;
  }
}