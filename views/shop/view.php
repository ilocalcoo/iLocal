<?php

use app\models\Event;
use app\models\ThumbGenerator;
use app\models\UserEvent;
use kartik\rating\StarRating;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $shopEvents app\models\Event */

$this->title = $model->shopShortName;

\app\assets\StoreFrontAsset::register($this);

$photos = [];
$carousel = [];
$photoLinks = [];
$randomPhotos = [];
$gallery = ThumbGenerator::getGallery($model->shopId);
if ($gallery) {
    $photos = $gallery['medium'];
    foreach ($gallery['full'] as $key => $galleryFile) {
        $photoLinks[] = '<img src="/img/shopPhoto/' . $gallery['medium'][$key] . '"/>';
        $carousel[] = '<img src="/img/shopPhoto/' . $galleryFile . '"/>';
    }
} else { // для обратной совместимости
    foreach ($model->shopPhotos as $photo) {
        $photos[] = $photo->shopPhoto;
        $carousel[] = '<img src="/img/shopPhoto/' . $photo->shopPhoto . '"/>';
    }
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
		<div class="modal fade" id="modal-map" tabindex="-1" role="dialog" aria-labelledby="map-label"
			 aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-size">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="map-label">Адрес места</h4>
					</div>
					<div class="modal-body" id="show-map">
					</div>
				</div>
			</div>
		</div>
		<h1><?= Html::encode($this->title) ?></h1>
		<span class="shop-type"><?= $model->shopType::TYPES_LABELS[$model->shopType->id] ?></span>
		<span class="shop-cost"><?= $model::SHOP_MIDDLE_COST_LABELS[$model->shopMiddleCost] ?></span>
		<div class="shop-contacts">
			<div class="shop-location"><img src="/img/shop/Location.svg" alt="Location">
				<a type="button" id="link-map" data-toggle="modal"
				   data-coords="<?php
                   if ($model->shopAddress->latitude && $model->shopAddress->longitude) {
                       echo $model->shopAddress->latitude . ',' . $model->shopAddress->longitude;
                   }
                   ?>"
				   data-target="#modal-map" href="#"><?php
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
                ?></a>
            </div>
            <div class="shop-location"><img src="/img/shop/Phone.svg"
                                            alt="Phone"><?= $model->shopPhone ? $model->shopPhone : '' ?></div>
            <div class="shop-location"><img src="/img/shop/Url.svg"
                                            alt="Url"><a href="<?= $model->shopWeb ? $model->shopWeb : '' ?>"
                                                         target="_blank"><?= $model->shopWeb ? $model->shopWeb : '' ?></a>
            </div>
            <div class="shop-location shop-location-work-time">
                <img src="/img/shop/Time_to_go.svg" alt="Time to go">
                <span>Режим работы</span>
                <div class="shop-location-work-time-hidden">
                    <?= $model->shopWorkTime ? $model->shopWorkTime : 'Не указан' ?>
                </div>
            </div>
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
                <a href="/img/shopPhoto/<?= $gallery['full'][$randomPhotos[0]] ?? $photos[$randomPhotos[0]] ?>" target="_blank">
                    <div class="shop-window-photo">
                        <?= $photoLinks[$randomPhotos[0]] ?? $carousel[$randomPhotos[0]]; ?>
                    </div>
                </a>
                <a href="/img/shopPhoto/<?= $gallery['full'][$randomPhotos[1]] ?? $photos[$randomPhotos[1]] ?>" target="_blank">
                    <div class="shop-window-photo">
                        <?= $photoLinks[$randomPhotos[1]] ?? $carousel[$randomPhotos[1]]; ?>
                    </div>
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
                            'filledStar' => '<span class="krajee-icon krajee-icon-star rating-filled-stars"></span>',
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
					<a href="events/<?= $event['id'] ?>" class="title event-view" id="<?= $event['id'] ?>"><?= $event['title'] ?></a>
				</div>
				<div class="info-block-wrap">
					<p><?= mb_substr($event['shortDesc'], 0, 70) ?>
						<a href="" class="event-view" id="<?= $event['id'] ?>">Подробнее...</a></p>
				</div>

                <?php if (Yii::$app->user->isGuest) { ?>
                    <?php
                    Modal::begin([
                        'toggleButton' => [
                            'label' => '<img src="/img/user/Favor_rounded.svg" alt="" class="favorite">',
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
                    <?php \yii\widgets\Pjax::begin() ?>
                    <?php if (UserEvent::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['event_id' => $event->id])->one()) {
                        $favorite = 'favorite_border_24px_rounded.svg';
                        $eventId = 'del-event-id';
                    } else {
                        $favorite = 'Favor_rounded.svg';
                        $eventId = 'add-event-id';
                    } ?>
					<a href="/shops/<?= $model->shopId ?>?<?= $eventId ?>=<?= $event['id'] ?>"
					   title="Добавить в избранное"
					   class="favorite">
						<img src="/img/user/<?= $favorite ?>" alt=""></a>
                    <?php \yii\widgets\Pjax::end() ?>
                <?php } ?>

				<span class="favorite-shop-type">Раздел - <a
						href="/events?eventTypeId=<?= $event['eventTypeId'] ?>"><?= $event->eventType->type ?></a></span>
			</div>
        <?php } ?>

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
