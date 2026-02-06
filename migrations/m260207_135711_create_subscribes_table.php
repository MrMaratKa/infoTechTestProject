<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribes}}`.
 */
class m260207_135711_create_subscribes_table extends Migration
{
    private string $tableName = '{{%subscribes}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (Yii::$app->db->getTableSchema($this->tableName) === null) {
            $this->createTable('{{%subscribes}}', [
                'author_id' => $this->integer()->notNull(),
                'phone' => $this->string(20)->notNull(),
            ]);

            $this->addPrimaryKey('pk-subscribe', $this->tableName, ['author_id', 'phone']);

            $this->addForeignKey('fk-subscribe-author_id', $this->tableName, 'author_id', '{{%authors}}', 'id', 'CASCADE', 'CASCADE');
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
