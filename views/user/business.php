<?php

/* @var $this yii\web\View */

use app\assets\BusinessAsset;
use yii\helpers\Html;

//$this->registerCssFile('/css/user/business.css');
BusinessAsset::register($this);
/* @var $userShops app\models\Shop */
/* @var $userEvents app\models\Event */
/* @var $userHappenings app\models\Happening */
?>
    <h1 class="business-header">Ваши места</h1>
    <div class="row">
        <?php foreach ($userShops as $shop) { ?>
            <div class="col-6">
                <div class="common-card">
                    <img class="image" src="/img/shopPhoto/<?php if (!isset($shop['shopPhotos'][0]['shopPhoto'])) {
                        echo 'no-photo.png';
                    } else {
                        echo $shop['shopPhotos'][0]['shopPhoto'];
                    } ?>" alt="<?= $shop['shopShortName'] ?>">
                    <div class="middle">
                        <div class="text"><?= $shop['shopShortName'] ?></div>
                    </div>
                    <a href="/shop/create?id=<?= $shop['shopId'] ?>" title="Редактировать" aria-label="Редактировать">
                        <div class="ed-mark">
                            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.3657 3.62835L19.3041 0.566731C18.9244 0.186975 18.4511 0 17.9486 0C17.4461 0 16.9378 0.189897 16.5931 0.566731L14.5423 2.61754C14.1333 2.49192 13.66 2.58539 13.3445 2.86876L12.4623 3.751C12.1146 4.09865 12.0533 4.63324 12.2403 5.07732L2.33093 14.9867C2.29879 15.0188 2.26664 15.051 2.26664 15.0802C2.26664 15.0802 2.26664 15.0802 2.26664 15.1123C2.2345 15.1444 2.2345 15.1766 2.20236 15.2058L0.437878 20.5724L0.247981 21.1391L0.0580844 21.7058C0.0580844 21.738 0.0580844 21.7701 0.0259417 21.7701C-0.0383438 22.0856 0.0259417 22.3368 0.11941 22.4946C0.151553 22.5589 0.183696 22.6202 0.212879 22.6524C0.402776 22.8744 0.686141 23 1.00165 23C1.03379 23 1.06594 23 1.09512 23C1.1594 23 1.18859 23 1.22073 23C1.25287 23 1.28502 23 1.28502 22.9679L2.07379 22.7166L7.75294 20.8557C7.8464 20.8236 7.91069 20.7914 7.97497 20.7301L17.9135 10.7916C18.0391 10.8559 18.1647 10.8559 18.3225 10.8559C18.638 10.8559 18.9214 10.7302 19.1434 10.5082L20.0257 9.62596C20.3733 9.27831 20.4346 8.80505 20.2769 8.39607L22.3277 6.34527C23.1224 5.61782 23.1224 4.38497 22.3657 3.62835ZM7.63032 19.4681L6.02356 17.8584L15.4567 8.39311L17.0664 10.0028L7.63032 19.4681ZM14.6358 7.5722L5.20265 17.0375L3.59296 15.3986L13.0261 5.96544L14.6358 7.5722ZM2.45654 21.3611L1.66777 20.5724L3.02331 16.4708L4.79075 18.2382L6.55819 20.0056L2.45654 21.3611ZM18.5475 9.52954C18.5154 9.49739 18.5154 9.46525 18.4832 9.46525L13.5928 4.54273C13.5286 4.47844 13.4994 4.44926 13.4351 4.41712L14.1304 3.69263L14.1947 3.75692L19.1493 8.71158C19.1815 8.74372 19.2136 8.77587 19.2428 8.77587L18.5475 9.52954ZM21.5448 5.55354L19.5583 7.54009L15.4246 3.37712L17.4111 1.39057C17.6945 1.1072 18.1999 1.1072 18.4833 1.39057L21.5449 4.44926C21.8282 4.76477 21.8282 5.23803 21.5448 5.55354Z" fill="#FCF7F4"></path>
                            </svg>
                        </div>
                    </a>
                    <?= Html::a('<div class="del-mark">
                        <svg width="18" height="23" viewBox="0 0 18 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.1106 2.90092H12.061C11.8031 1.263 10.4231 0 8.72937 0C7.03562 0 5.629 1.263 5.39767 2.90092H1.40659C0.630163 2.90092 0 3.53376 0 4.30751V5.74335C0 6.46128 0.515847 7.03559 1.20718 7.12069V21.1334C1.20718 22.1677 2.03942 23 3.07376 23H14.4727C15.5071 23 16.3393 22.1677 16.3393 21.1334V7.1473C17.028 7.03295 17.5465 6.45864 17.5465 5.76995V4.33412C17.5172 3.53376 16.8844 2.90092 16.1106 2.90092ZM8.72937 1.06358C9.8488 1.06358 10.7688 1.84001 10.9682 2.90092H6.46125C6.68994 1.86659 7.60993 1.06358 8.72937 1.06358ZM15.2491 21.1653C15.2491 21.5961 14.9035 21.9683 14.4461 21.9683H3.04451C2.61377 21.9683 2.24151 21.6227 2.24151 21.1653V7.17919H15.2226V21.1653H15.2491ZM16.4536 5.74335C16.4536 5.94544 16.3101 6.08903 16.108 6.08903H1.40392C1.20183 6.08903 1.05824 5.94544 1.05824 5.74335V4.30751C1.05824 4.10543 1.20183 3.96183 1.40392 3.96183H16.0787C16.2808 3.96183 16.4244 4.10543 16.4244 4.30751V5.74335H16.4536ZM4.62391 19.211V10.1386C4.62391 9.85147 4.85258 9.62278 5.13976 9.62278C5.42695 9.62278 5.65561 9.85145 5.65561 10.1386V19.211C5.65561 19.4982 5.42695 19.7269 5.13976 19.7269C4.8526 19.7587 4.62391 19.4982 4.62391 19.211ZM8.26937 19.211V10.1386C8.26937 9.85147 8.49803 9.62278 8.78522 9.62278C9.07237 9.62278 9.30107 9.85145 9.30107 10.1386V19.211C9.30107 19.4982 9.0724 19.7269 8.78522 19.7269C8.50068 19.7587 8.26937 19.4982 8.26937 19.211ZM11.9174 19.211V10.1386C11.9174 9.85147 12.1461 9.62278 12.4333 9.62278C12.7205 9.62278 12.9491 9.85145 12.9491 10.1386V19.211C12.9491 19.4982 12.7205 19.7269 12.4333 19.7269C12.1754 19.7587 11.9174 19.4982 11.9174 19.211Z" fill="#FCF7F4"></path>
                        </svg>
                    </div>', ['/shops/' . $shop['shopId'] . '/delete'], [
                        'title' => 'Удалить',
                        'aria-label' => 'Удалить',
                        'data' => [
                            'confirm' => 'Вы уверены что хотите удалить место?',
                            'method' => 'post'
                        ],
                    ]) ?>
                    <div class="description text-center"><?= $shop['shopShortDescription'] ?></div>
                </div>
            </div>
        <?php } ?>
    </div>


