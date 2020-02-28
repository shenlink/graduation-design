<?php

namespace app\model;

use core\lib\Model;

class Praise extends Model
{

    // 处理确认点赞操作
    public function checkPraise($username,$article_id)
    {
        return $this->table('praise')->where(['username'=>"{$username}",'article_id'=>"{$article_id}"])->select();
    }

    // 处理点赞
    public function addPraise($username, $article_id)
    {
        return $this->table('praise')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    // 处理取消点赞
    public function cancelPraise($username, $article_id)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }
}