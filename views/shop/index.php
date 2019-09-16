<?php

use app\assets\AppAsset;
use app\assets\ShopFeedAsset;
use kartik\rating\StarRating;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $shops app\models\Shop[] */
/* @var $pages \yii\data\Pagination */
/* @var $shopType \app\models\ShopType */
/* @var $searchModel \app\models\search\ShopSearch */
/* @var $shopShortName \app\models\search\ShopSearch */

ShopFeedAsset::register($this);
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
		<br>
    <?php echo $this->render('_search', ['model' => $searchModel, 'shopShortName' => $shopShortName]); ?>
	</div>

	<div class="row">
		<div class="col-12">
      <?php
      Pjax::begin();
      foreach ($shops as $key => $shop) { ?>
				<div class="row content">
					<div class="d-flex col-4 align-items-center">
						<a class="shop_img" href="<?= 'shops/' . $shop->shopId ?>" data-pjax="0">
							<img src="/img/shopPhoto/<?php
              $shopPhoto = $shop->getShopPhotos()->asArray()->one()['shopPhoto'];
              if (is_null($shopPhoto)) {
                $shopPhoto = '/img/nophoto.jpg';
              }
              echo $shopPhoto ?>" alt="<?= $shop->shopShortName ?>" data-pjax="0">
						</a>
					</div>

					<div class="col-md-8 col-7">
						<div class="row">
							<div class="col-lg-8 col-md-7 col-12">
								<div class="name_and_rating">
									<a class="shop_name" href="<?= 'shops/' . $shop->shopId ?>" data-pjax="0"
										 tabindex="1"><?= $shop->shopShortName ?></a>
								</div>

							</div>
							<div class="col-lg-4 col-md-5 d-none d-md-block">
                <?php echo StarRating::widget([
                  'name' => 'shop_rating',
                  'value' => $shop->shopRating,
                  'language' => 'ru',
                  'pluginOptions' => [
                    'displayOnly' => true,
                    'size' => 'md',
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
                ]); ?>
							</div>
						</div>
						<div class="row shop_address">
							<div class="col-12 d-none d-md-block">
                <?php
                $address = 'г. ' . $shop->shopAddress->city . ', ул. ' .
                  $shop->shopAddress->street . ', д. ' .
                  $shop->shopAddress->houseNumber;
                // TODO доделать отображение корпусов и строений
                echo $address; ?>
							</div>
						</div>
						<div class="row shop_address-line d-none d-md-block"></div>
						<div class="row d-sm-block d-md-none col-12">
              <span class="distance"><?=
                (!is_null($shop->distance)) ?
                  \app\models\Shop::beautifyDistance($shop->distance) . " от Вас"
                  : '';
                ?>
              </span>
						</div>
						<div class="row text_and_like">
							<span class="col-12"><?= $shop->shopShortDescription ?></span>
							<div class="like d-none d-md-block offset-11">
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
						<div class="work_time_and_category d-none d-md-block">
						<span class="work_time"><?php if ($shop->shopWorkTime) {

                echo 'Время работы: ' . $shop->shopWorkTime;
              } ?></span>
							<span class="category"><?php $category = \app\models\ShopType::TYPES_LABELS[$shop->shopTypeId];
                echo 'Раздел - ' . $category; ?></span>
						</div>
					</div>
					<div class="d-sm-block d-md-none col-1 mobile-rating">
						<div class="row">
              <?php if (!is_null($shop->shopAvgRating)) { ?>
								<span>
								<?= mb_substr($shop->shopAvgRating, 0, 3); ?>
								</span>
              <?php } ?>
						</div>
					</div>
				</div>
      <?php } ?>
		</div>
	</div>
  <?php Pjax::end(); ?>

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

	<div class="row">
		<div class="col-12">
			<nav class="pagination">
        <?= \yii\widgets\LinkPager::widget([
          'pagination' => $pages,
          'nextPageCssClass' => 'page-item',
          'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
          'prevPageCssClass' => 'page-item',
          'pageCssClass' => 'page-item',
          'linkOptions' => ['class' => 'page-link'],
          'nextPageLabel' => '>',
          'prevPageLabel' => '<',
        ]); ?>
			</nav>
		</div>
	</div>

</div>
<a href="" id="loupe" class="d-md-none d-sm-block"></a>
<a id="loupe-tail" class="d-md-none d-sm-block"></a>
<?php if (!array_key_exists('shopShortName', $_GET)) { ?>
	<div id="find-placeholder">
		<div class="loupe-img"></div>
		<div class="loupe-tail-img"></div>
		<span>Поиск...</span>
	</div>
<?php } ?>
<img src="img/main/close.svg" class="nav-link" id="find-close" alt="find-close" width="32px"
		 height="32px">