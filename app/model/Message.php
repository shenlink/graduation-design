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

    public function checkAddmessage($author, $content, $created_at)
    {
        return $this->table('message')->insert(['author' => "{$author}", 'content' => "{$content}",'created_at' => "{$created_at}"]);
    }

    public function delMessage($message_id)
    {
        return $this->table('message')->where(['message_id'=>"{$message_id}"])->delete();
    }

    public function getAllMessage($currentPage = 1, $pageSize = 5)
    {
        return $this->table('message')->order('created_at desc')->pages($currentPage, $pageSize,'message');
    }
}