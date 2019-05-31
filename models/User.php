<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $lastName
 * @property string $firstName
 * @property string $middleName
 * @property string $email
 * @property string $password_hash
 * @property int $userAddressId
 * @property string $fb
 * @property string $vk
 * @property string $accessToken
 * @property string $username
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $password write-only password
 *
 * @property Auth[] $auths
 * @property Shop[] $shops
 * @property UserAddress $userAddress
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lastName', 'firstName', 'email', 'password_hash', 'username', 'auth_key',
                'password_reset_token'], 'required'],
            [['userAddressId'], 'integer'],
            [['lastName', 'firstName', 'middleName', 'email', 'password_hash', 'fb', 'vk', 'accessToken', 'username',
                'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['userAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => UserAddress::className(), 'targetAttribute' => ['userAddressId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'lastName' => 'Last Name',
            'firstName' => 'First Name',
            'middleName' => 'Middle Name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'userAddressId' => 'User Address ID',
            'fb' => 'Fb',
            'vk' => 'Vk',
            'accessToken' => 'Access Token',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddress()
    {
        return $this->hasOne(UserAddress::className(), ['id' => 'userAddressId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShops()
    {
        return $this->hasMany(Shop::className(), ['creatorId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {

        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // реализуем аутентификацию через апи по токену
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерирует токен для доступа через апи
     */
    public function generateAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
