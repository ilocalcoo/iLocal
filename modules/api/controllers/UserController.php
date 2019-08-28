<?php

namespace app\modules\api\controllers;

use app\models\Auth;
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
            'except' => ['login', 'register'],
        ];
        return $behaviors;
    }


    public function actionLogin()
    {
        // ищем пользователя по email
        $user = User::findByEmail(Yii::$app->request->post('email'));

        // id пользователя в соцсети
        $source_id = Yii::$app->request->post('source_id');
        // переданный токен
        $accessToken = Yii::$app->request->post('accessToken');
        // наименование соцсети
        $source = Yii::$app->request->post('source');

        /* @var Auth $auth */
        // Таблица auth содержит отношения аккаунта (user) к соцсетям, т.к. один аккаунт может принадлежать нескольким
        // соцсетям.
        $auth = Auth::find()->where([
            'source' => $source,
            'source_id' => $source_id,
        ])->one();

        if ($user) { // Если пользователь был найден по email, то проверяем токен.
            if ($accessToken === $user->accessToken) {
                // Если токен правильный, то возвращаем данные юзера.
                return $user;

            } else { // Если токен не совпадает, до запрашиваем соцсеть и затем проверяем полученные данные.
                $id = null; // id пользователя, который получим от соцсети.

                // У каждой соцсети разные запросы.
                if ($source == 'vkontakte') {
                    $request_params = array(
                        'user_id' => $source_id,
                        'v' => '5.95',
                        'access_token' => $accessToken
                    );
                    $get_params = http_build_query($request_params);
                    $result = json_decode(file_get_contents('https://api.vk.com/method/users.get?' . $get_params));
                    $id = $result->response[0]->id;
                }

                if ($source == 'google') {
                    $request_params = array(
                        'oauth_token' => $accessToken,
                    );
                    $get_params = http_build_query($request_params);
                    $result = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v2/userinfo?' . $get_params));
                    $id = $result->id;
                }

                if ($source == 'facebook') {
                    $request_params = array(
                        'access_token' => $accessToken,
                    );
                    $get_params = http_build_query($request_params);
                    $result = json_decode(file_get_contents('https://graph.facebook.com/' . $source_id . '?' . $get_params));
                    $id = $result->id;
                }

                // Если запрос прошел значит переданный accessToken верный, и от соцсети должен вернутся id позователя.
                // Сравниваем id переданный от клиента и id полученный от соцсети.
                if ((string)$source_id === (string)$id) {
                    // Если id совпадают, то сохраняем новый токен.
                    $user->accessToken = $accessToken;
                    if ($user->save()) {
                        // Если в таблице auth не найдена запись, т.е. данная соцсеть еще не привязана к юзеру, то
                        // добавляем ее.
                        if (!$auth) {
                            $auth = new Auth([
                                'user_id' => $user->id,
//                                'user_id' => Yii::$app->user->id,
                                'source' => $source,
                                'source_id' => $source_id,
                            ]);
                            $auth->save();
                        }
                        return $user;
                    }
                }
            }

        }

        // Если пользователь с таким email не найден, то просто возвращаем сообщение. Придется отправить запрос на
        // регистрацию.
        return ['message' => 'User not found!'];

    }

    public function actionRegister()
    {
        // Проверяем нет ли такого юзера.
        if (User::findByEmail(Yii::$app->request->post('email'))) {
            return ['message' => 'User already exists!'];
        }

        $user = new User([
            'username' => Yii::$app->request->post('username'),
            'firstName' => Yii::$app->request->post('firstName'),
            'middleName' => Yii::$app->request->post('middleName'),
            'lastName' => Yii::$app->request->post('lastName'),
            'email' => Yii::$app->request->post('email'),
            'accessToken' => Yii::$app->request->post('accessToken'),
            // Пароли больше не нужны, но оставили для совместимости. password генерируется в password_hash
            'password' => Yii::$app->security->generateRandomString(6),
        ]);
        // Тоже старый функционал. AuthKey нужен для галочки "Remember me"
        $user->generateAuthKey();
        $user->generatePasswordResetToken();

        $transaction = User::getDb()->beginTransaction();
        // пробуем сохранить пользователя.
        if ($user->save()) {
            $auth = new Auth([
                'user_id' => $user->id,
                'source' => Yii::$app->request->post('source'),
                'source_id' => Yii::$app->request->post('source_id'),
            ]);
            // Если пользователь сохранился, делаем запись в таблице auth
            if ($auth->save()) {
                $transaction->commit();
                return $user;
            }
        }
        return ['error' => 'User is not registered'];

    }

}