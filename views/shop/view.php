<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */

$this->title = $model->shopId;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="shop-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
