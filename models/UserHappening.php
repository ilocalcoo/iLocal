<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userHappening".
 *
 * @property int $id
 * @property int $userId
 * @property int $happeningId
 * @property string $createdOn
 * @property string $updatedOn
 */
class UserHappening extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userHappening';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'happeningId'], 'required'],
            [['userId', 'happeningId'], 'integer'],
            [['createdOn', 'updatedOn'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'happeningId' => Yii::t('app', 'Happening ID'),
            'createdOn' => Yii::t('app', 'Created On'),
            'updatedOn' => Yii::t('app', 'Updated On'),
        ];
    }
}
