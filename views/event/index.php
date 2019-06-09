<?php

use yii\bootstrap\Carousel;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\search\EventSearch $searchModel */
/* @var \app\models\Event $shortDescData */
/* @var \app\models\Event[] $models */
/* @var \app\models\EventPhoto $photo */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <?php Pjax::begin(); ?>
    <?php
    foreach ($models as $model) { ?>
	<main class="container">
		<div class="content">
			<div class="cont_title">
				<div class="shop_img">
					<img src="<?= $model->eventOwner->getShopPhotos->limit(1)->shopPhoto ?>"
						 alt="<?= $model->eventOwner->shopShortName ?>">
				</div>
				<div class="right_title">
					<div class="shop_name">
						<?= $model->eventOwner->shopShortName ?>
					</div>
					<div class="shop_address">
						<?php
							$address = $model->eventOwner->shopAddress->city . ', ул. ' .
							$model->eventOwner->shopAddress->street . ', д. ' .
							$model->eventOwner->shopAddress->houseNumber . ', к. ' .
							$model->eventOwner->shopAddress->housing . ', к. ' .
						?>
					</div>
				</div>
			</div>
			<div class="carousel">
        <?php
        $photos = $model->getTopEventPhotos()->asArray()->all();
        if (count($photos) == 0) {
            $photos = [
                0 => [
                    'eventPhoto' => '/img/nophoto.jpg'
                ]
            ];
        }
        $items = [];
        foreach ($photos as $photo) {
            $content = '<img src="' . $photo['eventPhoto'] . '"/img>';
            array_push($items, $content);
        }
        echo Carousel::widget([
            'items' => $items
        ]);
        ?>
        <?php } ?>

        <?php Pjax::end(); ?>

			</div>
		</div>
	</main>
</div>
