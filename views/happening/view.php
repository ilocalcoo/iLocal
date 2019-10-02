<?php

use app\models\Shop;
use app\models\ShopAddress;
use app\models\ThumbGenerator;
use app\models\UserEvent;
use kartik\daterange\DateRangePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Happening */
/**
 * @var $shop Shop
 */

$this->registerCssFile('/css/happening/view.css');

$happeningPhoto = $model->getHappeningPhotos()->asArray()->one();
$shop = Shop::find()->where(['=', 'shopId', $model->shopId])->asArray()->one();
$shopAddress = ShopAddress::find()->where(['=', 'id', $shop['shopAddressId']])->asArray()->one();
//\yii\web\YiiAsset::register($this);
$this->title = 'События / '.$model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container happening-index">

    <div class="row">
        <div class="event-item col-md-6 col-12">
            <div class="slide-img">
                <img class="event-view-img" src="<?= '/img/happeningPhoto/'.$model->id.'/'.ThumbGenerator::getSizeDir('medium').'/'.($happeningPhoto['happeningPhoto'] ?? 'f') ?>" alt="<?= $model->title ?>">
                <div class="overlay">
                    <div class="overlay-link event-link">
                        <div class="event-title"><?= $model->title ?></div>
                        <div class="org-name">Организатор: <?= $shop['shopFullName'] ?? $shop['shopShortName'] ?></div>
                        <div class="event-date"><?php date('H:i d.m.Y', strtotime($model->begin)) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12 event-info">
            <div class="row">
                <div class="col-12">
                    <h1 class="event-view-title"><?= $model->title ?></h1>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <i class="fas fa-map-marker-alt"></i> <?php
                             if (!$shop) {
                                 echo $model->address;
                             } else {
                                 echo $shopAddress['city'] . ', ' . $shopAddress['street'] . ', ' . $shopAddress['houseNumber'];
                             }

                             ?><br>
                        </div>
                        <div class="col-6">
                            <i class="far fa-clock"></i> <?php echo date('H:i d.m.Y', strtotime($model->begin)) ?><br>
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="col-6">
<!--                            <i class="fas fa-globe"></i><br>-->
                            <i class="fas fa-ruble-sign"></i> <?= $model->price ?? 'Free'?>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="event-view-full-desc">
                        <h2 class="event-about">О Событии</h2>
                        <?= $model->description ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
