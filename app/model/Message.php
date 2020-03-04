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
    public function checkAddmessage($author, $content, $created_at)
    {
        return $this->table('message')->insert(['author' => "{$author}", 'content' => "{$content}",'created_at' => "{$created_at}"]);
    }

    // 删除私信
    public function delMessage($message_id)
    {
        return $this->table('message')->where(['message_id'=>"{$message_id}"])->delete();
    }

    public function getAllMessage()
    {
        return $this->table('message')->order('created_at desc')->selectAll();
    }
}