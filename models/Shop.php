<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
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
 *
 * @property ShopAddress $shopAddress
 * @property ShopStatus $shopStatus
 * @property ShopType $shopType
 * @property User $creator
 * @property ShopPhoto[] $shopPhotos
 * @property ShopRating[] $shopRatings
 * @property Event[] $events
 * @property UserShop[] $userShops
 * @property User[] $usersFavorites
 */
class Shop extends \yii\db\ActiveRecord
{

    const RELATION_SHOP_ADDRESS = 'shopAddress';
    const RELATION_SHOP_TYPE = 'shopType';
    const RELATION_SHOP_PHOTOS = 'shopPhotos';
    const RELATION_SHOP_EVENTS = 'events';

    const SHOP_ACTIVE_TRUE = 1;
    const SHOP_ACTIVE_FALSE = 0;

    const SHOP_MIDDLE_COST_1 = 1;
    const SHOP_MIDDLE_COST_2 = 2;
    const SHOP_MIDDLE_COST_3 = 3;
    const SHOP_MIDDLE_COST_4 = 4;
    const SHOP_MIDDLE_COST_5 = 5;
    const SHOP_MIDDLE_COST = [self::SHOP_MIDDLE_COST_1, self::SHOP_MIDDLE_COST_2, self::SHOP_MIDDLE_COST_3, self::SHOP_MIDDLE_COST_4,self::SHOP_MIDDLE_COST_5];
    const SHOP_MIDDLE_COST_LABELS = [
        self::SHOP_MIDDLE_COST_1 =>'₽',
        self::SHOP_MIDDLE_COST_2 =>'₽₽',
        self::SHOP_MIDDLE_COST_3 => '₽₽₽',
        self::SHOP_MIDDLE_COST_4 => '₽₽₽₽',
        self::SHOP_MIDDLE_COST_5 => '₽₽₽₽₽',
    ];

    const SCENARIO_STEP1 = 'step1';
    const SCENARIO_STEP2 = 'step2';
    const SCENARIO_STEP3 = 'step3';
    const SCENARIO_STEP4 = 'step4';
    const SCENARIO_DEFAULT = 'delete';
    const SCENARIO_RATING = 'rating';

    /**
     * @var UploadedFile[]
     */
    public $uploadedShopPhoto;


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
            [['shopActive', 'creatorId', 'shopTypeId', 'shopAddressId', 'shopStatusId', 'shopRating'],
                'integer'],
            [['shopShortName', 'shopTypeId'], 'required'],
            [['shopMiddleCost'], 'string'],
            [['shopShortName'], 'string', 'max' => 75],
            [['shopFullName', 'shopPhone', 'shopWeb', 'shopCostMin', 'shopCostMax', 'shopWorkTime', 'shopAgregator', 'shopShortDescription',
                'shopLinkPdf'], 'string', 'max' => 255],
            [['shopFullDescription'], 'string', 'max' => 1500],
            [['shopAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => ShopAddress::className(), 'targetAttribute' => ['shopAddressId' => 'id']],
            [['shopStatusId'], 'exist', 'skipOnError' => true, 'targetClass' => ShopStatus::className(), 'targetAttribute' => ['shopStatusId' => 'id']],
            [['shopTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => ShopType::className(), 'targetAttribute' => ['shopTypeId' => 'id']],
            [['creatorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute'
            => ['creatorId' => 'id']],
            [['uploadedShopPhoto'], 'file', 'extensions' => 'jpeg, jpg, png', 'maxFiles' => 10]
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

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['*'],
            self::SCENARIO_STEP1 => ['creatorId', 'shopTypeId', 'shopShortName', 'shopShortDescription', 'shopFullDescription'],
            self::SCENARIO_STEP2 => ['uploadedShopPhoto'],
            self::SCENARIO_STEP3 => ['shopAddressId', 'shopPhone', 'shopWeb', 'shopWorkTime'],
            self::SCENARIO_STEP4 => ['shopCostMin', 'shopCostMax', 'shopMiddleCost', 'shopLinkPdf'],
            self::SCENARIO_RATING => ['shopRating'],
        ];
    }

    public function uploadShopPhoto()
    {
        if ($this->validate()) {
            foreach ($this->uploadedShopPhoto as $file) {
                $fileName = 'img/shopPhoto/' . $file->baseName . '.' . $file->extension;
                $file->saveAs($fileName);
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
}
