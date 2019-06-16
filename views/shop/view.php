<?php

use app\models\Event;
use app\models\UserEvent;
use kartik\rating\StarRating;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $shopEvents app\models\Event */

$this->title = $model->shopShortName;

\yii\web\YiiAsset::register($this);
$this->registerCssFile('/css/shop/view.css');

$photos = [];
$carousel = [];
$randomPhotos = [];
foreach ($model->shopPhotos as $photo) {
    $photos[] = $photo->shopPhoto;
    $carousel[] = '<img src="/img/shopPhoto/' . $photo->shopPhoto . '"/>';
}
if (count($carousel) == 0) {
    $photos[0] = 'nophoto.jpg';
    $carousel[0] = '<img src="/img/shopPhoto/nophoto.jpg"/>';
    $photos[1] = 'nophoto.jpg';
    $carousel[1] = '<img src="/img/shopPhoto/nophoto.jpg"/>';
    $randomPhotos[0] = 0;
    $randomPhotos[1] = 1;
}
if (count($carousel) == 1) {
    $photos[1] = 'nophoto.jpg';
    $carousel[1] = '<img src="/img/shopPhoto/nophoto.jpg"/>';
    $randomPhotos[0] = 0;
    $randomPhotos[1] = 1;
} else {
    $randomPhotos = array_rand($carousel, 2);
}
//var_dump($photos, $randomPhotos, $carousel);exit;
?>
<div class="shop-view">
    <div class="shop-window-container">

        <h1><?= Html::encode($this->title) ?></h1>
        <span class="shop-type"><?= $model->shopType::TYPES_LABELS[$model->shopType->id] ?></span>
        <span class="shop-cost"><?= $model::SHOP_MIDDLE_COST_LABELS[$model->shopMiddleCost] ?></span>
        <div class="shop-contacts">
            <div class="shop-location"><img src="/img/shop/Location.svg" alt="Location">
                <?
                $comma = '';
                foreach (ArrayHelper::toArray($model->shopAddress) as $key => $item) {
                    if ($key == 'id' || $item == '') {
                        continue;
                    }
                    if ($key == 'latitude') {
                        break;
                    }
                    echo $comma . $item;
                    $comma = ', ';
                }
                ?>
            </div>
            <div class="shop-location"><img src="/img/shop/Phone.svg"
                                            alt="Phone"><?= $model->shopPhone ? $model->shopPhone : '' ?></div>
            <div class="shop-location"><img src="/img/shop/Url.svg"
                                            alt="Url"><a href="<?= $model->shopWeb ? $model->shopWeb : '' ?>"
                                                         target="_blank"><?= $model->shopWeb ? $model->shopWeb : '' ?></a>
            </div>
            <div class="shop-location"><img src="/img/shop/Time_to_go.svg" alt="Time to go">Режим работы</div>
        </div>
        <div class="shop-window-gallery">
            <div class="shop-window-carousel">
                <?= \yii\bootstrap\Carousel::widget([
                    'items' => $carousel,
                    'options' => [
//                        'class' => 'carousel slide',
//                        'data-interval' => '12000'
                    ],
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                        '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                    ]

                ]) ?>
            </div>
            <div class="shop-window-photos">
                <a href="/img/shopPhoto/<?= $photos[$randomPhotos[0]] ?>" target="_blank">
                    <div class="shop-window-photo"><?= $carousel[$randomPhotos[0]] ?></div>
                </a>
                <a href="/img/shopPhoto/<?= $photos[$randomPhotos[1]] ?>" target="_blank">
                    <div class="shop-window-photo"><?= $carousel[$randomPhotos[1]] ?></div>
                </a>
            </div>
        </div>
        <h2>Подробнее</h2>
        <div class="text-rating">
            <p><?= $model->shopFullDescription ?></p>
            <div class="rating">
                <div>
                    <?=
                    StarRating::widget([
                        'name' => 'shop_rating',
                        'value' => $model->shopRating,
                        'language' => 'ru',
                        'pluginOptions' => [
                            'size' => 'xl',
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
                        'pluginEvents' => [
                            'rating:change' => "function(event, value, caption){
                                if (" . $model->myIsGuest() . ") { alert('Войдите или зарегистрируйтесь!'); return false; }
                                $.ajax({
                                    url:'/shop/rating',
                                    method:'post',
                                    data:{
                                        rating:value,
                                        shopId:" . $model->shopId . ",
                                        userId:" . $model->getUserId() . ",
                                    },
                                    dataType:'json',
                                    success:function(data){
                                        location.reload();
                                    }
                                });
                            }"
                        ],
                    ]);
                    ?>
                </div>

                <div><span>Диапазон цен:</span> 300–3000 руб.</div>
                <div>Pdf: меню, расписание, услуги</div>

            </div>
        </div>

    </div>

    <h2>Акции</h2>

    <div class="flex-wrap">

        <?php foreach ($shopEvents as $event) { ?>
            <div class="main-block-wrap">
                <img src="/img/eventPhoto/<?php if (!isset($event['eventPhotos'][0]['eventPhoto'])) {
                    echo 'nophoto.jpg';
                } else {
                    echo $event['eventPhotos'][0]['eventPhoto'];
                } ?>" class="photo" alt="">
                <div class="photo-wrap">
                    <a href="/events/<?= $event['id'] ?>" class="title"><?= $event['title'] ?></a>
                </div>
                <div class="info-block-wrap">
                    <p><?= mb_substr($event['shortDesc'], 0, 70) ?>
                        <a href="/events/<?= $event['id'] ?>">Подробнее...</a></p>
                </div>

                <?php \yii\widgets\Pjax::begin() ?>
                <?php if (UserEvent::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['event_id' => $event->id])->one()) {
                    $favorite = 'favorite_border_24px_rounded.svg';
                    $eventId = 'del-event-id';
                } else {
                    $favorite = 'Favor_rounded.svg';
                    $eventId = 'add-event-id';
                } ?>
                <a href="/shops/<?= $model->shopId ?>?<?= $eventId ?>=<?= $event['id'] ?>" title="Добавить в избранное"
                   class="favorite">
                    <img src="/img/user/<?= $favorite ?>" alt=""></a>
                <?php \yii\widgets\Pjax::end() ?>

                <span class="favorite-shop-type">Раздел - <a
                            href="/events?eventTypeId=<?= $event['eventTypeId'] ?>"><?= $event->eventType->type ?></a></span>
            </div>
        <?php } ?>

    </div>


</div>
