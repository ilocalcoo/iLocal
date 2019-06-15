<?php

/* @var $this yii\web\View */

use app\models\UserShop;
use yii\helpers\Html;

$this->registerCssFile('/css/user/favorites.css');
/* @var $userShops app\models\Shop */
/* @var $userEvents app\models\Event */
/* @var $shop app\models\Shop */

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
                echo 'figma.jpg';
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

<!--            --><?php //$favorite = $shop->usersFavorites[0] ? 'favorite_border_24px_rounded.svg' : 'Favor_rounded.svg' ?>
            <?php if (UserShop::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['shop_id' => $shop->shopId])->one()) {
//            <?php if ($shop->usersFavorites[0]->id ==) {
                $favorite = 'favorite_border_24px_rounded.svg';
                $shopId = 'del-shop-id';
            } else {
                $favorite = 'Favor_rounded.svg';
                $shopId = 'add-shop-id';
            } ?>
            <a href="/site/favorites?<?= $shopId ?>=<?= $shop['shopId'] ?>" title="Добавить в избранное" class="favorite">
                <img src="/img/user/<?= $favorite ?>" alt=""></a>
            <span class="favorite-shop-type">Раздел - <a href="/shops?shopTypeId=<?= $shop['shopTypeId'] ?>"><?= $shop->shopType->type ?></a></span>
        </div>
    <?php } ?>

</div>

<div class="business-line"></div>

<h1 class="business-header">Ваши акции</h1>

<div class="flex-wrap">

    <?php foreach ($userEvents as $event) { ?>
        <div class="main-block-wrap">
            <img src="/img/eventPhoto/<?php if (!isset($event['eventPhotos'][0]['eventPhoto'])) {
                echo 'figma.jpg';
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

</div>



