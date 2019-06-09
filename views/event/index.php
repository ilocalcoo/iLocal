<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\search\EventSearch $searchModel */
/* @var \app\models\Event $shortDescData */
/* @var \app\models\Event[] $models */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <?php Pjax::begin(); ?>
    <?php
    foreach ($models as $model) { ?>
		<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100" src="..." alt="First slide">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="..." alt="Second slide">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="..." alt="Third slide">
				</div>
			</div>
		</div>
    <?php } ?>

	// отображаем ссылки на страницы
    <?php echo LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
