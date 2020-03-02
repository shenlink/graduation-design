<?php

namespace app\model;

use core\lib\Model;

class Follow extends Model
{

    private static $follow;
    public static function getInstance()
    {
        if (self::$follow) {
            return self::$follow;
        } else {
            self::$follow = new self();
            return self::$follow;
        }
    }

    // 获取用户的所有粉丝
    public function getFollow($author)
    {
        return $this->table('follow')->field('username')->where(['author' => "{$author}"])->selectAll();
    }

    // 处理确认关注操作
    public function checkFollow($author, $username)
    {
        return $this->table('follow')->where(['author' => "{$author}", 'username' => "{$username}"])->select();
    }

    // 处理关注
    public function addFollow($author, $username, $follow_at)
    {
        return $this->table('follow')->insert(['author' => "{$author}", 'username' => "{$username}", 'follow_at' => "{$follow_at}"]);
    }

    // 处理取消关注
    public function cancelFollow($author, $username)
    {
        return $this->table('follow')->where(['author' => "{$author}", 'username' => "{$username}"])->delete();
    }
}
