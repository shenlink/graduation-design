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

    // 处理确认点赞操作
    public function checkPraise($article_id, $username)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 处理点赞
    public function addPraise($article_id, $author, $title, $username,  $praise_at)
    {
        $praise = $this->table('praise')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'praise_at' => "{$praise_at}"]);
        $article =  $this->table('article')->field('praise_count')->where(['article_id' => "{$article_id}"])->update('praise_count = praise_count+1');
        return $praise && $article;
    }

    // 处理取消点赞
    public function cancelPraise($article_id, $username)
    {
        $praise = $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
        $article =  $this->table('article')->field('praise_count')->where(['article_id' => "{$article_id}"])->update('praise_count = praise_count-1');
        return $praise && $article;
    }

    public function delPraise($article_id, $praise_id)
    {
        $praises = $this->table('praise')->where(['praise_id' => "{$praise_id}"])->delete();
        $articles =  $this->table('article')->where(['article_id' => "{$article_id}"])->update('praise_count = praise_count-1');
        return $praises && $articles;
    }


    public function firstPage($username)
    {
        return $this->table('praise')->field('praise_id,article_id,author,title,praise_at')->where(['username' => "{$username}"])->order('praise_at desc')->pages(1, 5);
    }

    public function getPraise($username, $currentPage=1, $pageSize=5)
    {
        return $this->table('praise')->field('praise_id,article_id,author,title,praise_at')->where(['username' => "{$username}"])->order('praise_at desc')->pages($currentPage, $pageSize);
    }
}
