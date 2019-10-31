<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "happeningType".
 *
 * @property int $id
 * @property string $type
 * @property string $name
 *
 * @property Happening[] $happenings
 */
class HappeningType extends \yii\db\ActiveRecord
{
    /* константы заменены на getNames.
     * оставлены для обратной совместимости ---> */
    const TYPE_FOOD = 1;
    const TYPE_CHILD = 2;
    const TYPE_SPORT = 3;
    const TYPE_BEAUTY = 4;
    const TYPE_BUY = 5;
    const TYPES = [self::TYPE_FOOD, self::TYPE_CHILD, self::TYPE_SPORT, self::TYPE_BEAUTY, self::TYPE_BUY];
    const TYPES_LABELS = [
        self::TYPE_FOOD =>'Еда',
        self::TYPE_CHILD =>'Дети',
        self::TYPE_SPORT => 'Спорт',
        self::TYPE_BEAUTY => 'Красота',
        self::TYPE_BUY => 'Покупки',
    ];
    /* ---> для обратной совместимости*/

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'happeningType';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHappenings()
    {
        return $this->hasMany(Happening::className(), ['happeningTypeId' => 'id']);
    }

    public static function getNames() {
        $result = [];
        foreach (self::find()->all() as $value) {
            $result[$value->id] = $value->name;
        }

        return $result;
    }
}
