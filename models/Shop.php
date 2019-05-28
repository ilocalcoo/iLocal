<?php

namespace app\models;

use Yii;
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
 * @property int $shopCostMin
 * @property int $shopCostMax
 * @property string $shopMiddleCost
 * @property string $shopWorkTime
 * @property string $shopAgregator
 * @property string $shopShortDescription
 * @property string $shopFullDescription
 * @property int $shopRating
 * @property int $shopStatusId
 *
 * @property Shopaddress $shopAddress
 * @property Shopstatus $shopStatus
 * @property Shoptype $shopType
 * @property ShopPhoto $shopPhotos
 */
class Shop extends \yii\db\ActiveRecord
{

    const RELATION_SHOP_ADDRESS = 'shopAddress';
    const RELATION_SHOP_TYPE = 'shopType';
    const RELATION_SHOP_PHOTOS = 'shopPhotos';

    const SHOP_ACTIVE_TRUE = 1;
    const SHOP_ACTIVE_FALSE = 0;

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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shopActive', 'creatorId', 'shopTypeId', 'shopAddressId', 'shopCostMin', 'shopCostMax', 'shopStatusId', 'shopRating'],
                'integer'],
            [['creatorId', 'shopShortName', 'shopTypeId', 'shopAddressId', 'shopStatusId'], 'required'],
            [['shopMiddleCost', 'shopWorkTime', 'shopShortDescription', 'shopFullDescription'], 'string'],
            [['shopShortName', 'shopPhone'], 'string', 'max' => 255],
            [['shopFullName', 'shopWeb', 'shopAgregator'], 'string', 'max' => 255],
            [['shopAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => Shopaddress::className(), 'targetAttribute' => ['shopAddressId' => 'id']],
            [['shopStatusId'], 'exist', 'skipOnError' => true, 'targetClass' => Shopstatus::className(), 'targetAttribute' => ['shopStatusId' => 'id']],
            [['shopTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => Shoptype::className(), 'targetAttribute' => ['shopTypeId' => 'id']],
            [['creatorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute'
            => ['creatorId' => 'id']],
            [['uploadedShopPhoto'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10]
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
            'shopShortName' => 'Shop Short Name',
            'shopFullName' => 'Shop Full Name',
            'shopTypeId' => 'Shop Type ID',
            'shopPhone' => 'Shop Phone',
            'shopWeb' => 'Shop Web',
            'shopAddressId' => 'Shop Address ID',
            'shopCostMin' => 'Shop Cost Min',
            'shopCostMax' => 'Shop Cost Max',
            'shopMiddleCost' => 'Shop Middle Cost',
            'shopWorkTime' => 'Shop Work Time',
            'shopAgregator' => 'Shop Agregator',
            'shopShortDescription' => 'Shop Short Description',
            'shopFullDescription' => 'Shop Full Description',
            'shopRating' => 'Shop Rating',
            'shopStatusId' => 'Shop Status ID',
        ];
    }

    public function uploadShopPhoto()
    {
        if ($this->validate()) {
            foreach ($this->uploadedShopPhoto as $file) {
                $file->saveAs('img/shopPhoto/' . $file->baseName . '.' . $file->extension);
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
     * @return \yii\db\ActiveQuery
     */
    public function getShopAddress()
    {
        return $this->hasOne(Shopaddress::className(), ['id' => 'shopAddressId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopStatus()
    {
        return $this->hasOne(Shopstatus::className(), ['id' => 'shopStatusId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopType()
    {
        return $this->hasOne(Shoptype::className(), ['id' => 'shopTypeId']);
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
    public function getShopPhotos()
    {
        return $this->hasOne(ShopPhoto::className(), ['shopId' => 'shopId']);
    }
}
