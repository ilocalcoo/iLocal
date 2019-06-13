<?php

use app\assets\EventAsset;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\search\EventSearch $searchModel */
/* @var \app\models\Event $shortDescData */
/* @var \app\models\Event $event */
/* @var \app\models\Event[] $events */
/* @var \app\models\EventPhoto[] $photos */
/* @var \app\models\EventPhoto $photo */
/* @var \app\models\Shop[] $shops */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
EventAsset::register($this);
?>
<div class="event-index">

    <?php Pjax::begin(); ?>
	<main class="container">
        <?php
        foreach ($shops as $shop) { ?>

		<div class="content">
			<div class="cont_title">
				<a class="shop_img" href="<?= 'shop/view/'.$shop->shopId ?>">
					<img
						src="<?php echo $shop->getShopPhotos()->limit(1)->asArray()->all()[0]['shopPhoto'] ?>"
						alt="<?= $shop->shopShortName ?>"/>
				</a>
				<div class="right_title">
					<a class="shop_name" href="<?= 'shop/view/'.$shop->shopId ?>">
                        <?= $shop->shopShortName ?>
					</a>
					<div class="shop_address">
                        <?php
                        $address = $shop->shopAddress->city . ', ул. ' .
                            $shop->shopAddress->street . ', д. ' .
                            $shop->shopAddress->houseNumber;
                        // TODO доделать отображение корпусов и строений
                        echo $address;
                        ?>
					</div>
				</div>
			</div>
			<div class="big_carousel">
                <?php
                $events = $shop->getEvents()->all();
                foreach ($events as $event) {
                    $photos = $event->getTopEventPhotos()->asArray()->all();
                    if (count($photos) == 0) {
                        $photos = [
                            0 => [
                                'eventPhoto' => '/img/nophoto.jpg'
                            ]
                        ];
                    }
                    ?>
					<div class="event_card">
                        <?php
                        echo Html::beginTag('a', [
							'href' => 'event/view/'.$event->id,
                            'class' => 'card_top',
                        ]);
                            $items = [];
							foreach ($photos as $photo) {
                                $content = [
                                	'content' => '<img src="' . $photo['eventPhoto'] . '"/img>',
									'caption' => $event->title,
								];
                                array_push($items, $content);
                            }
                            echo Carousel::widget([
                                'items' => $items,
                            ]);
                        Html::endTag('a');
                        ?>
						<div class="card_bot">
							<div class="card_short_desc">
                                <?= $event->shortDesc ?>
							</div>
							<div class="like_data">
								<div class="like">
									<img src="/img/like.png" alt="like">
								</div>
								<span>
								<?php $data = $event->begin . '-' . $event->end;
                                echo $data; ?>
								</span>
							</div>
						</div>
					</div>
                <?php } ?>
			</div>
		</div>
        <?php } ?>
	</main>
</div>
<?php Pjax::end(); ?>




