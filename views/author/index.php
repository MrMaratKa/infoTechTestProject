<?php

use app\models\activeRecords\Authors;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \app\models\searches\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) {
        ?>
        <p>
            <?= Html::a('Create Authors', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php
    }
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fio',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {subscribe}',
                'buttons' => [
                    'subscribe' => function ($url, $model, $key) {
                        $url = Url::to(['author/subscribe', 'id' => $model->id]);
                        return Html::a('Subscribe', $url);
                    },
                ],
                'visibleButtons' => [
                    'update' => !Yii::$app->user->isGuest,
                    'delete' => !Yii::$app->user->isGuest,
                ],
                'urlCreator' => function ($action, Authors $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
