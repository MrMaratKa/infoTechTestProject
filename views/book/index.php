<?php

use app\models\activeRecords\Books;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \app\models\searches\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) {
        ?>
        <p>
            <?= Html::a('Create Books', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php
    }
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'release_date',
            'description',
            'isbn',
            [
                'attribute' => 'author_id',
                'format' => 'html',
                'value' => function (Books $model) {
                    return Html::ul(ArrayHelper::map($model->authors, 'id', 'fio'));
                }
            ],
            [
                'attribute' => 'img',
                'format' => 'html',
                'value' => function(Books $model) {
                    return Html::img($model->getImgUrl(), [
                            'style' => 'max-width: 150px; max-height: 150px;',
                            'class' => 'img-thumbnail'
                    ]);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Books $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'update' => !Yii::$app->user->isGuest,
                    'delete' => !Yii::$app->user->isGuest,
                ],
            ],
        ],
    ]); ?>


</div>
