<?php

use app\models\activeRecords\Books;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \app\models\activeRecords\Books $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) {
        ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                    ],
            ]) ?>
        </p>
        <?php
    }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'release_date',
            'description',
            'isbn',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function(Books $model) {
                    if ($model->img) {
                        return Html::img($model->getImgUrl(), [
                            'style' => 'max-width: 150px; max-height: 150px;',
                            'class' => 'img-thumbnail'
                        ]);
                    }
                    return 'Нет изображения';
                },
            ]
        ],
    ]) ?>

</div>
