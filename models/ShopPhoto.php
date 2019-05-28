<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopPhoto".
 *
 * @property int $id
 * @property int $shopId
 * @property string $shopPhoto
 *
 * @property Shop $shop
 */
class ShopPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shopPhoto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shopPhoto'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shopId' => 'Shop ID',
            'shopPhoto' => 'Shop Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shopId']);
    }
}
