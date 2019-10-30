<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */

$this->title = 'Update Shop: ' . $model->shopId;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->shopId, 'url' => ['view', 'id' => $model->shopId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
