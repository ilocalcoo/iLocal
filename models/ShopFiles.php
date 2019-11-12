<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shopFiles".
 *
 * @property int $id
 * @property int $shopId
 * @property string $shopFile
 *
 * @property Shop $shop
 */
class ShopFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shopFiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shopId'], 'integer'],
            [['shopFile'], 'string', 'max' => 255],
            [['shopId'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shopId' => 'shopId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shopId' => Yii::t('app', 'Shop ID'),
            'shopFile' => Yii::t('app', 'Shop File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['shopId' => 'shopId']);
    }
}
