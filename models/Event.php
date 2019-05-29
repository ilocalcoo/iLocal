<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int $active
 * @property int $isEventTop
 * @property int $eventOwnerId
 * @property int $eventTypeId
 * @property string $title
 * @property int $eventPhotoId
 * @property string $shortDesc
 * @property string $fullDesc
 * @property string $begin
 * @property string $end
 *
 * @property EventPhoto $eventPhoto
 * @property EventType $eventType
 * @property Shop $eventOwner
 */
class Event extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1';
    const STATUS_DISABLE = '0';
    const MARK_AS_TOP = '1';
    const MARK_AS_NOT_TOP = '0';

    const MAX_SHOW_EVENTS = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'eventOwnerId', 'eventTypeId', 'eventPhotoId'], 'integer'],
            [['eventOwnerId', 'eventTypeId', 'title', 'shortDesc', 'fullDesc', 'begin', 'end'], 'required'],
            [['fullDesc'], 'string'],
            [['begin', 'end'], 'safe'],
            [['title', 'shortDesc'], 'string', 'max' => 255],
            [['eventPhotoId'], 'exist', 'skipOnError' => true, 'targetClass' => EventPhoto::className(), 'targetAttribute' => ['eventPhotoId' => 'id']],
            [['eventTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => EventType::className(), 'targetAttribute' => ['eventTypeId' => 'id']],
            [['eventOwnerId'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute'
            => ['eventOwnerId' => 'shopId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Active',
            'isEventTop' => 'Show event in feed',
            'eventOwnerId' => 'Event Owner ID',
            'eventTypeId' => 'Event Type ID',
            'title' => 'Title',
            'eventPhotoId' => 'Event Photo ID',
            'shortDesc' => 'Short Desc',
            'fullDesc' => 'Full Desc',
            'begin' => 'Begin',
            'end' => 'End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventPhoto()
    {
        return $this->hasOne(EventPhoto::className(), ['id' => 'eventPhotoId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventType()
    {
        return $this->hasOne(EventType::className(), ['id' => 'eventTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventOwner()
    {
        return $this->hasOne(Shop::className(), ['shopId' => 'eventOwnerId']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EventQuery(get_called_class());
    }
}