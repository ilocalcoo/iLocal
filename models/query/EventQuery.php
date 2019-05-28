<?php

namespace app\models\query;
use app\models\Event;

/**
 * This is the ActiveQuery class for [[\app\models\Event]].
 *
 * @see \app\models\Event
 */
class EventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/


    public function byTop()
    {
        return $this->andWhere('isEventTop = '.Event::MARK_AS_TOP);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Event[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Event|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
