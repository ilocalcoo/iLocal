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
