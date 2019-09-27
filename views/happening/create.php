<?php

use app\assets\CreateAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
CreateAsset::register($this);
$this->title = 'Добавить событие - I\'m Local';
$this->params['breadcrumbs'][] = ['label' => 'Happenings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">

    <h1>Добавить событие</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
