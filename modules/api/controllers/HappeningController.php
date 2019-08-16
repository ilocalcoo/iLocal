<?php


namespace app\modules\api\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class HappeningController extends ActiveController
{
    public $modelClass = 'app\models\Happening';

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

}