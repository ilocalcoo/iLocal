<?php

/* @var $this yii\web\View */

use app\assets\ProfileMapsAsset;
use app\models\Shop;
use app\models\ThumbGenerator;
use yii\authclient\widgets\AuthChoice;
use app\assets\SliderAsset;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $shops app\models\Shop[] */
/* @var $events app\models\Event[] */
/* @var $happenings app\models\Happening[] */
/* @var $userCoords string */

ProfileMapsAsset::register($this);
SliderAsset::register($this);
?>

<div class="row">
		<div class="container">
			<div class="mt-5 d-none d-md-block"></div>
			<div class="row">
				<div class="col-md-6 col-12 mt-3">
					<h1 class="h1">I’m local – ваш гид по местам в округе</h1>
					<!--                <div class="d-none d-md-block">-->
					<!--                    <div class="row">-->
					<!--                        <div class="col-2 list-num">1.</div>-->
					<!--                        <div class="col-10 list-text">Открывайте новые места и узнавайте о том, что происходит поблизости.</div>-->
					<!--                    </div>-->
					<!--                    <div class="row">-->
					<!--                        <div class="col-2 list-num">2.</div>-->
					<!--                        <div class="col-10 list-text">Удобный поиск и возможность сохранять.</div>-->
					<!--                    </div>-->
					<!--                    <div class="row">-->
					<!--                        <div class="col-2 list-num">3.</div>-->
					<!--                        <div class="col-10 list-text">Новое качество жизни: взгляните по-новому на свой район и не тратьте время на долгие поездки.</div>-->
					<!--                    </div>-->
					<!--                </div>-->

					<form action="/shops" method="get" class="text-center main-form">
						<input type="hidden" name="coords_address" id="coords_address" value="">
						<input type="hidden" id="input_address" value="">
            <?php if (!is_null($userCoords)) { ?>
							<span id="user_coordinates" style="display: none"><?= $userCoords ?></span>
            <?php } ?>
						<div class="form-group main-group">
              <?php
              Modal::begin([
                'size' => 'modal-lg',
                'toggleButton' => [
                  'label' => '<div class="form-control input input-place" data-toggle="modal" data-target="#exampleModal">
                                    <span class="place-text" id="view_address">Выберите местоположение</span>
                                    <span class="input-label"><img src="img/main/building.png" alt="Выберите место"></span>
                                <span class="input-label-right"><i class="fas fa-chevron-right"></i></span>
                                </div>',
            'tag' => 'a',
            'class' => '',
            'type' => '',
          ],
          'closeButton' => [
            'class' => 'btn btn-coral',
            'label' => 'Выбрать / Закрыть'
          ]
        ]);
        ?>
				<div class="modal-body">
					<div id="profile_map"></div>
				</div>
        <?php Modal::end(); ?>
			</div>
			<div class="form-group main-group">
				<div class="slidecontainer input form-control bg-white">
					<input type="range" min="1" max="11" value="5" class="slider" id="round_range" name="round_range">
				</div>
				<span class="range-text">На расстоянии <span id="range_text" class="range-value">1 км</span></span>
				<span class="input-label"><img src="img/main/aim.png" alt="Выберите место"></span>
			</div>
			<button class="btn btn-coral w-100">Начать</button>
		</form>

	</div>
	<div class="col-md-6 col-12 d-none d-md-block">
		<img src="img/main/index-bg-img.png" alt="people" height="485px">
	</div>
</div>

<section id="actions">
    <div class="container mt-5">
        <div class="w-100 mb-3"><span class="h3">Акции</span><span style="float: right"><a href="/events"><button  class="btn btn-outline-coral">Все акции</button></a></span></div>
        <div class="row">
            <div class="col-12 scrolls" id="scrolls">
                <?php foreach ($events as $event) { ?>
						<div class="slide col-md-3 col-8 align-top">
							<a href="/events/<?= $event->id ?>">
								<div class="slide-img">
									<img width="277px"
											 src="<?php $photo = $event->getEventPhotos()->asArray()->one()['eventPhoto'];
                                             if (is_null($photo)) {
                                                 echo '/img/nophoto.jpg';
                                             } else {
                                                 echo '/img/eventPhoto/' . ThumbGenerator::getGallery($event->id, 'img/eventPhoto')['medium'][0];
                                             } ?>" alt="<?= $event->title ?>">
									<div class="overlay">
										<a class="overlay-link" href="/events/<?= $event->id ?>"><?= $event->title ?></a>
									</div>
									<span class="badge badge-coral">-15%</span>
								</div>
								<div class="slide-header"><?= $event->eventOwner->shopShortName ?></div>
								<div class="slide-text"><?= mb_substr($event->shortDesc, 0, 52) . '...' ?></div>
							</a>
						</div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php if (!empty($happenings)) {?>
<section id="happening">
    <div class="container mt-5">
        <div class="w-100 mb-3"><span class="h3">События рядом с вами</span></div>
        <div class="row">
            <?php foreach ($happenings as $happening) { ?>
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
<section id="shops">
	<div class="container mt-5">
		<div class="w-100 mb-3"><span class="h3">Места</span><span style="float: right"><a href="/shops"><button
						class="btn btn-outline-coral">Все места</button></a></span></div>
		<div class="row">
			<div class="col-12 scrolls" id="scrolls">
        <?php foreach ($shops as $shop) { ?>
					<div class="slide col-md-3 col-8">
						<a href="/shops/<?= $shop->shopId ?>">
							<div class="slide-img">
								<img style="height: 200px" src="/img/shopPhoto/<?php
                $shopPhoto = $shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                if (is_null($shopPhoto)) {
                  $shopPhoto = '/img/nophoto.jpg';
                }
                echo $shopPhoto ?>" alt="<?= $shop->shopShortName ?>" data-pjax="0">
								<div class="overlay">
									<a class="overlay-link event-link" href="<?= 'shops/' . $shop->shopId ?>"
										 data-pjax="0"><?= $shop->shopShortName ?>
										<div class="event-date">1 км</div>
									</a>
								</div>
								<span class="badge badge-coral"><?= number_format($shop->shopRating, 1, '.', ','); ?></span>
							</div>
						</a>
					</div>
        <?php } ?>
			</div>

		</div>
	</div>
</section>