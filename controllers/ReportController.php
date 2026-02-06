<?php

namespace app\controllers;

use app\models\activeRecords\Authors;
use app\models\forms\ReportForm;
use DateTime;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;

class ReportController extends \yii\web\Controller
{
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['?', '@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Возвращает топ авторов за указанный год
     *
     * @throws \Exception
     */
    public function actionIndex(): string
    {
        $topAuthors = [];

        $searchModel = new ReportForm();
        if ($searchModel->load($this->request->queryParams) && $searchModel->validate()) {
            $topAuthors = Authors::getTopAuthorsList($searchModel);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $topAuthors,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

}
