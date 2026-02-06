<?php
/** @var yii\web\View $this */
/** @var \app\models\forms\ReportForm $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
    ]); ?>

    <?= $form->field($searchModel, 'year')->textInput(['type' => 'number', 'min' => 1000, 'max' => 9999]) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'fio'
            ],
    ]); ?>
</div>
