<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_book}}`.
 */
class m260207_125049_create_author_book_table extends Migration
{
    private string $tableName = '{{%author_book}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (Yii::$app->db->getTableSchema($this->tableName) === null) {
            $this->createTable($this->tableName, [
                'book_id' => $this->integer()->notNull(),
                'author_id' => $this->integer()->notNull(),
            ]);

            $this->addPrimaryKey('pk-author_book', $this->tableName, ['author_id', 'book_id']);

            $this->createIndex('idx_author_book_book_id', $this->tableName, 'book_id');
            $this->createIndex('idx_author_book_author_id', $this->tableName, 'author_id');

            $this->addForeignKey('fk-author_book-book_id', $this->tableName, 'book_id', '{{%books}}', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk-author_book-author_id', $this->tableName, 'author_id', '{{%authors}}', 'id', 'CASCADE', 'CASCADE');
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
