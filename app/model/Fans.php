<?php

namespace app\model;

use core\lib\Model;

class Fans extends Model
{
    public function checkFans($username, $article_id)
    {
        return $this->table('fans')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    public function addFans($username, $article_id)
    {
        return $this->table('fans')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    public function cancelFans($username, $article_id)
    {
        return $this->table('fans')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }
}