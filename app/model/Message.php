<?php

namespace app\model;

use core\lib\Model;

class Message extends Model
{

    private static $message;
    public static function getInstance()
    {
        if (self::$message) {
            return self::$message;
        } else {
            self::$message = new self();
            return self::$message;
        }
    }

    // 处理用户提交的私信数据
    public function checkAddmessage($author, $content,$username,  $created_at)
    {
        return $this->table('message')->insert(['author' => "{$author}", 'username' => "{$username}", 'content' => "{$content}",'created_at' => "{$created_at}"]);
    }

    // 获取私信信息
    public function getMessage($username)
    {
        return $this->table('message')->field('message_id,username,content')->where(['username' => "{$username}"])->order('created_at desc')->selectAll();
    }

    // 删除私信
    public function delmessage($message_id)
    {
        return $this->table('message')->where(['message_id' => "{$message_id}"])->delete();
    }
}