<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property int $shopId
 * @property string $shopShortName
 * @property string $shopFullName
 * @property string $shopPhoto
 * @property string $shopType
 * @property string $shopPhone
 * @property string $shopWeb
 * @property string $shopAddress
 * @property int $shopCostMin
 * @property int $shopCostMax
 * @property string $shopMiddleCost
 * @property string $shopAgregator
 */
class Shop extends \yii\db\ActiveRecord
{
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
            [['shopShortName', 'shopFullName', 'shopPhoto', 'shopPhone', 'shopWeb', 'shopAddress', 'shopCostMin', 'shopCostMax', 'shopAgregator'], 'required'],
            [['shopType', 'shopMiddleCost'], 'string'],
            [['shopCostMin', 'shopCostMax'], 'integer'],
            [['shopShortName', 'shopPhone'], 'string', 'max' => 20],
            [['shopFullName', 'shopPhoto', 'shopWeb', 'shopAddress', 'shopAgregator'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'shopId' => 'Shop ID',
            'shopShortName' => 'Shop Short Name',
            'shopFullName' => 'Shop Full Name',
            'shopPhoto' => 'Shop Photo',
            'shopType' => 'Shop Type',
            'shopPhone' => 'Shop Phone',
            'shopWeb' => 'Shop Web',
            'shopAddress' => 'Shop Address',
            'shopCostMin' => 'Shop Cost Min',
            'shopCostMax' => 'Shop Cost Max',
            'shopMiddleCost' => 'Shop Middle Cost',
            'shopAgregator' => 'Shop Agregator',
        ];
    }
}
