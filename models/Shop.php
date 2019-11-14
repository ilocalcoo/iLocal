<?php

namespace app\models;

use Cassandra\Uuid;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shop".
 *
 * @property int $shopId
 * @property int $shopActive
 * @property int $creatorId
 * @property string $shopShortName
 * @property string $shopFullName
 * @property int $shopTypeId
 * @property string $shopPhone
 * @property string $shopWeb
 * @property int $shopAddressId
 * @property string $shopCostMin
 * @property string $shopCostMax
 * @property string $shopMiddleCost
 * @property string $shopWorkTime
 * @property string $shopAgregator
 * @property string $shopShortDescription
 * @property string $shopFullDescription
 * @property string $shopLinkPdf
 * @property int $shopRating
 * @property int $shopStatusId
 * @property int $isItFar
 *
 * @property ShopAddress $shopAddress
 * @property ShopStatus $shopStatus
 * @property ShopType $shopType
 * @property User $creator
 * @property ShopPhoto[] $shopPhotos
 * @property ShopFiles[] $shopFiles
 * @property ShopRating[] $shopRatings
 * @property ShopRating[] $shopAvgRating
 * @property Event[] $events
 * @property UserShop[] $userShops
 * @property User[] $usersFavorites
 * @property Happening[] $happenings
 */
class Shop extends \yii\db\ActiveRecord
{

  const RELATION_SHOP_ADDRESS = 'shopAddress';
  const RELATION_SHOP_TYPE = 'shopType';
  const RELATION_SHOP_PHOTOS = 'shopPhotos';
  const RELATION_SHOP_EVENTS = 'events';
  const RELATION_SHOP_HAPPENINGS = 'happenings';

  const SHOP_ACTIVE_TRUE = 1;
  const SHOP_ACTIVE_FALSE = 0;

  const IS_IT_FAR_TRUE = 1;
  const IS_IT_FAR_FALSE = null;

  const NUMBER_OF_DISPLAYED_PAGES = 4;

  const SHOP_MIDDLE_COST_0 = null;
  const SHOP_MIDDLE_COST_1 = 1;
  const SHOP_MIDDLE_COST_2 = 2;
  const SHOP_MIDDLE_COST_3 = 3;
  const SHOP_MIDDLE_COST_4 = 4;
  const SHOP_MIDDLE_COST_5 = 5;
  const SHOP_MIDDLE_COST = [self::SHOP_MIDDLE_COST_0, self::SHOP_MIDDLE_COST_1, self::SHOP_MIDDLE_COST_2, self::SHOP_MIDDLE_COST_3, self::SHOP_MIDDLE_COST_4, self::SHOP_MIDDLE_COST_5];
  const SHOP_MIDDLE_COST_LABELS = [
    self::SHOP_MIDDLE_COST_0 => null,
    self::SHOP_MIDDLE_COST_1 => '₽',
    self::SHOP_MIDDLE_COST_2 => '₽₽',
    self::SHOP_MIDDLE_COST_3 => '₽₽₽',
    self::SHOP_MIDDLE_COST_4 => '₽₽₽₽',
    self::SHOP_MIDDLE_COST_5 => '₽₽₽₽₽',
  ];

//  const SCENARIO_STEP1 = 'step1';
//  const SCENARIO_STEP2 = 'step2';
//  const SCENARIO_STEP3 = 'step3';
//  const SCENARIO_STEP4 = 'step4';
//  const SCENARIO_DEFAULT = 'delete';
//  const SCENARIO_RATING = 'rating';

    /**
   * @var UploadedFile[]
   */
  public $uploadedShopPhoto;


