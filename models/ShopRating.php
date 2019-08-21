<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shoprating".
 *
 * @property int $shopId
 * @property int $userId
 * @property int $rating
 *
 * @property Shop $shop
 * @property User $user
 */
class ShopRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shopRating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shopId', 'userId'], 'required'],
            [['shopId', 'userId', 'rating'], 'integer'],
            [['shopId'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shopId' => 'shopId']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'shopId' => 'Shop ID',
            'userId' => 'User ID',
            'rating' => 'Rating',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['shopId' => 'shopId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
