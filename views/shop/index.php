<?php

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $shops app\models\Shop[] */
/* @var $pages \yii\data\Pagination */
/* @var $shopType \app\models\ShopType */

$type = 'Все магазины';
if (count(Yii::$app->request->queryParams) != 0) {
    $shopType = \app\models\ShopType::find()->where(['id' => Yii::$app->request->queryParams['shopTypeId']])->one();
	$type = $shopType->type;
}
$type = mb_strtoupper(mb_substr($type, 0, 1)) . mb_substr($type, 1, mb_strlen($type));
$this->title = $type;
?>
<div class="shop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

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
                                if (". $model->myIsGuest() .") { alert('guest'); return false; }
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
        ],
    ]);

    <?php Pjax::end(); ?>

</div>
