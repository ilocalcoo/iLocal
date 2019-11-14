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
/* @var $shopHappenings app\models\Happening */

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
        $photoLinks[] = '<img src="/img/shopPhoto/' . $gallery['medium'][$key] . '" class="img-fluid"/>';
        $carousel[] = '<img src="/img/shopPhoto/' . $galleryFile . '" class="img-fluid"/>';
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
<div class="container shop-view">

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
    <h1 class="shop-title"><?= Html::encode($this->title) ?></h1>
    <span class="shop-type"><?= $model->shopType::TYPES_LABELS[$model->shopType->id] ?></span>
    <span class="shop-cost"><?= $model::SHOP_MIDDLE_COST_LABELS[$model->shopMiddleCost] ?></span>
    <div class="row shop-contacts">
        <?php if ($model->shopAddress) { ?>
        <div class="col-12 col-md-3 shop-location">
            <img src="/img/shop/Location.svg" alt="Location">
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
        <?php } ?>
        <div class="col-12 col-md-3 shop-location"><img src="/img/shop/Phone.svg"
                                        alt="Phone"><?= $model->shopPhone ? $model->shopPhone : '' ?></div>
        <div class="col-12 col-md-3 shop-location"><img src="/img/shop/Url.svg"
                                        alt="Url"><a href="<?= $model->shopWeb ? $model->shopWeb : '' ?>"
                                                     target="_blank"><?= $model->shopWeb ? $model->shopWeb : '' ?></a>
        </div>
        <div class="col-12 col-md-3 shop-location shop-location-work-time">
            <img src="/img/shop/Time_to_go.svg" alt="Time to go">
            <span>Режим работы</span>
            <div class="shop-location-work-time-hidden">
                <?= $model->shopWorkTime ? $model->shopWorkTime : 'Не указан' ?>
            </div>
        </div>
    </div>
    <div class="row shop-window-gallery">
        <div class="col-12 col-md-8 shop-window-carousel">
            <?= \yii\bootstrap4\Carousel::widget([
                'items' => $carousel,
                'options' => [
//                        'class' => 'carousel slide',
//                        'data-interval' => '12000'
                ],
                'controls' => [
                    '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>',
                    '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>'
                ]

            ]) ?>
        </div>
        <div class="col-12 col-md-4">
            <h2>Подробнее</h2>

                <p><?= $model->shopFullDescription ?></p>


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


                    <div><span>Диапазон цен:</span> 300–3000 руб.</div>
                    <div>Pdf: меню, расписание, услуги</div>


        </div>
    </div>
    <section id="actions">
        <div class="container mt-5">
            <div class="w-100 mb-3"><span class="h3">Акции</span><span style="float: right"><a href="/events"><button  class="btn btn-outline-coral">Все акции</button></a></span></div>
            <div class="row">
                <div class="col-12 scrolls" id="scrolls">
                    <?php foreach ($shopEvents as $event) { ?>
                        <div class="slide col-md-3 col-8 align-top">
                            <a href="/events/<?= $event->id ?>">
                                <div class="slide-img">
                                    <img width="277px"
                                            src="
											 <?php $photo = $event->getEventPhotos()->asArray()->one()['eventPhoto'];
                                            if (is_null($photo)) {
                                                echo '/img/nophoto.jpg';
                                            } else {
                                                echo '/img/eventPhoto/' . ThumbGenerator::getGallery($event->id, 'img/eventPhoto')['medium'][0];
                                            } ?>"
                                            alt="<?= $event->title ?>">
                                    <div class="overlay">
                                        <a class="overlay-link" href="/events/<?= $event->id ?>"><?= $event->title ?></a>
                                    </div>
                                    <span class="badge badge-coral">-15%</span>
                                </div>
                                <div class="slide-text"><?= mb_substr($event->shortDesc, 0, 52) . '...' ?></div>
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <?php
                                    Modal::begin([
                                        'toggleButton' => [
                                            'label' => '<img src="/img/user/Favor_rounded.svg" alt="">',
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
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php if (!empty($shopHappenings)) {?>
        <section id="happening">
            <div class="container mt-5">
                <div class="w-100 mb-3"><span class="h3">События</span></div>
                <div class="row">
                    <?php foreach ($shopHappenings as $happening) { ?>
                        <div class="event-item col-md-4 col-12">
                            <div class="slide-img happening-img">
                                <img src="<?php $photo = $happening->getHappeningPhotos()->asArray()->one()['happeningPhoto'];
                                if (is_null($photo)) {
                                    echo '/img/nophoto.jpg';
                                } else {
                                    echo '/img/happeningPhoto/' . ThumbGenerator::getGallery($happening->id, 'img/happeningPhoto')['medium'][0];
                                } ?>"
                                        alt="<?= $happening->title ?>">
                                <div class="overlay">
                                    <a class="overlay-link event-link" href="#"><?= $happening->title ?> <div class="event-date"><?= $happening->begin ?></div></a>
                                </div>
                                <span class="badge badge-coral"><?= $happening->price ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <a href="/happenings"><button  class="btn btn-outline-coral w-100">Все события</button></a>
            </div>
        </section>
    <?php } ?>
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
