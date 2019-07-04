<?php

use app\models\UserEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->registerCssFile('/css/event/view.css');

$eventPhoto = $model->getEventPhotos()->asArray()->one()["eventPhoto"];
$shopAddress = \app\models\ShopAddress::findOne($model->eventOwner["shopAddressId"]);
$shopPhoto = \app\models\ShopPhoto::find()->where(['=', 'shopId', $model->eventOwner["shopId"]])->asArray()->one();

\yii\web\YiiAsset::register($this);
?>
<div class="event-view" id="event-view-content">

    <div class="modal-title event-model-title">
        <img src="/img/shopPhoto/<?= $shopPhoto["shopPhoto"] ?>" alt="">
        <div>
            <div class="event-view-shop-name"><?= $model->eventOwner["shopShortName"] ?></div>
            <div class="event-view-shop-address"><?php
                $comma = '';
                foreach (ArrayHelper::toArray($shopAddress) as $key => $item) {
                    if ($key == 'id' || $item == '') {
                        continue;
                    }
                    if ($key == 'latitude') {
                        break;
                    }
                    echo $comma . $item;
                    $comma = ', ';
                }
                ?></div>
        </div>
    </div>


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
