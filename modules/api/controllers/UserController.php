<?php

namespace app\modules\api\controllers;

use app\models\Auth;
use app\models\User;
use app\models\UserEvent;
use app\models\UserHappening;
use app\models\UserShop;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use Yii;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        // Добавляем атунтификацию через BasicAuth. Токен доступа отправляется как имя пользователя.
//        $behaviors['authenticator'] = [
//            'class' => HttpBasicAuth::className(),
//            // Отключаем аутентификацию при запросе токена.
//            'except' => ['login', 'register'],
//        ];
//        return $behaviors;
//    }


    public function actionLogin()
    {
        // email пользователя в соцсети
        $email = Yii::$app->request->post('email');

        // ищем пользователя по email
        $user = User::findByEmail($email);

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
                $isAccountVerified = false; // флаг проверки аккаунта

                // У каждой соцсети разные запросы.
                if ($source == 'vkontakte') {
                    $request_params = array(
                        'user_id' => $source_id,
                        'v' => '5.95',
                        'access_token' => $accessToken,
                    );
                    $get_params = http_build_query($request_params);
                    $result = json_decode(file_get_contents('https://api.vk.com/method/users.get?' . $get_params));
                    // Добавил проверки
                    if (isset($result->error)) {
                        return $result->error;
                    }
                    if (!isset($result->response[0]->id)) {
                        return ['message' => 'Vkontakte authorisation failed!'];
                    }
//                    $id = $result->response[0]->id;
                    // Если запрос прошел значит переданный accessToken верный, и от соцсети должен вернутся id позователя.
                    // Сравниваем id переданный от клиента и id полученный от соцсети. (Вконтакте email не возвращает)
                    $isAccountVerified = (string)$source_id === (string)$result->response[0]->id;
                }

                if ($source == 'google') {
                    $request_params = array(
                        'id_token' => $accessToken,
//                        'oauth_token' => $accessToken,
                    );
                    $get_params = http_build_query($request_params);
                    try {
                        $result = json_decode(file_get_contents('https://oauth2.googleapis.com/tokeninfo?' . $get_params));
//                    $result = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v2/userinfo?' . $get_params));
                        // Если запрос прошел значит переданный accessToken верный, и от соцсети должен вернутся email позователя.
                        // Сравниваем email переданный от клиента и email полученный от соцсети.
//                    $id = $result->id;
                        $isAccountVerified = $email === $result->email;
                    } catch (\Exception $exception) {
                        return ['message' => 'Google authorisation failed!'];
                    }
                }

                if ($source == 'facebook') {
                    $request_params = array(
                        'access_token' => $accessToken,
                    );
                    $get_params = http_build_query($request_params);
                    try {
                        $result = json_decode(file_get_contents('https://graph.facebook.com/' . $source_id . '?' . $get_params));
//                    $id = $result->id;
                        $isAccountVerified = (string)$source_id === (string)$result->id;
                    } catch (\Exception $exception) {
                        return ['message' => 'Facebook authorisation failed!'];
                    }
                }

                // Если аккаунт прошел проверку, то сохраняем новый токен.
                if ($isAccountVerified) {
//                if ((string)$source_id === (string)$id) {// Если id совпадают, то сохраняем новый токен.
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

    public function actionFavorite()
    {
        // сохраняем тип того, что юзер хочет добавить в избранное
        $kind = Yii::$app->request->post('kind');
        switch ($kind) {
            case 'shop':
                $class = UserShop::class;
                break;
            case 'event':
                $class = UserEvent::class;
                break;
            case 'happening':
                $class = UserHappening::class;
                break;
            default:
                return ['error' => 'Unknown kind of favorite!'];
        }

        // Проверяем есть ли в пост запросе source_id и user_id
        if (is_null(Yii::$app->request->post('source_id')) || (is_null(Yii::$app->request->post('user_id')))) {
            return ['error' => 'Wrong request!'];
        }
        $source_id = Yii::$app->request->post('source_id');
        $user_id = Yii::$app->request->post('user_id');

        // Проверяем существует ли такой пользователь
        if (User::findOne(['id' => $user_id]) == '') {
            return ['error' => 'User not found!'];
        }

        $user = User::findOne(['id' => $user_id]);
        $kindFavorites = $kind . 'sFavorites';

        if (!is_null(Yii::$app->request->post('delete'))) {
            foreach ($user->$kindFavorites as $item) {
                if ($item[($kind == 'shop') ? 'shopId' : 'id'] == $source_id) {
                    if ($kind == 'happening') {
                        return UserHappening::findOne(['userId' => $user_id, 'happeningId' => $source_id])->delete();
                    } else {
                        return $class::findOne(['user_id' => $user_id, $kind . '_id' => $source_id])->delete();
                    }
                }
            }
            return ['error' => ucfirst($kind) . ' is not in favorites!'];
        }

        // Проверяем существует ли объект, который нужно добавить в избранное
        $sourceClass = 'app\models\\' . ucfirst($kind);
        if ($sourceClass::findOne([($kind == 'shop') ? 'shopId' : 'id' => $source_id]) == '') {
            return ['error' => ucfirst($kind) . ' not found!'];
        }

        // Проверяем есть ли у юзера уже избранное
        foreach ($user->$kindFavorites as $item) {
            if ($item[($kind == 'shop') ? 'shopId' : 'id'] == $source_id) {
                return ['error' => 'User already has this ' . $kind . ' in favorites!'];
            }
        }

        // Добавляем избранное
        $fav = new $class();
        $tableFields = array_keys($class::getTableSchema()->columns);
        if ($tableFields[0] == 'id') {
            array_shift($tableFields);
        }
        $fav[$tableFields[0]] = $user_id;
        $fav[$tableFields[1]] = $source_id;
        $fav->save();
        return User::findOne(['id' => $user_id]);
    }

}