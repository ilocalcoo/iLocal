<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "happening".
 *
 * @property int $id
 * @property int $shopId
 * @property int $creatorId
 * @property string $title
 * @property string $description
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $price
 * @property string $begin
 * @property string $createdOn
 * @property string $updatedOn
 *
 * @property Shop $shop
 * @property User $creator
 *
 * @property HappeningPhoto[] $happeningPhotos
 * @property happeningType $happeningType
 * @property UserHappening[] $userHappenings
 */
class Happening extends ActiveRecord
{
    const STATUS_ACTIVE = '1';
    const STATUS_DISABLE = '0';
    const MARK_AS_TOP = '1';
    const MARK_AS_NOT_TOP = '0';

    const MAX_SHOW_EVENTS = 3;

    const RELATION_HAPPENING_SHOP = 'shopId';
    const RELATION_HAPPENING_TYPE = 'happeningType';
    const RELATION_HAPPENING_PHOTOS = 'happeningPhotos';

//    const SCENARIO_DEFAULT = 'delete';
//    const SCENARIO_STEP1 = 'step1';
//    const SCENARIO_STEP2 = 'step2';
//    const SCENARIO_STEP3 = 'step3';

    /**
     * @var UploadedFile[]
     */
    public $uploadedHappeningPhoto;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'happening';
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
            [['creatorId','happeningTypeId'], 'required'],
            [['shopId', 'creatorId'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['begin', 'end', 'createdOn', 'updatedOn'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['address'], 'string', 'max' => 256],
//            [['shopId'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shopId' => 'shopId']],
            [['creatorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creatorId' => 'id']],
            [['uploadedHappeningPhoto'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
//            'shopId' => Yii::t('app', 'Shop ID'),
//            'creatorId' => Yii::t('app', 'Creator ID'),
//            'title' => Yii::t('app', 'Title'),
//            'description' => Yii::t('app', 'Description'),
//            'address' => Yii::t('app', 'Address'),
//            'price' => Yii::t('app', 'Price'),
//            'begin' => Yii::t('app', 'Begin'),
//            'createdOn' => Yii::t('app', 'Created On'),
//            'updatedOn' => Yii::t('app', 'Updated On'),
            'id' => 'ID',
            'shopId' => 'Магазин',
            'creatorId' => 'Владелец',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'address' => 'Адрес',
            'price' => 'Цена',
            'begin' => 'Дата и время начала',
            'end' => 'Дата и время окончания',
            'createdOn' => 'Создано',
            'updatedOn' => 'Обновлено',
        ];
    }

    /**
     * @return array|false
     */
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'happeningPhotos'
        ]);
    }

    /**
     * @return array
     */
//    public function scenarios()
//    {
//        return [
//            self::SCENARIO_DEFAULT => ['*'],
//            self::SCENARIO_STEP1 => ['shopId', 'happeningTypeId'],
//            self::SCENARIO_STEP2 => ['title', 'description', 'begin'],
//            self::SCENARIO_STEP3 => ['uploadedHappeningPhoto'],
//        ];
//    }

    /**
     * @return bool
     */
    public function uploadHappeningPhoto()
    {
        if ($this->validate()) {
            $baseDir = 'img/happeningPhoto/';
            foreach ($this->uploadedHappeningPhoto as $file) {
                if (!is_dir($baseDir)) {
                    mkdir($baseDir, 0755, true);
                }
                $fileName = $baseDir . $file->baseName . '.' . $file->extension;
                $file->saveAs($fileName);
                ThumbGenerator::generate($fileName, $this->id);
                $model = new HappeningPhoto();
                $model->happeningPhoto = $file->baseName . '.' . $file->extension;
                $model->happeningId = $this->id;
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
    public function getHappeningPhotos()
    {
        return $this->hasMany(HappeningPhoto::className(), ['happeningId' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHappeningType()
    {
        return $this->hasOne(HappeningType::className(), ['id' => 'happeningTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHappeningOwner()
    {
        return $this->hasOne(Shop::className(), ['shopId' => 'shopId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHappenings()
    {
        return $this->hasMany(UserHappening::className(), ['happeningId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFavorites()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('userHappening', ['happeningId' => 'id']);
    }
}
