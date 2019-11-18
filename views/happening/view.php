<?php

use app\models\Shop;
use app\models\ShopAddress;
use app\models\ThumbGenerator;
use app\models\UserHappening;
use yii\bootstrap4\Modal;
use yii\widgets\Pjax;

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
                        <?php if ($shop) { ?>
                        <div class="org-name">Организатор: <?= $shop['shopFullName'] ?? $shop['shopShortName'] ?></div>
                        <?php } ?>
                        <div class="event-date"><?php date('H:i d.m.Y', strtotime($model->begin)) ?></div>
                    </div>
                </div>
                <div class="social-icons">
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <?php
                        Modal::begin([
                            'toggleButton' => [
                                'label' => '<img src="/user/hart-like.png" alt="like">',
                                'tag' => 'a',
                                'class' => 'modal-enter',
                            ],
                        ]);
                        ?>
                        <div class="modal-enter-body">
                            <h2>ВХОД</h2>
                            <p>Войдите, чтобы добавить в избранное!</p>
                        </div>
                        <div class="enter-icons">
                            <?= yii\authclient\widgets\AuthChoice::widget([
                                'baseAuthUrl' => ['site/auth'],
                                'popupMode' => true,
                            ]) ?>
                        </div>
                        <p class="enter-policy">Продолжая, Вы соглашаетесь с нашими Условиями использования и
                            подтверждаете, что прочли
                            <a href="/policy" target="_blank">Политику конфиденциальности</a> .</p>
                        <?php Modal::end(); ?>
                    <?php } else { ?>
                        <?php Pjax::begin() ?>
                        <?php if (UserHappening::find()->where(['userId' => Yii::$app->user->id])->andWhere(['happeningId' => $model->id])->one()) {
                            $favorite = 'hart-dislike.png';
                            $id = 'del-id';
                        } else {
                            $favorite = 'hart-like.png';
                            $id = 'add-id';
                        } ?>
                        <a href="/happenings/<?= $model->id ?>?<?= $id ?>=<?= $model->id ?>" title="Добавить в избранное"
                                class="favorite">
                            <img src="/img/user/<?= $favorite ?>" alt=""></a>
                        <?php Pjax::end() ?>
                    <?php } ?>
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
                        <div class="col-8">
                            <i class="far fa-clock"></i> <?php echo date('H:i d.m.Y', strtotime($model->begin)) ?><br>
                            <?php if ($shop && $shop['shopPhone'] != '') { ?>
                                <i class="fas fa-phone"></i> <?= $shop['shopPhone'] ?>
                            <?php } ?>
                        </div>
                        <div class="col-4">
<!--                            <i class="fas fa-globe"></i><br>-->
                            <i class="fas fa-ruble-sign"></i> <?= $model->price ?? 'Free'?>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="event-view-full-desc">
                        <h2 class="event-about">О Событии</h2>
                        <p><?= $model->description ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
