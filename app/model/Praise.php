<?php

namespace app\model;

use core\lib\Model;

class Praise extends Model
{
    private static $praise;
    public static function getInstance()
    {
        if (self::$praise) {
            return self::$praise;
        } else {
            self::$praise = new self();
            return self::$praise;
        }
    }

    public function getPraise($username)
    {
        return $this->table('praise')->field('praise_id,article_id,author,title,praise_at')->where(['username' => "{$username}"])->order('praise_at desc')->selectAll();
    }

    // 处理确认点赞操作
    public function checkPraise($username, $article_id)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 处理点赞
    public function addPraise($username, $article_id, $author, $title, $praise_at)
    {
        $praise = $this->table('praise')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'praise_at' => "{$praise_at}"]);
        $article =  $this->table('article')->field('praise_count')->where(['article_id' => "{$article_id}"])->update('praise_count = praise_count+1');
        return $praise && $article;
    }

    // 处理取消点赞
    public function cancelPraise($username, $article_id)
    {
        $praise = $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
        $article =  $this->table('article')->field('praise_count')->where(['article_id' => "{$article_id}"])->update('praise_count = praise_count-1');
        return $praise && $article;
    }

    public function delPraise($praise_id,$article_id)
    {
        $praise = $this->table('praise')->where(['praise_id' => "{$praise_id}"])->delete();
        $article =  $this->table('article')->field('praise_count')->where(['article_id' => "{$article_id}"])->update('praise_count = praise_count-1');
        return $praise && $article;
    }
}
