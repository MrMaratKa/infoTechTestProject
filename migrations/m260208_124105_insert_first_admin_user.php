<?php

use app\models\activeRecords\User;
use yii\db\Migration;

class m260208_124105_insert_first_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $admin = new User();
        $admin->username = 'admin';
        $admin->email = 'admin@admin.ru';
        $admin->status = User::STATUS_ACTIVE;
        $admin->setPassword('admin');
        $admin->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
