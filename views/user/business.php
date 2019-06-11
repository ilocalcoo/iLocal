<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->registerCssFile('/css/user/business.css');
/* @var $userShops app\models\Shop */
/* @var $userEvents app\models\Event */
?>

<h1 class="business-header">Ваши места</h1>

<div class="flex-wrap">

    <?php foreach ($userShops as $shop) { ?>
        <div class="main-block-wrap">
            <img src="/img/shopPhoto/<?php if (!isset($shop['shopPhotos'][0]['shopPhoto'])) {
                echo 'no-photo.png';
            } else {
                echo $shop['shopPhotos'][0]['shopPhoto'];
            } ?>" class="photo" alt="">
            <div class="info-block-wrap">
                <a href="/shops/<?= $shop['shopId'] ?>" class="title"><?= $shop['shopShortName'] ?></a>
                <a href="/shop/create?id=<?= $shop['shopId'] ?>" title="Редактировать" aria-label="Редактировать"
                   class="update"><img src="/img/user/contract-btn.svg" alt=""></a>
                <?= Html::a(Html::img('/img/user/delete-btn.svg'), ['/shops/' . $shop['shopId'] . '/delete'], [
                    'title' => 'Удалить',
                    'aria-label' => 'Удалить',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить место?',
                        'method' => 'post'
                    ],
                ]) ?>
            </div>
        </div>
    <?php } ?>

    <div class="main-block-wrap">
        <img src="/img/user/no-photo.png" class="photo" alt="">
        <img src="/img/user/photo_icon_ellipse.png" class="icon-ellipse" alt="">
        <div class="info-block-wrap">
            <a href="/shop/create" class="title">Добавить место</a>
        </div>
    </div>

</div>

<div class="business-line"></div>

<h1 class="business-header">Ваши акции</h1>

<div class="flex-wrap">

    <?php foreach ($userEvents as $event) { ?>
        <div class="main-block-wrap">
            <img src="/img/eventPhoto/<?php if (!isset($event['eventPhotos'][0]['eventPhoto'])) {
                echo 'no-photo.png';
            } else {
                echo $event['eventPhotos'][0]['eventPhoto'];
            } ?>" class="photo" alt="">
            <div class="info-block-wrap">
                <a href="/events/<?= $event['id'] ?>" class="title"><?= $event['title'] ?></a>
                <a href="/event/create?id=<?= $event['id'] ?>" title="Редактировать" aria-label="Редактировать"
                   class="update"><img src="/img/user/contract-btn.svg" alt=""></a>
                <?= Html::a(Html::img('/img/user/delete-btn.svg'), ['/events/' . $event['id'] . '/delete'], [
                    'title' => 'Удалить',
                    'aria-label' => 'Удалить',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить акцию?',
                        'method' => 'post'
                    ],
                ]) ?>
            </div>
        </div>
    <?php } ?>

    <div class="main-block-wrap">
        <img src="/img/user/no-photo.png" class="photo" alt="">
        <img src="/img/user/photo_icon_ellipse.png" class="icon-ellipse" alt="">
        <div class="info-block-wrap">
            <a href="/event/create" class="title <?php if (!$userShops) { ?>disabled<?php } ?>">Добавить акцию</a>
        </div>
    </div>
</div>





