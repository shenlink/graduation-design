<?php

namespace core\lib\driver\log;

use core\lib\Log;
use core\lib\Config;

// 日志数据库存储方式
class Mysql
{
    private static $mysql;
    public static function getInstance()
    {
        if (self::$mysql) {
            return self::$mysql;
        } else {
            self::$mysql = new self();
            return self::$mysql;
        }
    }

    public function log($message, $type = 'action')
    {
        session_start();
        date_default_timezone_set('PRC');
        $log_at = date('Y-m-d H:i:s', time());
        $config = Config::all('database');
        $type = $config['type'];
        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname'];
        $charset = $config['charset'];
        $dsn = "{$type}:host={$host};charset={$charset};dbname={$dbname}";
        try {
            $pdo = new \PDO($dsn, $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            Log::init();
            session_start();
            if (isset($_SESSION)) {
                $username = $_SESSION['username'];
                Log::log("用户{$username}:" . '数据库连接发生错误:' . $e->getMessage() . "\r\n");
            } else {
                Log::log('数据库连接发生错误:' . $e->getMessage() . "\r\n");
            }
        }
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $message = $log_at . " 用户{$username} " . $message . "\r\n";
            $sql = "insert into log (username,message,type,log_at) values (?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $message);
            $stmt->bindParam(3, $type);
            $stmt->bindParam(4, $log_at);
            $stmt->execute();
        } else {
            $message = $log_at . " 游客guest " . $message . "\r\n";
            $sql = "insert into log (message,type,log_at) values (?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $message);
            $stmt->bindParam(2, $type);
            $stmt->bindParam(3, $log_at);
            $stmt->execute();
        }
    }
}
