<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopPhoto".
 *
 * @property int $id
 * @property string $shopPhoto1
 * @property string $shopPhoto2
 * @property string $shopPhoto3
 * @property string $shopPhoto4
 * @property string $shopPhoto5
 * @property string $shopPhoto6
 * @property string $shopPhoto7
 * @property string $shopPhoto8
 * @property string $shopPhoto9
 * @property string $shopPhoto10
 *
 * @property Shop[] $shops
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
            [['shopPhoto1', 'shopPhoto2', 'shopPhoto3', 'shopPhoto4', 'shopPhoto5', 'shopPhoto6', 'shopPhoto7', 'shopPhoto8', 'shopPhoto9', 'shopPhoto10'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shopPhoto1' => 'Shop Photo1',
            'shopPhoto2' => 'Shop Photo2',
            'shopPhoto3' => 'Shop Photo3',
            'shopPhoto4' => 'Shop Photo4',
            'shopPhoto5' => 'Shop Photo5',
            'shopPhoto6' => 'Shop Photo6',
            'shopPhoto7' => 'Shop Photo7',
            'shopPhoto8' => 'Shop Photo8',
            'shopPhoto9' => 'Shop Photo9',
            'shopPhoto10' => 'Shop Photo10',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShops()
    {
        return $this->hasMany(Shop::className(), ['shopPhotoId' => 'id']);
    }
}
