<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "happening".
 *
 * @property int $id
 * @property int $shopId
 * @property int $creatorId
 * @property string $title
 * @property string $description
 * @property string $address
 * @property double $price
 * @property string $begin
 * @property string $createdOn
 * @property string $updatedOn
 *
 * @property Shop $shop
 * @property User $creator
 */
class Happening extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'happening';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shopId', 'creatorId', 'title', 'address'], 'required'],
            [['shopId', 'creatorId'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['begin', 'createdOn', 'updatedOn'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['address'], 'string', 'max' => 256],
            [['shopId'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shopId' => 'shopId']],
            [['creatorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creatorId' => 'id']],
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
            'creatorId' => Yii::t('app', 'Creator ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'address' => Yii::t('app', 'Address'),
            'price' => Yii::t('app', 'Price'),
            'begin' => Yii::t('app', 'Begin'),
            'createdOn' => Yii::t('app', 'Created On'),
            'updatedOn' => Yii::t('app', 'Updated On'),
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
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creatorId']);
    }
}
