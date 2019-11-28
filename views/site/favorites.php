<?php

/* @var $this yii\web\View */

use app\models\UserShop;
use app\models\UserEvent;
use yii\helpers\Html;

$this->registerJsFile('/js/eventsView.js', ['depends' => 'app\assets\AppAsset']);
$this->registerCssFile('/css/user/favorites.css');
$this->registerCssFile('/css/event/view.css');
$this->registerCssFile('/css/event.css');
/* @var $userShops app\models\Shop */
/* @var $userEvents app\models\Event */
/* @var $shop app\models\Shop */
/* @var $event app\models\Event */

$this->title = 'Избранное';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="site-favorites">-->
<h1><?= Html::encode($this->title) ?></h1>

<h1 class="business-header">Ваши места</h1>

<div class="flex-wrap">

    <?php foreach ($userShops as $shop) { ?>
        <div class="main-block-wrap">
            <img src="/img/shopPhoto/<?php if (!isset($shop['shopPhotos'][0]['shopPhoto'])) {
                echo 'nophoto.jpg';
            } else {
                echo $shop['shopPhotos'][0]['shopPhoto'];
            } ?>" class="photo" alt="">
            <div class="photo-wrap">
                <a href="/shops/<?= $shop['shopId'] ?>" class="title"><?= $shop['shopShortName'] ?></a>
            </div>
            <div class="info-block-wrap">
                <p><?= mb_substr($shop['shopShortDescription'], 0, 70) ?>
                    <a href="/shops/<?= $shop['shopId'] ?>">Подробнее...</a></p>
            </div>

            <?php \yii\widgets\Pjax::begin(['id' => 'shop-list', 'timeout' => false, 'enablePushState' => false]) ?>
            <?php if (UserShop::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['shop_id' => $shop->shopId])->one()) {
                $favorite = 'favorite_border_24px_rounded.svg';
                $shopId = 'del-shop-id';
            } else {
                $favorite = 'Favor_rounded.svg';
                $shopId = 'add-shop-id';
            } ?>
            <a href="/site/favorites?<?= $shopId ?>=<?= $shop['shopId'] ?>" data-id="<?= $shop['shopId'] ?>" data-item="shop" title="Удалить из избранного"
               class="favorite">
                <img src="/img/user/<?= $favorite ?>" alt=""></a>
            <?php \yii\widgets\Pjax::end() ?>

            <span class="favorite-shop-type">Раздел - <a
                        href="/shops?shopTypeId=<?= $shop['shopTypeId'] ?>"><?= $shop->shopType->type ?></a></span>
        </div>
    <?php } ?>

</div>

<div class="business-line"></div>

<h1 class="business-header">Ваши акции</h1>

<div class="flex-wrap">
    <div class="container">
        <?php \yii\widgets\Pjax::begin() ?>
        <div class="row">

            <?php foreach ($userEvents as $event) { ?>
                <div class="col-md-4 col-12">
                    <div class="content card p-3">
                        <div class="row align-items-center h-100">
                            <div class="col-12">
                                <a class="shop-link" href="<?= 'shops/' . $event->shop->shopId ?>" data-pjax="0">
                                    <h5 class="card-title">
                                        <img class="shop_img" src="/img/shopPhoto/<?php
                                        $shopPhoto = $event->shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                                        if (is_null($shopPhoto)) {
                                            $shopPhoto = '/img/nophoto.jpg';
                                        }
                                        echo $shopPhoto ?>"
                                                alt="<?= $event->shop->shopShortName ?>"
                                        />
                                        <?= $event->shop->shopShortName ?>
                                    </h5>
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="/events/<?= $event->id ?>">
                                    <a href="/events/<?= $event->id ?>">
                                        <div class="slide-img">
                                            <img src="<?= '/img/eventPhoto/'.$event->getEventPhotos()->asArray()->one()['eventPhoto'] ?>" alt="<?= $event->title ?>">
                                            <div class="overlay">
                                                <div class="overlay-link"><?= $event->title ?></div>
                                            </div>
                                            <span class="badge badge-coral">-15%</span>
                                        </div>
                                    </a>
                                    <div class="slide-text"><?= mb_substr($event->shortDesc,0,70).'...' ?></div>
                                </a>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="like">


                                            <?php if (\app\models\UserEvent::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['event_id' => $event->id])->one()) {
                                                $favorite = 'favorite_border_24px_rounded.svg';
                                                $shopId = 'add-event-id';
                                            } else {
                                                $favorite = 'Favor_rounded.svg';
                                                $shopId = 'add-event-id';
                                            } ?>
                                            <a href="/site/favorites?<?= $shopId ?>=<?= $event->id ?>" title="Удалить из избранного"
                                                    class="favorite">
                                                <img src="/img/user/<?= $favorite ?>" alt=""></a>


                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="text-right event-date">
                                            <?= $event->begin .' - '. $event->end ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php \yii\widgets\Pjax::end() ?>
    </div>

    <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content event-view-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

</div>

