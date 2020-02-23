<?php

namespace app\model;

use core\lib\Model;

class Collect extends Model
{
    public function checkCollect($username, $article_id)
    {
        return $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    public function addCollect($username, $article_id)
    {
        return $this->table('collect')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    public function cancelCollect($username, $article_id)
    {
        return $this->table('collect')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }
}