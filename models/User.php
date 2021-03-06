<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

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
 * @property string $picture
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $password write-only password
 *
 * @property Auth[] $auths
 * @property Event[] $events
 * @property Event[] $eventsFavorites
 * @property Shop[] $shops
 * @property Shop[] $shopsFavorites
 * @property Happening[] $happeningsFavorites
 * @property ShopRating[] $shopRatings
 * @property UserAddress $userAddress
 * @property UserEvent[] $userEvents
 * @property UserShop[] $userShops
 *
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

  const RELATION_SHOPS = 'shops';

  static private $currentAuthUser = null;

  /**
   * статичный метод, возвращающий экземпляр текущего пользователя
   * @return User|null|\yii\db\ActiveRecord
   */
  static public function current() {
    if (Yii::$app->user->isGuest) {
      return new self();
    }
    if (is_null(self::$currentAuthUser)) {
      self::$currentAuthUser = self::find()->where([
        'id' => Yii::$app->user->id,
      ])->one();
    }
    return self::$currentAuthUser;
  }
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
      [['email', 'password_hash', 'username', 'auth_key',
        'password_reset_token'], 'required'],
      [['userAddressId'], 'integer'],
      [['accessToken'], 'string'],
      [['lastName', 'firstName', 'middleName', 'email', 'password_hash', 'fb', 'vk', 'username',
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
      'lastName' => 'Фамилия',
      'firstName' => 'Имя',
      'middleName' => 'Отчество',
      'email' => 'Email',
      'password_hash' => 'Password Hash',
      'userAddressId' => 'User Address ID',
      'fb' => 'Fb',
      'vk' => 'Vk',
      'accessToken' => 'Access Token',
      'username' => 'Логин',
      'picture' => 'Картинка',
      'auth_key' => 'Auth Key',
      'password_reset_token' => 'Password Reset Token',
    ];
  }

  public function fields()
  {
    return [
      'id', 'lastName', 'firstName', 'middleName', 'username', 'picture',
      'userAddress', 'eventsFavorites', 'shopsFavorites', 'happeningsFavorites'
    ];
  }

  public function extraFields()
  {
    return ['shops', 'events', 'happenings'];
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
  public function getUserEvents()
  {
    return $this->hasMany(UserEvent::className(), ['user_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getEventsFavorites()
  {
    return $this->hasMany(Event::className(), ['id' => 'event_id'])->where(['active' => 1])->viaTable('user_event', ['user_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getUserShops()
  {
    return $this->hasMany(UserShop::className(), ['user_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopsFavorites()
  {
    return $this->hasMany(Shop::className(), ['shopId' => 'shop_id'])->where(['shopActive' => 1])->viaTable('user_shop', ['user_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getHappeningsFavorites()
  {
    return $this->hasMany(Happening::className(), ['id' => 'happeningId'])->where(['active' => 1])->viaTable('userHappening', ['userId' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShops()
  {
    return $this->hasMany(Shop::className(), ['creatorId' => 'id'])->where(['shopActive' => 1]);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopRatings()
  {
    return $this->hasMany(ShopRating::className(), ['userId' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getEvents()
  {
    return $this->hasMany(Event::className(), ['creatorId' => 'id'])->where(['active' => 1]);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getHappenings()
  {
    return $this->hasMany(Happening::className(), ['creatorId' => 'id'])->where(['active' => 1]);
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
