<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "happeningPhoto".
 *
 * @property int $id
 * @property int $happeningId
 * @property string $happeningPhoto
 *
 * @property Happening $happening
 */
class HappeningPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'happeningPhoto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['happeningId', 'happeningPhoto'], 'required'],
            [['happeningId'], 'integer'],
            [['happeningPhoto'], 'string', 'max' => 255],
            [['happeningId'], 'exist', 'skipOnError' => true, 'targetClass' => Happening::className(), 'targetAttribute' => ['happeningId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'happeningId' => Yii::t('app', 'Happening ID'),
            'happeningPhoto' => Yii::t('app', 'Happening Photo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHappening()
    {
        return $this->hasOne(Happening::className(), ['id' => 'happeningId']);
    }
}
