<?php

namespace app\model;

use core\lib\Model;

class Share extends Model
{
    public function checkShare($username, $article_id)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->select();
    }

    public function addShare($username, $article_id)
    {
        return $this->table('praise')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    public function cancelShare($username, $article_id)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }

}