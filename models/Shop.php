<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property int $shopId
 * @property int $shopActive
 * @property int $creatorId
 * @property string $shopShortName
 * @property string $shopFullName
 * @property integer $shopPhotoId
 * @property int $shopTypeId
 * @property string $shopPhone
 * @property string $shopWeb
 * @property int $shopAddressId
 * @property int $shopCostMin
 * @property int $shopCostMax
 * @property string $shopMiddleCost
 * @property string $shopWorkTime
 * @property string $shopAgregator
 * @property int $shopStatusId
 *
 * @property Shopaddress $shopAddress
 * @property Shopstatus $shopStatus
 * @property Shoptype $shopType
 */
class Shop extends \yii\db\ActiveRecord
{

    const SHOP_ACTIVE_ACTIVE = 1;
    const SHOP_ACTIVE_DISABLE = 0;

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
            [['shopActive', 'shopPhotoId', 'creatorId', 'shopTypeId', 'shopAddressId', 'shopCostMin', 'shopCostMax', 'shopStatusId'],
                'integer'],
            [['creatorId', 'shopShortName', 'shopFullName', 'shopTypeId', 'shopPhone', 'shopWeb',
                'shopAddressId', 'shopCostMin', 'shopCostMax', 'shopAgregator', 'shopStatusId'], 'required'],
            [['shopMiddleCost', 'shopWorkTime'], 'string'],
            [['shopShortName', 'shopPhone'], 'string', 'max' => 20],
            [['shopFullName', 'shopPhoto', 'shopWeb', 'shopAgregator'], 'string', 'max' => 255],
            [['shopAddressId'], 'exist', 'skipOnError' => true, 'targetClass' => Shopaddress::className(), 'targetAttribute' => ['shopAddressId' => 'id']],
            [['shopStatusId'], 'exist', 'skipOnError' => true, 'targetClass' => Shopstatus::className(), 'targetAttribute' => ['shopStatusId' => 'id']],
            [['shopTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => Shoptype::className(), 'targetAttribute' => ['shopTypeId' => 'id']],
            [['creatorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute'
            => ['creatorId' => 'id']],
            [['shopPhotoId'], 'exist', 'skipOnError' => true, 'targetClass' => ShopPhoto::className(), 'targetAttribute'
            => ['shopPhotoId' => 'id']],
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
            'shopPhotoId' => 'Shop Photo ID',
            'shopTypeId' => 'Shop Type ID',
            'shopPhone' => 'Shop Phone',
            'shopWeb' => 'Shop Web',
            'shopAddressId' => 'Shop Address ID',
            'shopCostMin' => 'Shop Cost Min',
            'shopCostMax' => 'Shop Cost Max',
            'shopMiddleCost' => 'Shop Middle Cost',
            'shopWorkTime' => 'Shop Work Time',
            'shopAgregator' => 'Shop Agregator',
            'shopStatusId' => 'Shop Status ID',
        ];
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
    public function getShopPhoto()
    {
        return $this->hasOne(ShopPhoto::className(), ['id' => 'shopPhotoId']);
    }
}
