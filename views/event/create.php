<?php

use app\assets\CreateAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/**
 * @var $eventOwner
 */
CreateAsset::register($this);
$this->title = 'Добавить акцию - I\'m Local';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="event-create">

    <h1 class="h1-create">Добавить акцию</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
