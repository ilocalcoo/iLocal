<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle"></div>
        <div class="step_form-rectangle"></div>
    </div>
    <?= Alert::widget() ?>
    <h1 class="step_name">Шаг 2: Добавьте изображения</h1>
    <div class="shop-form_photo-info">Вы можете загрузить до 10 фотографий
        <div class="shop-form_photo-info-main">Основное фото</div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uploadedShopPhoto[]', ['options' => ['id' => 'file']])->fileInput(['style' => 'display: none;'])->label(false) ?>
    <div class="shop-form_shop-photos-wrap">
        <?php foreach ($model->shopPhotos as $photo) { ?>
            <div class="shop-form_shop-photos">
                <?= Html::img('/img/shopPhoto/' . ($photo['shopPhoto']), ['class' => 'shop-form_photo']) ?>
                <?= Html::a(Html::img('/img/shop/photo_delete.svg'), ['/shop-photo/delete', 'id' => $photo['id']], [
                    'class' => 'shop-form_photo-delete',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить фотографию?'
                    ],
                ]) ?>
            </div>
        <?php } ?>
        <?php if (!$model->shopPhotos) { ?>
            <div class="shop-form_shop-photos">
                <label for="shop-uploadedshopphoto">
                    <?= Html::img('/img/shopPhoto/default.png', ['class' => 'shop-form_photo']) ?>
                    <?= Html::img('/img/shop/photo_icon.svg', ['class' => 'shop-form_photo-icon']) ?>
                    <span class="shop-form_photo-text">Загрузите фотографии jpg, png</span>
                </label>
            </div>
        <?php } else { ?>
            <div class="shop-form_shop-photos">
                <label for="shop-uploadedshopphoto">
                    <?= Html::img('/img/shopPhoto/default.png', ['class' => 'shop-form_photo']) ?>
                    <?= Html::img('/img/shop/photo_icon_ellipse.svg', ['class' => 'shop-form_photo-icon_ellipse']) ?>
                </label>
            </div>
        <?php } ?>
    </div>
    <div class="step_form-line"></div>

    <div class="form-group step_form-rectangle_btn-wrap">
        <a class="step_form-rectangle_btn-back" href="http://ilocaldev/shop/create?id=<?= $model->shopId ?>">
            <span class="keyboard_arrow_left"></span> Назад</a>
        <a class="step_form-rectangle_btn-next step_form-rectangle_btn-next-a" href="http://ilocaldev/shops/<?= $model->shopId ?>/update/address">Далее
            <img src="/img/shop/createShopBtn/keyboard_arrow_right_24px.svg" alt=""></a>
    </div>


    <?php ActiveForm::end(); ?>

</div>
