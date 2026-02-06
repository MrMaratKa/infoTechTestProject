<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \app\models\activeRecords\Subscribes $model */

$this->title = 'Subscribe';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-subscribe">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="authors-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'author_id')->hiddenInput() ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
