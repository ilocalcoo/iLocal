<?php


namespace app\modules\api\controllers;


use app\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use Yii;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // Добавляем атунтификацию через BasicAuth. Токен доступа отправляется как имя пользователя.
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            // Отключаем аутентификацию при запросе токена.
            'except' => ['token'],
        ];
        return $behaviors;
    }

    /**
     * Метод генерирует токен после успешной проверки логина и пароля
     * @return string Возвращает токен
     */
    public function actionToken()
    {
        if ($user = User::findByUsername(Yii::$app->request->post('email'))) {
            if ($user->validatePassword(Yii::$app->request->post('password'))) {
                $user->generateAccessToken();
                $user->save();
                return $user->accessToken;
            }
        }
    }
}