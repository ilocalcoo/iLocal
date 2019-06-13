<?php

// Конфиг подключения к БД меняется в зависимости от окружения
if (preg_match('/herokuapp\.com$/', $_SERVER['SERVER_NAME']) ||
    preg_match('/imlocal\.ru$/', $_SERVER['SERVER_NAME'])) {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $host = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $dbname = substr($url["path"], 1);
} else {
    $host = 'localhost';
    $dbname = 'yii2basic';
    $username = 'root';
    $password = '';
}
$dbConfig = [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$host};dbname={$dbname}",
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
return $dbConfig;