<div class="flex-wrap">



    <div class="main-block-wrap">
        <div class="add-block">
            <a href="/shop/create" class="add-ellipse"><img src="/img/user/plus-icon.svg" alt=""></a>
        </div>
        <div class="info-block-wrap">
            <a href="/shop/create" class="title">Добавить место</a>
        </div>
    </div>

</div>

<div class="business-line"></div>

<h1 class="business-header">Ваши акции</h1>

<div class="flex-wrap">

    <?php foreach ($userEvents as $event) { ?>
        <div class="main-block-wrap">
            <img src="/img/eventPhoto/<?php if (!isset($event['eventPhotos'][0]['eventPhoto'])) {
                echo 'no-photo.png';
            } else {
                echo $event['eventPhotos'][0]['eventPhoto'];
            } ?>" class="photo" alt="">
            <div class="info-block-wrap">
                <a href="/events/<?= $event['id'] ?>" class="title"><?= $event['title'] ?></a>
                <a href="/event/create?id=<?= $event['id'] ?>" title="Редактировать" aria-label="Редактировать"
                        class="update"><img src="/img/user/contract-btn.svg" alt=""></a>
                <?= Html::a(Html::img('/img/user/delete-btn.svg'), ['/events/' . $event['id'] . '/delete'], [
                    'title' => 'Удалить',
                    'aria-label' => 'Удалить',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить акцию?',
                        'method' => 'post'
                    ],
                ]) ?>
            </div>
        </div>
    <?php } ?>

    <div class="main-block-wrap">
        <div class="add-block">
            <a href="/event/create" class="add-ellipse <?php if (!$userShops) { ?>disabled<?php } ?>"><img src="/img/user/plus-icon.svg" alt=""></a>
        </div>
        <div class="info-block-wrap">
            <a href="/event/create" class="title <?php if (!$userShops) { ?>disabled<?php } ?>">Добавить акцию</a>
        </div>
    </div>
</div>

<div class="business-line"></div>

<h1 class="business-header">Ваши события</h1>

<div class="flex-wrap">

    <?php foreach ($userHappenings as $happening) { ?>
        <div class="main-block-wrap">
            <img src="/img/happeningPhoto/<?php if (!isset($happening['happeningPhotos'][0]['happeningPhoto'])) {
                echo 'no-photo.png';
            } else {
                echo $happening['happeningPhotos'][0]['happeningPhoto'];
            } ?>" class="photo" alt="">
            <div class="info-block-wrap">
                <a href="/happenings/<?= $happening['id'] ?>" class="title"><?= $happening['title'] ?></a>
                <a href="/happening/create?id=<?= $happening['id'] ?>" title="Редактировать" aria-label="Редактировать"
                        class="update"><img src="/img/user/contract-btn.svg" alt=""></a>
                <?= Html::a(Html::img('/img/user/delete-btn.svg'), ['/happenings/' . $happening['id'] . '/delete'], [
                    'title' => 'Удалить',
                    'aria-label' => 'Удалить',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить акцию?',
                        'method' => 'post'
                    ],
                ]) ?>
            </div>
        </div>
    <?php } ?>

    <div class="main-block-wrap">
        <div class="add-block">
            <a href="/happening/create" class="add-ellipse <?php if (!$userShops) { ?>disabled<?php } ?>"><img src="/img/user/plus-icon.svg" alt=""></a>
        </div>
        <div class="info-block-wrap">
            <a href="/happening/create" class="title <?php if (!$userShops) { ?>disabled<?php } ?>">Добавить событие</a>
        </div>
    </div>
</div>



