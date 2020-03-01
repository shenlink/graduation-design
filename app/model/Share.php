<?php

namespace app\model;

use core\lib\Model;

class Share extends Model
{

    public function getShare($username)
    {
        return $this->table('share')->field('share_id,article_id,author,title,share_at')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理确认分享操作,这应该只传入一个id就可以了
    public function checkShare($username, $article_id, $author, $title)
    {
        return $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}"])->select();
    }

    // 处理分享
    public function addShare($username, $article_id, $author, $title, $share_at)
    {
        return $this->table('share')->insert(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'share_at' => "{$share_at}"]);
    }

    // 处理取消分享,这应该只传入一个id就可以了，这与下面的合并成一个方法
    public function cancelShare($username, $article_id, $author, $title)
    {
        return $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}"])->delete();
    }

    public function delShare($share_id)
    {
        return $this->table('share')->where(['share_id' => "{$share_id}"])->delete();
    }
}
