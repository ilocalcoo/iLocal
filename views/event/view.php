<?php

use app\models\UserEvent;
use kartik\daterange\DateRangePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->registerCssFile('/css/event/view.css');
$this->registerCssFile('/css/event.css',['depends' => '\app\assets\AppAsset']);

$eventPhoto = $model->getEventPhotos()->asArray()->one()["eventPhoto"];
$shopAddress = \app\models\ShopAddress::findOne($model->eventOwner["shopAddressId"]);
$shopPhoto = \app\models\ShopPhoto::find()->where(['=', 'shopId', $model->eventOwner["shopId"]])->asArray()->one();

//\yii\web\YiiAsset::register($this);
?>
<div class="event-view" id="event-view-content">
    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col-md-2 col-12 mx-auto text-center">
                <a class="shop_img" href="<?= 'shops/' . $model->eventOwner["shopId"] ?>" data-pjax="0">
                    <img src="/img/shopPhoto/<?= $shopPhoto["shopPhoto"] ?>" alt="">
                </a>
            </div>
            <div class="col-md-10 col-12 mx-auto text-md-left text-center">
                <h5 class="card-title"><?= $model->eventOwner["shopShortName"] ?></h5>
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
        <div class="row">
            <div class="col-md-4 col-12">
                <img class="w-100" src="/img/eventPhoto/<?= $eventPhoto ?>" alt="">
            </div>
            <div class="col-md-8 col-12">
                <h1 class="event-view-title"><?= $model->title ?></h1>

                <div class="event-view-full-desc"><?= $model->fullDesc ?></div>

                <div class="event-view-date-wrap">
                    <div>
                        <img src="/img/user/Favor_rounded.svg" alt="">
                    </div>
                    <div><?= $model->begin ?> - <?= $model->end ?></div>
                </div>
            </div>
        </div>
    </div>

    

</div>
