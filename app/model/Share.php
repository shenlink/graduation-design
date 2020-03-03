<?php

namespace app\model;

use core\lib\Model;

class Share extends Model
{
    private static $share;
    public static function getInstance()
    {
        if (self::$share) {
            return self::$share;
        } else {
            self::$share = new self();
            return self::$share;
        }
    }

    public function getShare($username)
    {
        return $this->table('share')->field('share_id,article_id,author,title,share_at')->where(['username' => "{$username}"])->order('share_at desc')->selectAll();
    }

    // 处理确认分享操作,这应该只传入一个id就可以了
    public function checkShare($username, $article_id)
    {
        return $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 处理分享
    public function addShare($username, $article_id, $author, $title, $share_at)
    {
        $share = $this->table('share')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'share_at' => "{$share_at}"]);
        $article =  $this->table('article')->field('share_count')->where(['article_id' => "{$article_id}"])->update('share_count = share_count+1');
        return $share && $article;
    }

    // 处理取消分享
    public function cancelShare($username, $article_id)
    {
        $share = $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
        $article =  $this->table('article')->field('share_count')->where(['article_id' => "{$article_id}"])->update('share_count = share_count+1');
        return $share && $article;
    }

    public function delShare($share_id, $article_id)
    {
        $share = $this->table('share')->where(['share_id' => "{$share_id}"])->delete();
        $article =  $this->table('article')->field('share_count')->where(['article_id' => "{$article_id}"])->update('share_count = share_count+1');
        return $share && $article;
    }
}
