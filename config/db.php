<?php

$dbName = $_ENV['MYSQL_DBNAME'];
$username = $_ENV['MYSQL_USERNAME'];
$password = $_ENV['MYSQL_PASSWORD'];

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=localhost;dbname={$dbName}",
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];
