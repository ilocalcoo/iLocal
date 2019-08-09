<?php

use kartik\daterange\DateRangePicker;
use kartik\daterange\DateRangePickerAsset;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Carousel;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\search\HappeningSearch $searchModel */
/* @var \app\models\Happening $shortDescData */
/* @var \app\models\Happening $happening */
/* @var \app\models\Happening[] $happenings */
/* @var \app\models\HappeningPhoto[] $photos */
/* @var \app\models\HappeningPhoto $photo */
/* @var \app\models\Shop[] $shops */

$this->registerCssFile('/css/happening/view.css');
$this->registerCssFile('/css/calendar.css', ['depends' => 'kartik\daterange\DateRangePickerAsset']);
$this->registerJsFile('/js/happeningsView.js', ['depends' => 'app\assets\AppAsset']);

$this->title = 'happenings';
$this->params['breadcrumbs'][] = $this->title;
happeningFeedAsset::register($this);
?>
<div class="happening-index">
    <div class="row">
        <div class="col-12">
            <div class="row date-picker-panel">
                <div class="col-6" >
                    Дата: <?php echo DateRangePicker::widget([
                                    'name'=>'date_range_1',
                                    'hideInput' => true,
                                    'value'=>date('d.m'),
                                    'convertFormat'=>true,
                                    'containerTemplate' => '
                                        <input type="text" readonly="" class="form-control range-value" value="{value}">
                                    ',
                                    'containerOptions' => [
                                        'tag' => 'span',
                                        'style' => 'display:inline-block;'
                                    ],
                                    'options' => [

                                    ],
                                    'pluginOptions'=>[
                                        'locale'=>[
                                            'format'=>'d.m',
                                            'separator'=>' - ',
                                            'cancelLabel' => 'Очистить',
                                            'applyLabel' => 'Готово',
                                        ],
                                        'minDate' => date('d.m'),
                                        'autoApply' => true,
                                        'linkedCalendars' => false,
                                        'buttonClasses' => 'btn btn-link btn-link-coral',
                                        'applyButtonClasses' => 'float-right',
                                        'cancelButtonClasses' => 'float-left',
                                        'template' => '
                                            <div class="daterangepicker">
                                                <div class="drp-buttons">
                                                    <button class="cancelBtn"></button>
                                                    <button class="applyBtn"></button>
                                                </div>
                                                <div class="ranges"></div>
                                                <div class="drp-calendar left single">
                                                    <div class="calendar-table"></div>
                                                    <div class="calendar-time"></div>
                                                </div>
                                            </div>
                                        ',
                                        'opens'=>'left'
                                    ],
                                    'pluginEvents' => [
//                                        "show.daterangepicker" => "function() { log("show.daterangepicker"); }",
//                                        "hide.daterangepicker" => "function() { log("hide.daterangepicker"); }",
                                        //'apply.daterangepicker' => 'function() { console.log("apply.daterangepicker"); }',
//                                        "cancel.daterangepicker" => "function() { log("cancel.daterangepicker"); }",
                                        ]
                                ]);
                            ?>
                </div>
                <div class="col-6 text-right">
                    <div class="custom-switch-label">Бесплатные</div>
                    <div class="custom-control custom-switch" style="display: inline-block">
                        <input type="checkbox" class="custom-control-input" id="customSwitches" checked>
                        <label class="custom-control-label" for="customSwitches"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php Pjax::begin(); ?>
    <div class="row">
    <?php
    foreach ($happenings as $happening) {
        //$happenings = $shop->gethappenings()->all();
        if (count($happenings) != 0) { ?>
            <div class="col-md-4 col-12">
                <div class="content card p-3">
                    <div class="row align-items-center h-100">
                        <div class="col-12">
                            <a class="shop-link" href="<?= 'shops/' . $happening->shop->shopId ?>" data-pjax="0">
                                <h5 class="card-title">
                                <img class="shop_img" src="/img/shopPhoto/<?php
                                        $shopPhoto = $happening->shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                                        if (is_null($shopPhoto)) {
                                            $shopPhoto = '/img/nophoto.jpg';
                                        }
                                        echo $shopPhoto ?>"
                                        alt="<?= $happening->shop->shopShortName ?>"
                                />
                                <?= $happening->shop->shopShortName ?>
                                </h5>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="/happenings/<?= $happening->id ?>">
                                <a href="/happenings/<?= $happening->id ?>">
                                <div class="slide-img">
                                    <img src="<?= '/img/happeningPhoto/'.$happening->happeningPhotos[0]->happeningPhoto ?>" alt="<?= $happening->title ?>">
                                    <div class="overlay">
                                        <div class="overlay-link"><?= $happening->title ?></div>
                                    </div>
                                    <span class="badge badge-coral">-15%</span>
                                </div>
                                </a>
                                <div class="slide-text"><?= mb_substr($happening->shortDesc,0,70).'...' ?></div>
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div class="like">
                                        <?php if (Yii::$app->user->isGuest) { ?>
                                            <?php
                                            Modal::begin([
                                                'toggleButton' => [
                                                    'label' => '<img src="/img/user/Favor_rounded.svg" alt="">',
                                                    'tag' => 'a',
                                                    'type' => '',
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
                                            <?php if (\app\models\UserShop::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['shop_id' => $happening->shop->shopId])->one()) {
                                                $favorite = 'favorite_border_24px_rounded.svg';
                                                $shopId = 'del-shop-id';
                                            } else {
                                                $favorite = 'Favor_rounded.svg';
                                                $shopId = 'add-shop-id';
                                            } ?>
                                            <a href="/shops?<?= $shopId ?>=<?= $happening->shop->shopId ?>" title="Добавить в избранное"
                                                    class="favorite">
                                                <img src="/img/user/<?= $favorite ?>" alt=""></a>
                                            <?php \yii\widgets\Pjax::end() ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="text-right happening-date">
                                        <?= $happening->begin .' - '. $happening->end ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
    </div>
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

    <div class="modal fade" id="happening-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content happening-view-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

</div>
<?php Pjax::end(); ?>




