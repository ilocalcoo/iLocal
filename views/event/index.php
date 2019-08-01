<?php

use app\assets\EventFeedAsset;
use app\models\UserEvent;
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
/* @var \app\models\search\EventSearch $searchModel */
/* @var \app\models\Event $shortDescData */
/* @var \app\models\Event $event */
/* @var \app\models\Event[] $events */
/* @var \app\models\EventPhoto[] $photos */
/* @var \app\models\EventPhoto $photo */
/* @var \app\models\Shop[] $shops */

$this->registerCssFile('/css/event/view.css');
$this->registerCssFile('/css/calendar.css', ['depends' => 'kartik\daterange\DateRangePickerAsset']);
$this->registerJsFile('/js/eventsView.js', ['depends' => 'app\assets\AppAsset']);

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
EventFeedAsset::register($this);
?>
<div class="event-index">
    <div class="row">
        <div class="col-12">
            <div class="row" style="min-height:38px;background: #FFFFFF;box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.15);border-radius: 15px 15px 0px 0px;">
                <div class="col-6" style>
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
                    Бесплатные
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
    foreach ($shops as $shop) {
        $events = $shop->getEvents()->all();
        if (count($events) != 0) { ?>
            <div class="col-12 mb-4">
                <div class="content container card p-3">
                    <div class="row align-items-center h-100">
                        <div class="col-md-2 col-12 mx-auto text-center">
                            <a class="shop_img" href="<?= 'shops/' . $shop->shopId ?>" data-pjax="0">
                                <img class=""
                                        src="/img/shopPhoto/<?php
                                        $shopPhoto = $shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                                        if (is_null($shopPhoto)) {
                                            $shopPhoto = '/img/nophoto.jpg';
                                        }
                                        echo $shopPhoto ?>"
                                        alt="<?= $shop->shopShortName ?>"
                                />
                            </a>
                        </div>
                        <div class="col-md-10 col-12 mx-auto text-md-left text-center">
                            <h5 class="card-title"><?= $shop->shopShortName ?></h5>
                        </div>
                    </div>
                    <div class="row ml-3 mr-3">
                        <div class="col-12 scrolls" id="scrolls">
                            <?php
                            $events = $shop->getEvents()->all();
                            foreach ($events as $event) { ?>

                                <div class="slide col-md-3 col-8 align-top">
                                    <a href="/events/<?= $event->id ?>">
                                        <div class="slide-img">
                                            <img width="277px" src="<?= '/img/eventPhoto/'.$event->eventPhotos[0]->eventPhoto ?>" alt="<?= $event->title ?>">
                                            <div class="overlay">
                                                <a class="overlay-link" href="/events/<?= $event->id ?>"><?= $event->title ?></a>
                                            </div>
                                            <span class="badge badge-coral">-15%</span>
                                        </div>
                                        <div class="slide-text"><?= mb_substr($event->shortDesc,0,70).'...' ?></div>
                                    </a>
                                </div>

                            <?php } ?>
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

    <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content event-view-content">
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




