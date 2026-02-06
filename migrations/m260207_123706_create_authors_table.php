<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m260207_123706_create_authors_table extends Migration
{
    private string $tableName = '{{%authors}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (Yii::$app->db->getTableSchema($this->tableName) === null) {
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'fio' => $this->string(255)->notNull()->comment('ФИО'),
            ]);

            $this->addCommentOnTable($this->tableName, 'Авторы');
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
