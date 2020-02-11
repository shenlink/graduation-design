<?php



$type = 'mysql';
$host = 'loalhost';
$dbname = 'shen';
$dsn = '{$type}:host={$host};dbname={$dbname}';
$username = 'shen';
$password = 'shen1004';
$charset = 'utf8';
return array(
    $dsn=>['mysql:host=localhost;dbname=test'],
    'username' => $username,
    'password' => $password,
    'charset' => $charset
);
