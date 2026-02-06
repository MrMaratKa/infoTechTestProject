<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m260207_124214_create_book_table extends Migration
{
    private string $tableName = '{{%books}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (Yii::$app->db->getTableSchema($this->tableName) === null) {
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull()->comment('Название книги'),
                'release_date' => $this->date()->notNull()->comment('Год выпуска'),
                'description' => $this->string(255)->notNull()->comment('Описание'),
                'isbn' => $this->bigInteger()
                    ->check('isbn BETWEEN 1000000000000 AND 9999999999999')
                    ->notNull()
                    ->comment('Isbn'),
                'img' => $this->string(255)->notNull()->comment('Фото главной страницы'),
            ]);

            $this->createIndex('idx_book_release_date', $this->tableName, 'release_date');

            $this->addCommentOnTable($this->tableName, 'Книги');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (Yii::$app->db->getTableSchema($this->tableName) !== null) {
            $this->dropTable($this->tableName);
        }
    }
}
