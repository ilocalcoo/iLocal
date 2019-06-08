<?php

use kartik\rating\StarRating;
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
                    $photo = [];
                    foreach ($model->shopPhotos as $url) {
                        $photo[] = $url->shopPhoto;
                    }
                    $str = implode(',', $photo);
                    return $str;
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
            [
                'attribute' => 'shopRating',
                'value' => function (app\models\Shop $model) {
                    return StarRating::widget([
                        'name' => 'shop_rating',
                        'value' => $model->shopRating,
                        'language' => 'ru',
                        'pluginOptions' => [
                            'size' => 'md',
                            'stars' => 5,
                            'min' => 0,
                            'max' => 5,
                            'step' => 1,
                            'showClear' => false,
                            'showCaption' => false,
                            'theme' => 'krajee-svg',
                            'filledStar' => '<span class="krajee-icon krajee-icon-star"></span>',
                            'emptyStar' => '<span class="krajee-icon krajee-icon-star"></span>'
                        ],
                        'pluginEvents' => [
                            'rating:change' => "function(event, value, caption){
                                if (". Yii::$app->user->isGuest .") { alert('guest'); return false; }
                                $.ajax({
                                    url:'/shop/rating',
                                    method:'post',
                                    data:{
                                        rating:value,
                                        shopId:". $model->shopId .",
                                        userId:". $model->getUserId() .",
                                    },
                                    dataType:'json',
                                    success:function(data){
                                        location.reload();
                                    }
                                });
                            }"
                        ],
                    ]);
                },
                'format' => 'raw',
            ],
            'shopWorkTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
