<?php

namespace app\model;

use core\lib\Model;

class Collect extends Model
{

    public function getCollect($username)
    {
        return $this->table('collect')->field('article_id,author,title,collect_at')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理确认收藏操作
    public function checkCollect($username, $article_id)
    {
        return $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    // 添加收藏
    public function addCollect($username, $article_id)
    {
        return $this->table('collect')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    // 取消收藏
    public function cancelCollect($username, $article_id)
    {
        return $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }
}