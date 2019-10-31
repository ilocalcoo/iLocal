<?php

use app\assets\CreateAsset;
use app\assets\ProfileMapsAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
CreateAsset::register($this);
ProfileMapsAsset::register($this);
$this->title = 'Добавить место - I\'m Local';
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-create">

    <h1>Добавить место</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
