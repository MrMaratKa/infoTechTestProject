<?php

use yii\db\Migration;

class m260207_170938_create_book_image_dir extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $basePath = Yii::$app->basePath;
        $uploadDir =  "{$basePath}/web/uploads/books";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    }
}
