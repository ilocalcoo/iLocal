<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eventPhoto".
 *
 * @property int $id
 * @property string $eventPhoto
 * @property int $eventId
 *
 * @property Event $event
 */
class EventPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eventPhoto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eventPhoto', 'eventId'], 'required'],
            [['eventId'], 'integer'],
            [['eventPhoto'], 'string', 'max' => 255],
            [['eventId'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['eventId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eventPhoto' => 'Event Photo',
            'eventId' => 'Event ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'eventId']);
    }
}
