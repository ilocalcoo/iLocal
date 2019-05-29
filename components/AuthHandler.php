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
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $accessToken = $this->client->getAccessToken()->getToken();

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
                preg_match('/(\S+)\s(\S*)\s(\S+)/', $nickname, $nicknameArray);
                $firstName = $nicknameArray[1];
                $middleName = $nicknameArray[2];
                $lastName = $nicknameArray[3];
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
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login (авторизация)
                /* @var User $user */
                $user = $auth->user;
                $this->updateUserInfo($user, $nickname);
                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            } else { // signup (регистрация)
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t(
                            'app',
                            "Пользователь с такой электронной почтой как в {client} уже существует, но с ним не связан. Для начала войдите на сайт используя электронную почту, для того, что бы связать её.",
                            ['client' => $this->client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $nickname,
                        'firstName' => $firstName,
                        'middleName' => $middleName,
                        'lastName' => $lastName,
//                        'github' => $nickname,
                        'email' => $email,
                        'password' => $password,
                        'accessToken' => $accessToken,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();

                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
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
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user, $username)
    {
//        $attributes = $this->client->getUserAttributes();
//        $username = ArrayHelper::getValue($attributes, 'name');
        if ($user->username === null && $username) {
            $user->username = $username;
            $user->save();
        }
    }

}