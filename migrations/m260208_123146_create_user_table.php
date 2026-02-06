<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m260208_123146_create_user_table extends Migration
{
    private string $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (Yii::$app->db->getTableSchema($this->tableName) === null) {
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'username' => $this->string()->notNull(),
                'auth_key' => $this->string(32),
                'email_confirm_token' => $this->string(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string(),
                'email' => $this->string()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(0),
            ]);

            $this->createIndex('idx-user-username', $this->tableName, 'username', true);
            $this->createIndex('idx-user-email', $this->tableName, 'email', true);
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
