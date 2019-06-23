<?php

use app\assets\EventAsset;
use app\models\UserEvent;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\Carousel;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\search\EventSearch $searchModel */
/* @var \app\models\Event $shortDescData */
/* @var \app\models\Event $event */
/* @var \app\models\Event[] $events */
/* @var \app\models\EventPhoto[] $photos */
/* @var \app\models\EventPhoto $photo */
/* @var \app\models\Shop[] $shops */

$this->registerCssFile('/css/event/view.css');
$this->registerJsFile('/js/eventsView.js', ['depends' => 'app\assets\AppAsset']);

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
EventAsset::register($this);
?>
<div class="event-index">

    <?php Pjax::begin(); ?>
    <?php
    foreach ($shops as $shop) {
        if (count($shop->getEvents()->asArray()->all()) != 0) { ?>
            <div class="content">
                <div class="cont_title">
                    <a class="shop_img" href="<?= 'shops/' . $shop->shopId ?>" data-pjax="0">
                        <img
                                src="/img/shopPhoto/<?php
                                $shopPhoto = $shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                                if (is_null($shopPhoto)) {
                                    $shopPhoto = '/img/nophoto.jpg';
                                }
                                echo $shopPhoto ?>"
                                alt="<?= $shop->shopShortName ?>"
                        />
                    </a>
                    <div class="cont_right">
                        <a class="shop_name" href="<?= 'shops/' . $shop->shopId ?>" data-pjax="0">
                            <?= $shop->shopShortName ?>
                        </a>
                        <div class="shop_address">
                            <?php
                            $address = 'г. ' . $shop->shopAddress->city . ', ул. ' .
                                $shop->shopAddress->street . ', д. ' .
                                $shop->shopAddress->houseNumber;
                            // TODO доделать отображение корпусов и строений
                            echo $address;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="big_carousel">
                    <?php
                    $events = $shop->getEvents()->all();
                    foreach ($events as $event) {
                        $photos = $event->getTopEventPhotos()->asArray()->all();
                        if (count($photos) == 0) {
                            $photos = [
                                0 => [
                                    'eventPhoto' => '/img/nophoto.jpg'
                                ]
                            ];
                        }
                        ?>
                        <div class="event_card">
                            <div class="card_top">
                                <?php $items = [];
                                foreach ($photos as $photo) {
                                    $content = [
                                        'content' => '<img src="/img/eventPhoto/' . $photo['eventPhoto'] . '">',
                                        'caption' => '<a href="" class="event-view" id="' . $event->id .'" data-pjax="0">' . $event->title . '</a>',
                                    ];
                                    array_push($items, $content);
                                }
                                echo Carousel::widget([
                                    'items' => $items,
                                    'controls' => false,
                                ]);
                                ?>
                            </div>
                            <div class="card_bot">
                                <div class="card_short_desc">
                                    <?= $event->shortDesc ?>
                                </div>
                                <div class="like_data">
                                    <div class="like">

                                        <?php if (Yii::$app->user->isGuest) { ?>
                                            <?php
                                            Modal::begin([
                                                'header' => false,
                                                'toggleButton' => [
                                                    'label' => '<img src="/img/user/Favor_rounded.svg" alt="" class="favorite">',
                                                    'tag' => 'a',
                                                    'class' => 'modal-enter',
                                                ],
                                            ]);
                                            ?>
                                            <div class="modal-enter-body">
                                                <h2>ВХОД</h2>
                                                <p>Войдите, чтобы добавить в избранное!</p>
                                            </div>
                                            <div class="enter-icons">
                                                <?= yii\authclient\widgets\AuthChoice::widget([
                                                    'baseAuthUrl' => ['site/auth'],
                                                    'popupMode' => true,
                                                ]) ?>
                                            </div>
                                            <p class="enter-policy">Продолжая, Вы соглашаетесь с нашими Условиями использования и
                                                подтверждаете, что прочли
                                                <a href="/policy" target="_blank">Политику конфиденциальности</a> .</p>
                                            <?php Modal::end(); ?>
                                        <?php } else { ?>
                                            <?php \yii\widgets\Pjax::begin() ?>
                                            <?php if (UserEvent::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['event_id' => $event->id])->one()) {
                                                $favorite = 'favorite_border_24px_rounded.svg';
                                                $EventId = 'del-event-id';
                                            } else {
                                                $favorite = 'Favor_rounded.svg';
                                                $EventId = 'add-event-id';
                                            } ?>
                                            <a href="/events?<?= $EventId ?>=<?= $event['id'] ?>"
                                               title="Добавить в избранное"
                                               class="favorite">
                                                <img src="/img/user/<?= $favorite ?>" alt=""></a>
                                            <?php \yii\widgets\Pjax::end() ?>
                                        <?php } ?>

                                    </div>
                                    <span>
								<?php $data = $event->begin . '-' . $event->end;
                                echo $data; ?>
								</span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    } ?>
    <div class="pagination">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'nextPageLabel' => '>',
            'prevPageLabel' => '<',
        ]); ?>
    </div>

    <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content event-view-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

</div>
<?php Pjax::end(); ?>




