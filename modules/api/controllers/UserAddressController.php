<?php

namespace app\modules\api\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class UserAddressController extends ActiveController
{
  public $modelClass = 'app\models\UserAddress';

//  public function behaviors()
//  {
//    $behaviors = parent::behaviors();
//    // Добавляем аутентификацию через BasicAuth. Токен доступа отправляется как имя пользователя.
//    $behaviors['authenticator'] = [
//      'class' => HttpBasicAuth::className(),
//      // Отключаем аутентификацию при запросе токена.
//      'except' => ['view'],
//    ];
//    return $behaviors;
//  }

  public function actions()
  {
    $actions = parent::actions();
//    unset($actions['index']);
    return $actions;
  }
}
