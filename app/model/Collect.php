<?php

namespace app\model;

use core\lib\Model;

class Collect extends Model
{
    private static $collect;
    public static function getInstance()
    {
        if (self::$collect) {
            return self::$collect;
        } else {
            self::$collect = new self();
            return self::$collect;
        }
    }

    public function getCollect($username)
    {
        return $this->table('collect')->field('collect_id,article_id,author,title,collect_at')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理确认收藏操作
    public function checkCollect($username, $article_id)
    {
        return $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 添加收藏
    public function addCollect($username, $article_id, $author, $title, $collect_at)
    {
        return $this->table('collect')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}",'collect_at'=>"{$collect_at}"]);
    }

    // 取消收藏
    // 取消收藏能简单点吗
    public function cancelCollect($username, $article_id)
    {
        return $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }


    public function delCollect($collect_id)
    {
        return $this->table('collect')->where(['collect_id' => "{$collect_id}"])->delete();
    }

}