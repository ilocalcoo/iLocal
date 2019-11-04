<?php

use app\assets\CreateAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
CreateAsset::register($this);
$this->title = 'Обновить событие - I\'m Local';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-update">

    <h1>Обновить событие</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
