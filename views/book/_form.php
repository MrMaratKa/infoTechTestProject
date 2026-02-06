<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \app\models\activeRecords\Books $model */
/** @var array $authors */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'release_date')->widget(DatePicker::className(), [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
    ]) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['type' => 'number', 'min' => 1000000000000, 'max' => 9999999999999]) ?>

    <?= $form->field($model, 'authorIds')->dropDownList($authors, ['multiple' => true, 'selected' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?php if (!$model->isNewRecord && $model->img): ?>
        <div class="form-group">
            <label>Текущее изображение</label><br>
            <img src="<?= $model->getImgUrl() ?>" alt="Обложка" style="max-width: 200px;">
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
