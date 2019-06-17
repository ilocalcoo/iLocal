<?php

use app\models\UserEvent;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->registerCssFile('/css/event/view.css');

$eventPhoto = $model->getEventPhotos()->asArray()->one()["eventPhoto"];

\yii\web\YiiAsset::register($this);
?>
<div class="event-view" id="event-view-content">

    <img class="event-view-img" src="/img/eventPhoto/<?= $eventPhoto ?>" alt="">
    
    <h1 class="event-view-title"><?= $model->title ?></h1>

    <div class="event-view-full-desc"><?= $model->fullDesc ?></div>

    <div class="event-view-date-wrap">
        <div>
            <img src="/img/user/favor_rounded.svg" alt="">
        </div>
        <div><?= $model->begin ?> - <?= $model->end ?></div>
    </div>
</div>
