<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eventPhoto".
 *
 * @property int $id
 * @property string $photo1
 * @property string $photo2
 * @property string $photo3
 *
 * @property Event[] $events
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
            [['photo1', 'photo2', 'photo3'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo1' => 'Photo1',
            'photo2' => 'Photo2',
            'photo3' => 'Photo3',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['eventPhotoId' => 'id']);
    }
}