  public $distance;


  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'shop';
  }

  public function behaviors()
  {
    return [
      [
        'class' => BlameableBehavior::className(),
        'createdByAttribute' => 'creatorId',
        'updatedByAttribute' => false,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['shopActive', 'creatorId', 'shopTypeId', 'shopAddressId', 'shopStatusId', 'shopRating', 'isItFar'],
        'integer'],
      [['shopShortName', 'shopTypeId'], 'required'],
      [['shopMiddleCost'], 'string'],
      [['shopShortName'], 'string', 'max' => 75],
      [['shopFullName', 'shopPhone', 'shopWeb', 'shopCostMin',
        'shopCostMax', 'shopWorkTime', 'shopAgregator',
        'shopShortDescription', 'shopLinkPdf'], 'string', 'max' => 255],
      [['shopFullDescription'], 'string', 'max' => 1500],
      [['shopAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => ShopAddress::className(), 'targetAttribute' => ['shopAddressId' => 'id']],
      [['shopStatusId'], 'exist', 'skipOnError' => true, 'targetClass' => ShopStatus::className(), 'targetAttribute' => ['shopStatusId' => 'id']],
      [['shopTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => ShopType::className(), 'targetAttribute' => ['shopTypeId' => 'id']],
      [['creatorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute'
      => ['creatorId' => 'id']],
        //[['uploadedShopFile'], 'file', 'extensions' => 'pdf,PDF', 'checkExtensionByMimeType' => false],
        [['uploadedShopPhoto'], 'file', 'extensions' => 'jpeg, jpg, png', 'maxFiles' => 10],

    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'shopId' => 'Shop ID',
      'creatorId' => 'Creator ID',
      'shopActive' => 'Shop Active',
      'shopShortName' => 'Название места',
      'shopFullName' => 'Shop Full Name',
      'shopTypeId' => 'Категория магазина',
      'shopPhone' => 'Телефон',
      'shopWeb' => 'Сайт',
      'shopAddressId' => 'Адрес',
      'shopCostMin' => 'Минимальная цена',
      'shopCostMax' => 'Максимальная цена',
      'shopMiddleCost' => 'Средний чек',
      'shopWorkTime' => 'Часы работы',
      'shopAgregator' => 'Shop Agregator',
      'shopShortDescription' => 'Краткое описание места',
      'shopFullDescription' => 'Полное описание места',
      'shopLinkPdf' => 'Ссылка на pdf',
      'shopRating' => 'Shop Rating',
      'shopStatusId' => 'Shop Status ID',
    ];
  }


//  public function scenarios()
//  {
//    return [
//      self::SCENARIO_DEFAULT => ['*'],
//      self::SCENARIO_STEP1 => ['creatorId', 'shopTypeId', 'shopShortName', 'shopShortDescription', 'shopFullDescription'],
//      self::SCENARIO_STEP2 => ['uploadedShopPhoto'],
//      self::SCENARIO_STEP3 => ['shopAddressId', 'shopPhone', 'shopWeb', 'shopWorkTime'],
//      self::SCENARIO_STEP4 => ['shopCostMin', 'shopCostMax', 'shopMiddleCost', 'shopLinkPdf'],
//      self::SCENARIO_RATING => ['shopRating'],
//    ];
//  }


  public function fields()
  {
    return ArrayHelper::merge(parent::fields(), [
        'shopPhotos', 'events', 'shopAddress', 'happenings',
      'shopAvgRating'
    ]);
  }
  
  public function uploadShopPhoto()
  {
    if ($this->validate()) {
      foreach ($this->uploadedShopPhoto as $file) {
          if ($file->extension == 'pdf') {
              continue;
          }
        $fileName = 'img/shopPhoto/' . $file->baseName . '.' . $file->extension;
          is_uploaded_file($file->tempName) ?
              $file->saveAs($fileName) :
              rename($file->tempName,$fileName);
        ThumbGenerator::generate($fileName, $this->shopId);
        $model = new ShopPhoto();
        $model->shopPhoto = $file->baseName . '.' . $file->extension;
        $model->shopId = $this->shopId;
        $model->save();
      }
      return true;
    } else {
      return false;
    }
  }

    /**
     * @param $file UploadedFile
     * @return bool
     * @throws \yii\base\Exception
     */
    public function uploadShopFiles($file)
    {
        if (!is_object($file)) {
            return false;
        }
        FileHelper::createDirectory('pdf');
        if (($file->extension == 'pdf') || ($file->extension == 'PDF')) {
            $fileName = 'pdf/'.$this->uuid().'.pdf';
            $file->saveAs($fileName);
//        print_r($file->extension);
//        Yii::$app->end(0);
//        $model = new ShopFiles();
//        $model->shopFile = $fileName;
//        $model->shopId = $this->shopId;
//        $model->save();
            $this->shopLinkPdf = $fileName;
            return true;
        }

        return false;
    }

  public function shopRating()
  {
    $shopRating = ShopRating::find()->where(['shopId' => $this->shopId])->asArray()->all();
    $value = null;
    foreach ($shopRating as $rating) {
      $value += $rating['rating'];
    }
    $this->shopRating = round($value / count($shopRating));
    if ($this->save()) {
      return true;
    }
    return false;
  }

  public function getUserId()
  {
    if (Yii::$app->user->isGuest) {
      return 0;
    } else {
      return Yii::$app->user->id;
    }
  }

  public function myIsGuest()
  {
    if (Yii::$app->user->isGuest) {
      return 1;
    } else {
      return 0;
    }

  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopAddress()
  {
    return $this->hasOne(ShopAddress::className(), ['id' => 'shopAddressId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopStatus()
  {
    return $this->hasOne(ShopStatus::className(), ['id' => 'shopStatusId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopType()
  {
    return $this->hasOne(ShopType::className(), ['id' => 'shopTypeId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCreator()
  {
    return $this->hasOne(User::className(), ['id' => 'creatorId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getEvents()
  {
    return $this->hasMany(Event::className(), ['eventOwnerId' => 'shopId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getTopEvents()
  {
    return Event::find()->byTop()->limit(Event::MAX_SHOW_EVENTS);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopPhotos()
  {
    return $this->hasMany(ShopPhoto::className(), ['shopId' => 'shopId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopRatings()
  {
    return $this->hasMany(ShopRating::className(), ['shopId' => 'shopId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getShopAvgRating()
  {
    return $this->hasMany(ShopRating::className(), ['shopId' => 'shopId'])->average('rating');
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getUserShops()
  {
    return $this->hasMany(UserShop::className(), ['shop_id' => 'shopId']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getUsersFavorites()
  {
    return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_shop', ['shop_id' => 'shopId']);
  }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopFiles()
    {
        return $this->hasOne(ShopFiles::className(), ['shopId' => 'shopId']);
    }

  /**
   * @param array $c1 first coordinate
   * @param array $c2 second coordinate
   * @return float distance between coordinates
   */
  public static function getDistance($c1, $c2)
  {
    $r = 6371000; // Earth radius in m
    // get attitude and latitude from array
    $lat1 = $c1[0];
    $lat2 = $c2[0];
    $lon1 = $c1[1];
    $lon2 = $c2[1];

    $dLat = deg2rad($lat2 - $lat1);  // deg2rad below
    $dLon = deg2rad($lon2 - $lon1);
    $a =
      sin($dLat / 2) * sin($dLat / 2) +
      cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
      sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return round($r * $c); // Distance in m
  }

  /**
   * @param int $dist distance
   * @return string beauty string as '100 м' or '1.2 км'
   */
  public static function beautifyDistance($dist) {

    if ($dist < 1000) {
      $dist .= ' м';
    } else {
      $dist = floor($dist / 100);
      $dist = ((($dist % 10) == 0) ? (floor($dist / 10)) : ($dist / 10));
      $dist .= ' км';
    }
    return $dist;
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getHappenings()
  {
    return $this->hasMany(Happening::className(), ['shopId' => 'shopId']);
  }

  /**
   * Method cleans isItFar field in shop table
   */
  // этот метод неактуален, как и поле isItFar в таблице shop
  private static function cleanIsItFar() {
    foreach (self::find()->where(['isItFar' => self::IS_IT_FAR_TRUE])->all() as $shop) {
      $shop->isItFar = self::IS_IT_FAR_FALSE;
      $shop->save(false);
    }
  }

  /**
   * @param $query ActiveQuery запрос к местам
   * @param $userPoint array точка выбранная юзером
   * @param $range integer радиус в метрах
   * @return mixed массив мест, которые входят в радиус поиска
   */
  public static function getShopsInRange($query, $userPoint, $range) {
    /** @var Shop[] $shops */
    $shops = $query->all();
    foreach ($shops as $key => $shop) {
      $shopCoords = [$shop->shopAddress->latitude, $shop->shopAddress->longitude];
      $distance = self::getDistance($userPoint, $shopCoords);
      if ($distance > $range) {
        unset($shops[$key]);
      } else {
        $shop->distance = $distance;
      }
    }
    return $shops;
  }

  /**
   * @param $userPoint array координаты точки юзера, пример [1.3, 2.5]
   * @return bool проверяет валидность данных
   */
  public static function isUserPointValid($userPoint) {
    $c1 = array_shift($userPoint);
    $c2 = array_shift($userPoint);
    if (!is_numeric($c1) || !is_numeric($c2) || ($c1 < 0) || ($c2 < 0)) {
      return false;
    }
    return true;
  }

    private function uuid($prefix = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid  = substr($chars,0,8) . '-';
        $uuid .= substr($chars,8,4) . '-';
        $uuid .= substr($chars,12,4) . '-';
        $uuid .= substr($chars,16,4) . '-';
        $uuid .= substr($chars,20,12);

        return $prefix . $uuid;
    }

}
