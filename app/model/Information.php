<?php

namespace app\model;

use core\lib\Model;

class Information extends Model
{

    private static $information;
    public static function getInstance()
    {
        if (self::$information) {
            return self::$information;
        } else {
            self::$information = new self();
            return self::$information;
        }
    }

    // 处理用户提交的私信数据
    public function checkAddInformation($author, $username, $content, $created_at)
    {
        return $this->table('information')->insert(['author' => "{$author}", 'username' => "{$username}", 'content' => "{$content}",'created_at' => "{$created_at}"]);
    }

    // 获取私信信息
    public function getInformation($username)
    {
        return $this->table('information')->field('information_id,username,content')->where(['username' => "{$username}"])->order('created_at desc')->selectAll();
    }

    // 删除私信
    public function delInformation($information_id)
    {
        return $this->table('information')->where(['information_id' => "{$information_id}"])->delete();
    }
}