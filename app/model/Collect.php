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

    public function getCollect($username, $currentPage=1, $pageSize=5)
    {
        return $this->table('collect')->field('collect_id,article_id,author,title,collect_at')->where(['username' => "{$username}"])->order('collect_at desc')->pages($currentPage, $pageSize, 'collect');
    }

    // 处理确认收藏操作
    public function checkCollect($username, $article_id)
    {
        return $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 添加收藏
    public function addCollect( $article_id, $author, $title,$username, $collect_at)
    {
        $collects = $this->table('collect')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'collect_at' => "{$collect_at}"]);
        $articles =  $this->table('article')->field('collect_count')->where(['article_id' => "{$article_id}"])->update('collect_count = collect_count+1');
        return $collects && $articles;
    }

    // 取消收藏
    public function cancelCollect( $article_id,$username)
    {
        $collects = $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
        $articles =  $this->table('article')->field('collect_count')->where(['article_id' => "{$article_id}"])->update('collect_count = collect_count-1');
        return $collects && $articles;
    }

    public function delCollect($article_id, $collect_id)
    {
        $collects = $this->table('collect')->where(['collect_id' => "{$collect_id}"])->delete();
        $articles =  $this->table('article')->field('collect_count')->where(['article_id' => "{$article_id}"])->update('collect_count = collect_count-1');
        return $collects && $articles;
    }
}
