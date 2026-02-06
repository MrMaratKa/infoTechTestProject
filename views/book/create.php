<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \app\models\activeRecords\Books $model */
/** @var array $authors */

$this->title = 'Create Books';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>

</div>
