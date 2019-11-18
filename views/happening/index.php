<?php

use app\assets\HappeningFeedAsset;
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
/* @var $pages \yii\data\Pagination */
/* @var \app\models\Happening $shortDescData */
/* @var \app\models\Happening $happening */
/* @var \app\models\Happening[] $happenings */
/* @var \app\models\HappeningPhoto[] $photos */
/* @var \app\models\HappeningPhoto $photo */
/* @var \app\models\Shop[] $shops */

$this->registerCssFile('/css/happening/view.css');
$this->registerCssFile('/css/calendar.css', ['depends' => 'kartik\daterange\DateRangePickerAsset']);
//$this->registerJsFile('/js/happeningsView.js', ['depends' => 'app\assets\AppAsset']);

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
HappeningFeedAsset::register($this);
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
                        <input type="checkbox" class="custom-control-input" id="customSwitches">
                        <label class="custom-control-label" for="customSwitches"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php //Pjax::begin(); ?>
    <section id="events">
        <div class="container mt-5">
            <div class="w-100 mb-3"><h1 class="h3">
                    <?= count($happenings) == 0 ? 'Нет событий' : 'События рядом с вами' ?>
                </h1></div>
            <div class="row">
                <?php
                foreach ($happenings as $happening) {
                    //$happenings = $shop->gethappenings()->all();
                    if (count($happenings) != 0) { ?>
                        <div class="event-item col-md-6 col-12">
                            <a href="/happenings/<?= $happening->id ?>">
                            <div class="slide-img">
                                <img src="<?= '/img/happeningPhoto/'.($happening->happeningPhotos ? $happening->happeningPhotos[0]->happeningPhoto : 'nofoto') ?>" alt="<?= $happening->title ?>">
                                <div class="overlay">
                                    <div class="overlay-link event-link" href="/happenings/<?= $happening->id ?>">
                                        <?= mb_strlen($happening->title) > 70 ? mb_substr($happening->title,0,70).'...' : $happening->title ?>
                                        <div class="event-date">
                                            <?= date('H:i d.m.Y', strtotime($happening->begin)) ?>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge badge-coral"><?= $happening->price ?? 'Free'?></span>
                            </div>
                            </a>
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
        </div>
    </section>

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
<?php //Pjax::end(); ?>




