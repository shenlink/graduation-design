<?php

namespace app\model;

use core\lib\Model;

class Follows extends Model
{

    // 获取用户的所有粉丝
    public function getFollows($author)
    {
        return $this->table('follows')->field('username')->where(['author' => "{$author}"])->selectAll();
    }

    // 处理确认关注操作
    public function checkFollows($author, $username)
    {
        return $this->table('follows')->where(['author' => "{$author}", 'username' => "{$username}"])->select();
    }

    // 处理关注
    public function addFollows($author, $username)
    {
        return $this->table('follows')->insert(['author' => "{$author}", 'username' => "{$username}"]);
    }

    // 处理取消关注
    public function cancelFollows($author, $username)
    {
        return $this->table('follows')->where(['author' => "{$author}", 'username' => "{$username}"])->delete();
    }

}