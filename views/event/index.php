<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\search\EventSearch $searchModel */
/* @var \app\models\Event $shortDescData */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
		<?php echo $this->render('_search', ['model' => $searchModel, 'shortDescData' => $shortDescData]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => \app\models\Event::RELATION_EVENT_PHOTOS,
                'value' => function (app\models\Event $model) {
                    // Html::img('@web/img/eventPhoto/' . $model->eventPhoto->eventPhoto);
                    return $model->eventPhotos->eventPhoto;
                },
                'format' => 'html'
            ],
            'isEventTop',
            [
                'attribute' => \app\models\Event::RELATION_EVENT_TYPE,
                'value' => function (app\models\Event $model) {
                    return $model->eventType->type;
                },
            ],
            [
                'attribute' => \app\models\Event::RELATION_EVENT_SHOP,
                'value' => function (app\models\Event $model) {
                    return $model->eventOwner->shopShortName;
                },
            ],
            [
                'attribute' => 'title',
                'value' => function (app\models\Event $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html'
            ],
            'shortDesc',
            'fullDesc:ntext',
            'begin:datetime',
            'end:datetime',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
