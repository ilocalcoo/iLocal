<?php

namespace app\components;

use app\models\Auth;
use app\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * Экземпляр OAuth2 - google, facebook, vkontakte.
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Метод вызывается когда пользователь был успешно аутентифицирован через внешний сервис c помощью
     * yii\authclient\AuthAction.
     */
    public function handle()
    {
        // Через экземпляр $client мы можем извлечь полученную информацию.
        $attributes = $this->client->getUserAttributes();

        // Это для тестов, чтобы получить обновленный токен от соцсети (с гуглом теперь не работает, там надо получать id_token).
//        $accessToken = $this->client->getAccessToken()->getToken();
//        var_dump($attributes, $accessToken);exit;

        // У каждой соцсети свои наименования полей.
        switch ($this->client->getName()) {
            case 'google':
                $email = ArrayHelper::getValue($attributes, 'email');
                $id = ArrayHelper::getValue($attributes, 'id');
                $nickname = ArrayHelper::getValue($attributes, 'name');
                $firstName = ArrayHelper::getValue($attributes, 'given_name');
                $middleName = null;
                $lastName = ArrayHelper::getValue($attributes, 'family_name');
                break;
            case 'facebook':
                $email = ArrayHelper::getValue($attributes, 'email');
                $id = ArrayHelper::getValue($attributes, 'id');
                $nickname = ArrayHelper::getValue($attributes, 'name');
//                preg_match('/(\S+)\s(\S*)\s(\S+)/', $nickname, $nicknameArray);
//                $firstName = $nicknameArray[1];
//                $middleName = $nicknameArray[2];
//                $lastName = $nicknameArray[3];
                $firstName = ArrayHelper::getValue($attributes, 'first_name');
                $middleName = ArrayHelper::getValue($attributes, 'middle_name');
                $lastName = ArrayHelper::getValue($attributes, 'last_name');
                break;
            case 'vkontakte':
                $email = ArrayHelper::getValue($attributes, 'email');
                $id = ArrayHelper::getValue($attributes, 'id');
                $nickname = ArrayHelper::getValue($attributes, 'screen_name');
                $firstName = ArrayHelper::getValue($attributes, 'first_name');
                $middleName = null;
                $lastName = ArrayHelper::getValue($attributes, 'last_name');
                break;
            default:
                $email = ArrayHelper::getValue($attributes, 'email');
                $id = ArrayHelper::getValue($attributes, 'id');
                $nickname = ArrayHelper::getValue($attributes, 'name');
                $firstName = ArrayHelper::getValue($attributes, 'given_name');
                $middleName = null;
                $lastName = ArrayHelper::getValue($attributes, 'family_name');
        }

        /* @var Auth $auth */
        // Таблица auth содержит отношения аккаунта (user) к соцсетям, т.к. один аккаунт может принадлежать нескольким
        // соцсетям.
        $auth = Auth::find()->where([
            // наименование соцсети
            'source' => $this->client->getId(),
            // id пользователя в этой соцсети
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            // Если пользователь гость и в таблице auth существует запись, то проводим аутентификацию этого пользователя.
            if ($auth) { // login (авторизация)
                /* @var User $user */
                // Получаем юзера, который относится к соцсети в таблице auth.
                $user = $auth->user;
                // Обновляем username.
                $this->updateUserInfo($user, $nickname);
                // Авторизуем пользователя (можно в конфиге задать время сессии)
                Yii::$app->user->returnUrl = Yii::$app->request->getReferrer();
                Yii::$app->user->login($user);
//                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            } else { // signup (регистрация)
                // Если пользователь гость и в таблице auth записи не существует, то создаём нового пользователя и
                // запись в таблице auth. После проводим аутентификацию пользователя.
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    // Если пользователь с таким email уже существует, то отменяем регистрацию и ввыводим сообщение.
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t(
                            'app',
                            "Пользователь с такой электронной почтой как в {client} уже существует, но с ним не 
                            связан. Для начала войдите на сайт под аккаунтом, зарегистрированным на эту электронную 
                            почту, для того, что бы связать её.",
                            ['client' => $this->client->getTitle()]),
                    ]);
                } else { // Если пользователь новый, то регистрируем его.
                    // Пароли больше не нужны, но оставили для совместимости. password генерируется в password_hash
                    $password = Yii::$app->security->generateRandomString(6);
                    // Создаем нового пользователя и присваиваем ему полученные значения.
                    $user = new User([
                        'username' => $nickname,
                        'firstName' => $firstName,
                        'middleName' => $middleName,
                        'lastName' => $lastName,
//                        'github' => $nickname,
                        'email' => $email,
                        'password' => $password,
//                        'accessToken' => $accessToken,
                    ]);
                    // Тоже старый функционал. AuthKey нужен для галочки "Remember me"
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();

                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
                        // Создаем запись в таблице auth о том к какой соцсети принадлежит юзер.
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->returnUrl = Yii::$app->request->getReferrer();
                            Yii::$app->user->login($user);
//                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            // Если пользователь прошёл аутентификацию и запись в таблице auth не найдена, то пытаемся подключить
            // дополнительный аккаунт (сохранить его данные в таблицу auth).
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    $this->updateUserInfo($user, $nickname);
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                // Если пользователь прошёл аутентификацию и запись в таблице auth уже существует, то значит аккаунт
                // занят, отменяем привязку аккаунта.
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * Обновляет username если пользователь вошел из другой соцсети.
     * @param User $user
     * @param string $username
     */
    private function updateUserInfo(User $user, $username)
    {
        if ($user->username !== $username) {
            $user->username = $username;
            $user->save();
        }
    }

}