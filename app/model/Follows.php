<?php

namespace app\model;

use core\lib\Model;

class Follows extends Model
{
    public function checkFollows($username, $article_id)
    {
        return $this->table('follows')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    public function addFollows($username, $article_id)
    {
        return $this->table('follows')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    public function cancelFollows($username, $article_id)
    {
        return $this->table('follows')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }

}