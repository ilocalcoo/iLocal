<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $shopShortNameData app\models\Shop */

$this->title = 'Shops';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Shop', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel, 'shopShortNameData' => $shopShortNameData]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'shopPhoto',
                'value' => function (app\models\Shop $model) {
                    // Html::img('@web/img/shopPhoto/' . $model->shopPhotos->shopPhoto);
                    return $model->shopPhotos->shopPhoto;
                },
                'format' => 'html'
            ],
            'shopShortName',
            [
                'attribute' => 'shopType',
                'value' => function (app\models\Shop $model) {
                    return $model->shopType->type;
                },
            ],
            [
                'attribute' => 'shopAddress',
                'value' => function (app\models\Shop $model) {
                    return $model->shopAddress->city . "," .
                        $model->shopAddress->street . "," .
                        $model->shopAddress->houseNumber;
                },
            ],
            'shopShortDescription',
            //TODO Рейтинг места
            'shopWorkTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
