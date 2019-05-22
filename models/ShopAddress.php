<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopaddress".
 *
 * @property int $id
 * @property string $city
 * @property string $street
 * @property string $houseNumber
 * @property int $housing
 * @property int $building
 * @property double $latitude
 * @property double $longitude
 *
 * @property Shop[] $shops
 */
class ShopAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shopaddress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'street', 'houseNumber'], 'required'],
            [['housing', 'building'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['city', 'street', 'houseNumber'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'street' => 'Street',
            'houseNumber' => 'House Number',
            'housing' => 'Housing',
            'building' => 'Building',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShops()
    {
        return $this->hasMany(Shop::className(), ['shopAddressId' => 'id']);
    }
}
