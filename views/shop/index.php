<?php

use app\assets\ShopAsset;
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $shops app\models\Shop[] */
/* @var $pages \yii\data\Pagination */
/* @var $shopType \app\models\ShopType */

ShopAsset::register($this);
$type = 'Все магазины';
if (count(Yii::$app->request->queryParams) != 0) {
    $shopType = \app\models\ShopType::find()->where(['id' => Yii::$app->request->queryParams['shopTypeId']])->one();
    $type = $shopType->type;
}
$type = mb_strtoupper(mb_substr($type, 0, 1)) . mb_substr($type, 1, mb_strlen($type));
$this->title = $type . ' рядом с вами';
?>
<div class="shop-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<div class="under_title">
		<span>Вы смотрите места которые находятся рядом с вами в разделе "<?= $type ?>"</span>
	</div>
    <?php Pjax::begin(); ?>
	<main class="container">
        <?php
        foreach ($shops as $shop) { ?>
			<div class="content">
				<a class="shop_img" href="<?= 'shops/' . $shop->shopId ?>">
					<img src="<?=
                    $shopPhoto = $shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                    if (is_null($shopPhoto)) {
                        $shopPhoto = '/img/nophoto.jpg';
                    }
                    echo $shopPhoto ?>" alt="<?= $shop->shopShortName ?>">
				</a>
				<div class="right">
					<div class="name_and_rating">
						<a class="shop_name" href="<?= 'shops/' . $shop->shopId ?>">
                            <?= $shop->shopShortName ?>
						</a>

					</div>
				</div>
			</div>
        <?php } ?>

	</main>
    <?php Pjax::end(); ?>
	<div class="pagination">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'nextPageLabel' => '>',
            'prevPageLabel' => '<',
        ]); ?>
	</div>
	return StarRating::widget([
	'name' => 'shop_rating',
	'value' => $model->shopRating,
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
	'pluginEvents' => [
	'rating:change' => "function(event, value, caption){
	if (". $model->myIsGuest() .") { alert('guest'); return false; }
	$.ajax({
	url:'/shop/rating',
	method:'post',
	data:{
	rating:value,
	shopId:". $model->shopId .",
	userId:". $model->getUserId() .",
	},
	dataType:'json',
	success:function(data){
	location.reload();
	}
	});
	}"
	],
	]);
	},
	'format' => 'raw',
	],
	'shopWorkTime',
	],
	]);

</div>
