<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userAddress".
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
 * @property User[] $users
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userAddress';
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
            'city' => 'Город',
            'street' => 'Улица',
            'houseNumber' => 'Номер дома',
            'housing' => 'Корпус',
            'building' => 'Строение',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['userAddressId' => 'id']);
    }
}
