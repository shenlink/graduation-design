<?php

namespace app\model;

use core\lib\Model;

class Share extends Model
{

    public function getShare($username)
    {
        return $this->table('share')->field('article_id,author,title,share_at')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理确认分享操作
    public function checkShare($username, $article_id, $author, $title)
    {
        return $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}"])->select();
    }

    // 处理分享
    public function addShare($username, $article_id, $author, $title)
    {
        return $this->table('share')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}"]);
    }

    // 处理取消分享
    public function cancelShare($username, $article_id, $author, $title)
    {
        return $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}"])->delete();
    }

}