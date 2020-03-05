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






    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstPage()
    {
        return $this->table('message')->order('created_at desc')->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changePage($currentPage, $pageSize)
    {
        return $this->table('article')->order('created_at desc')->pages($currentPage, $pageSize);
    }
}