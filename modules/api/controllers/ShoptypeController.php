<?php


namespace app\modules\api\controllers;


use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class ShoptypeController extends ActiveController
{
    public $modelClass = 'app\models\ShopType';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // Добавляем атунтификацию через BasicAuth. Токен доступа отправляется как имя пользователя.
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            // Отключаем аутентификацию при запросе магазинов через GET.
            'except' => ['index', 'view'],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

}