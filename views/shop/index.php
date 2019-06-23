<?php

use app\assets\ShopAsset;
use kartik\rating\StarRating;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $shops app\models\Shop[] */
/* @var $pages \yii\data\Pagination */
/* @var $shopType \app\models\ShopType */

ShopAsset::register($this);
$type = 'Все места';
if (array_key_exists('shopTypeId', Yii::$app->request->queryParams)) {
    $type = \app\models\ShopType::TYPES_LABELS[Yii::$app->request->queryParams['shopTypeId']];
}
$this->title = $type . ' рядом с вами';
?>
<div class="shop-index">

    <h1 class="main-shops-title"><?= Html::encode($this->title) ?></h1>
    <div class="under_title">
        <span>Вы смотрите места которые находятся рядом с вами в разделе "<?= $type ?>"</span>
    </div>
    <?php Pjax::begin(); ?>
    <?php
    foreach ($shops as $shop) { ?>
        <div class="content">
            <a class="shop_img" href="<?= 'shops/' . $shop->shopId ?>" data-pjax="0">
                <img src="/img/shopPhoto/<?php
                $shopPhoto = $shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                if (is_null($shopPhoto)) {
                    $shopPhoto = '/img/nophoto.jpg';
                }
                echo $shopPhoto ?>" alt="<?= $shop->shopShortName ?>" data-pjax="0">
            </a>
            <div class="right">
                <div class="name_and_rating">
                    <a class="shop_name" href="<?= 'shops/' . $shop->shopId ?>" data-pjax="0"
                       tabindex="1"><?= $shop->shopShortName ?></a>
                    <?php echo StarRating::widget([
                        'name' => 'shop_rating',
                        'value' => $shop->shopRating,
                        'language' => 'ru',
                        'pluginOptions' => [
                            'size' => 'md',
                            'stars' => 5,
                            'min' => 0,
                            'max' => 5,
                            'step' => 1,
                            'showClear' => false,
                            'showCaption' => false,
                            'theme' => 'krajee-svg',
                            'filledStar' => '<span class="krajee-icon krajee-icon-star"></span>',
                            'emptyStar' => '<span class="krajee-icon krajee-icon-star"></span>'
                        ],
                    ]); ?>
                </div>
                <div class="shop_address"><?php
                    $address = 'г. ' . $shop->shopAddress->city . ', ул. ' .
                        $shop->shopAddress->street . ', д. ' .
                        $shop->shopAddress->houseNumber;
                    // TODO доделать отображение корпусов и строений
                    echo $address; ?></div>
                <div class="shop_address-line"></div>
                <div class="text_and_like">
                    <span><?= $shop->shopShortDescription ?></span>
                    <div class="like">
                        <?php if (Yii::$app->user->isGuest) { ?>
                            <?php
                            Modal::begin([
                                'header' => false,
                                'toggleButton' => [
                                    'label' => '<img src="/img/user/Favor_rounded.svg" alt="">',
                                    'tag' => 'a',
                                    'class' => 'modal-enter',
                                ],
                            ]);
                            ?>
                            <div class="modal-enter-body">
                                <h2>ВХОД</h2>
                                <p>Войдите, чтобы добавить в избранное:</p>
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
                            <?php \yii\widgets\Pjax::begin() ?>
                            <?php if (\app\models\UserShop::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['shop_id' => $shop->shopId])->one()) {
                                $favorite = 'favorite_border_24px_rounded.svg';
                                $shopId = 'del-shop-id';
                            } else {
                                $favorite = 'Favor_rounded.svg';
                                $shopId = 'add-shop-id';
                            } ?>
                            <a href="/shops?<?= $shopId ?>=<?= $shop['shopId'] ?>" title="Добавить в избранное"
                               class="favorite">
                                <img src="/img/user/<?= $favorite ?>" alt=""></a>
                            <?php \yii\widgets\Pjax::end() ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="work_time_and_category">
						<span class="work_time"><?php if ($shop->shopWorkTime) {

                                echo 'Время работы: ' . $shop->shopWorkTime;
                            } ?></span>
                    <span class="category"><?php $category = \app\models\ShopType::TYPES_LABELS[$shop->shopTypeId];
                        echo 'Раздел - ' . $category; ?></span>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php Pjax::end(); ?>
    <div class="pagination">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'nextPageLabel' => '>',
            'prevPageLabel' => '<',
        ]); ?>
    </div>

    <div class="shop-banner">
        <div class="banner-left">
            <h1>Владелец бизнеса?</h1>
            <div> Разместите Ваше место на платформе и станьте ближе к тысячам людей, которые живут и работают в
                радиусе пешей доступности.
                <div class="banner-text"><span>Бесплатный</span> пробный период на размещение акций.</div>
            </div>
            <a href="/user/business">Попробовать</a>
        </div>
        <div class="banner-right">
            <img src="/img/shop/banner-img.png" alt="" tabindex="1">
        </div>
    </div>

</div>
