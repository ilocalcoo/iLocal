<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int $active
 * @property int $creatorId
 * @property int $isEventTop
 * @property int $eventOwnerId
 * @property int $eventTypeId
 * @property string $title
 * @property string $shortDesc
 * @property string $fullDesc
 * @property string $begin
 * @property string $end
 *
 * @property EventPhoto[] $eventPhotos
 * @property EventType $eventType
 * @property Shop $eventOwner
 * @property UserEvent[] $userEvents
 * @property User[] $usersFavorites
 */
class Event extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1';
    const STATUS_DISABLE = '0';
    const MARK_AS_TOP = '1';
    const MARK_AS_NOT_TOP = '0';

    const MAX_SHOW_EVENTS = 3;

    const RELATION_EVENT_SHOP = 'eventOwner';
    const RELATION_EVENT_TYPE = 'eventType';
    const RELATION_EVENT_PHOTOS = 'eventPhotos';

    const SCENARIO_DEFAULT = 'delete';
    const SCENARIO_STEP1 = 'step1';
    const SCENARIO_STEP2 = 'step2';
    const SCENARIO_STEP3 = 'step3';

    /**
     * @var UploadedFile[]
     */
    public $uploadedEventPhoto;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'creatorId',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'isEventTop', 'eventOwnerId', 'eventTypeId'], 'integer'],
            [['eventOwnerId', 'eventTypeId'], 'required'],
            [['fullDesc'], 'string'],
            [['title', 'shortDesc', 'begin', 'end'], 'string', 'max' => 255],
            [['eventTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => EventType::className(), 'targetAttribute' => ['eventTypeId' => 'id']],
            [['eventOwnerId'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute'
            => ['eventOwnerId' => 'shopId']],
            [['uploadedEventPhoto'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 3],
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
            'eventOwnerId' => 'Владелец акции',
            'eventTypeId' => 'Категория акции',
            'title' => 'Название акции',
            'shortDesc' => 'Краткое описание акции',
            'fullDesc' => 'Полное описание акции',
            'begin' => 'Начало акции',
            'end' => 'Окончание акции',
        ];
    }

    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'eventPhotos'
        ]);
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['*'],
            self::SCENARIO_STEP1 => ['eventOwnerId', 'eventTypeId'],
            self::SCENARIO_STEP2 => ['title', 'shortDesc', 'fullDesc', 'begin', 'end'],
            self::SCENARIO_STEP3 => ['uploadedEventPhoto'],
        ];
    }

    public function uploadEventPhoto()
    {
        if ($this->validate()) {
            foreach ($this->uploadedEventPhoto as $file) {
                $file->saveAs('img/eventPhoto/' . $file->baseName . '.' . $file->extension);
                $model = new EventPhoto();
                $model->eventPhoto = $file->baseName . '.' . $file->extension;
                $model->eventId = $this->id;
                $model->save();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventPhotos()
    {
        return $this->hasMany(EventPhoto::className(), ['eventId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopEventPhotos()
    {
        return $this->hasMany(EventPhoto::className(), ['eventId' => 'id'])->limit(Event::MAX_SHOW_EVENTS);
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
     * @return \yii\db\ActiveQuery
     */
    public function getUserEvents()
    {
        return $this->hasMany(UserEvent::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFavorites()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_event', ['event_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EventQuery(get_called_class());
    }

    public function getShop() {
        return $this->hasOne(Shop::class, ['shopId' => 'eventOwnerId']);
    }
}
