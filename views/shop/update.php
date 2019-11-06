<?php

use app\assets\CreateAsset;
use app\assets\ProfileMapsAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
CreateAsset::register($this);
ProfileMapsAsset::register($this);
$this->title = 'Обновление места: ' . $model->shopShortName;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->shopShortName, 'url' => ['view', 'id' => $model->shopId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
