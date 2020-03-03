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
        return $this->table('follow')->field('username')->where(['author' => "{$author}"])->order('follow_at desc')->selectAll();
    }

    // 处理确认关注操作
    public function checkFollow($author, $username)
    {
        return $this->table('follow')->where(['author' => "{$author}", 'username' => "{$username}"])->select();
    }

    // 处理关注
    public function addFollow($author, $username, $follow_at)
    {
        $follows = $this->table('follow')->insert(['author' => "{$author}", 'username' => "{$username}", 'follow_at' => "{$follow_at}"]);
        $user =  $this->table('user')->where(['username' => "{$author}"])->update('fans_count = fans_count+1');
        $user2 =  $this->table('user')->where(['username' => "{$username}"])->update('follow_count = follow_count+1');
        return $follows && $user && $user2;
    }

    // 处理取消关注
    public function cancelFollow($author, $username)
    {
        $follows = $this->table('follow')->where(['author' => "{$author}", 'username' => "{$username}"])->delete();
        $user =  $this->table('user')->where(['username' => "{$author}"])->update('fans_count = fans_count-1');
        $user2 =  $this->table('user')->where(['username' => "{$username}"])->update('follow_count = follow_count-1');
        return $follows && $user && $user2;
    }
}
