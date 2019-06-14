<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */

$this->title = $model->shopShortName;

\yii\web\YiiAsset::register($this);
$this->registerCssFile('/css/shop/view.css');

$carousel = [];
foreach ($model->shopPhotos as $photo) {
    $carousel[] = '<img src="/img/shopPhoto/' . $photo->shopPhoto . '"/>';
}
//var_dump($carousel);exit;
?>
<div class="shop-view">
    <div class="shop-window-container">

        <h1><?= Html::encode($this->title) ?></h1>
        <span class="shop-type"><?= $model->shopType::TYPES_LABELS[$model->shopType->id] ?></span>
        <span class="shop-cost"><?= $model::SHOP_MIDDLE_COST_LABELS[$model->shopMiddleCost] ?></span>
        <div class="shop-contacts">
            <div class="shop-location"><img src="/img/shop/Location.svg" alt="Location">
                <?
                $comma = '';
                foreach (ArrayHelper::toArray($model->shopAddress) as $key => $item) {
                    if ($key == 'id' || $item == '') {
                        continue;
                    }
                    echo $comma . $item;
                    $comma = ', ';
                }
                ?>
                ?
            </div>
            <div class="shop-location"><img src="/img/shop/Phone.svg" alt="Phone">+7 (499) 234-234-234</div>
            <div class="shop-location"><img src="/img/shop/Url.svg" alt="Url">gvozdi.com</div>
            <div class="shop-location"><img src="/img/shop/Time_to_go.svg" alt="Time to go">Режим работы</div>
        </div>
        <div class="shop-window-gallery">
            <div class="shop-window-carousel">
                <?= \yii\bootstrap\Carousel::widget([
                    'items' => $carousel,
                    'options' => ['class' => 'carousel slide', 'data-interval' => '12000'],
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                        '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                    ]

                ]) ?>
            </div>
            <div class="shop-window-photos">

            </div>
        </div>

    </div>

    <br><br><br><br><br><br><br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'shopId',
            'shopActive',
            'shopShortName',
            'shopFullName',
            //'shopPhoto',
            'shopTypeId',
            'shopPhone',
            'shopWeb',
            'shopAddressId',
            'shopCostMin',
            'shopCostMax',
            'shopMiddleCost',
            'shopAgregator',
            'shopStatusId',
        ],
    ]) ?>

</div>
