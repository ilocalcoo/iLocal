<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerCssFile('/css/event/create/form.css');
/* @var $this yii\web\View */
/* @var $model app\models\Happening */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
    </div>
    <h1 class="step_name">Шаг 2: Добавьте изображения</h1>
    <div class="shop-form_photo-info">Вы можете загрузить до трех фотографий
        <div class="shop-form_photo-info-main">Основное фото</div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uploadedHappeningPhoto[]')->fileInput(['style' => 'display: none;'])->label(false) ?>
    <div class="shop-form_shop-photos-wrap">
        <?php foreach ($model->happeningPhotos as $photo) { ?>
            <div class="shop-form_shop-photos">
                <?= Html::img('/img/happeningPhoto/' . ($photo['happeningPhoto']), ['class' => 'shop-form_photo']) ?>
                <?= Html::a(Html::img('/img/shop/photo_delete.svg'), ['/happening-photo/delete', 'id' => $photo['id']], [
                    'class' => 'shop-form_photo-delete',
                    'data' => [
                        'confirm' => 'Вы уверены что хотите удалить фотографию?'
                    ],
                ]) ?>
            </div>
        <?php } ?>
        <?php if (!$model->happeningPhotos) { ?>
            <div class="shop-form_shop-photos">
                <label for="event-uploadedeventphoto">
                    <?= Html::img('/img/shopPhoto/default.png', ['class' => 'shop-form_photo']) ?>
                    <?= Html::img('/img/shop/photo_icon.svg', ['class' => 'shop-form_photo-icon']) ?>
                    <span class="shop-form_photo-text">Загрузите фотографии jpg, png</span>
                </label>
            </div>
        <?php } else { ?>
            <div class="shop-form_shop-photos">
                <label for="event-uploadedeventphoto">
                    <?= Html::img('/img/shopPhoto/default.png', ['class' => 'shop-form_photo']) ?>
                    <?= Html::img('/img/shop/photo_icon_ellipse.svg', ['class' => 'shop-form_photo-icon_ellipse']) ?>
                </label>
            </div>
        <?php } ?>
    </div>
    <div class="step_form-line"></div>

    <div class="form-group step_form-rectangle_btn-wrap">
        <a class="step_form-rectangle_btn-back" href="/happenings/<?= $model->id ?>/update/info">
            <span class="keyboard_arrow_left"></span> Назад</a>
        <a class="step_form-rectangle_btn-next step_form-rectangle_btn-next-a" href="/user/business">Разместить </a>
    </div>


    <?php ActiveForm::end(); ?>

</div>
