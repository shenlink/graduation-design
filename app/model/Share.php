<?php

namespace app\model;

use core\lib\Model;

class Share extends Model
{
    // 处理确认分享操作
    public function checkShare($username, $article_id)
    {
        return $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 处理分享
    public function addShare($username, $article_id)
    {
        return $this->table('share')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    // 处理取消分享
    public function cancelShare($username, $article_id)
    {
        return $this->table('share')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }

}