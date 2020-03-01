<?php

namespace app\model;

use core\lib\Model;

class Praise extends Model
{

    public function getPraise($username)
    {
        return $this->table('praise')->field('praise_id,article_id,author,title,praise_at')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理确认点赞操作
    public function checkPraise($username, $article_id)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 处理点赞
    public function addPraise($username, $article_id, $author, $title, $praise_at)
    {
        // 还要有author和title
        return $this->table('praise')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'praise_at' => "{$praise_at}"]);
    }

    // 处理取消点赞
    public function cancelPraise($username, $article_id)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }

    public function delPraise($praise_id)
    {
        return $this->table('praise')->where(['praise_id' => "{$praise_id}"])->delete();
    }
}
