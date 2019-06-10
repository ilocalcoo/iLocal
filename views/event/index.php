<?php

use yii\bootstrap\Carousel;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\search\EventSearch $searchModel */
/* @var \app\models\Event $shortDescData */
/* @var \app\models\Event $event */
/* @var \app\models\EventPhoto $photo */
/* @var \app\models\Shop[] $shops */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <?php Pjax::begin(); ?>
	<main class="container">
	<?php
    foreach ($shops as $shop) { ?>

		<div class="content">
			<div class="cont_title">
				<div class="shop_img">
					<img
						src="<?php echo $shop->getShopPhotos()->limit(1)->asArray()->all()[0]['shopPhoto'] ?>"
						alt="<?= $shop->shopShortName ?>"/>
				</div>
				<div class="right_title">
					<div class="shop_name">
                        <?= $shop->shopShortName ?>
					</div>
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
			<div class="carousel">
                <?php

				foreach ($shop->getEvents()->all() as $event) {
                    $photos = $event->getTopEventPhotos()->asArray()->all();
                    if (count($photos) == 0) {
                        $photos = [
                            0 => [
                                'eventPhoto' => '/img/nophoto.jpg'
                            ]
                        ];
                    }
                    $items = [];
                    foreach ($photos as $photo) {
                        $content = '<div class="event_card">
							<div class="card_top">' .
                            Carousel::widget([
                                'items' => '<img src="' . $photo['eventPhoto'] . '"/img>',
                            ]) .
                            '</div>
							<div class="card_bot">
								
							</div>
						</div>';
                        $content .= '<img src="' . $photo['eventPhoto'] . '"/img>';
                        array_push($items, $content);
                    }
                    echo Carousel::widget([
                        'items' => $items
                    ]);
                }
                ?>
			</div>
		</div>
                <?php } ?>

                <?php Pjax::end(); ?>


	</main>
</div>
