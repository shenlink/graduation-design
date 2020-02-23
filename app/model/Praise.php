<?php

namespace app\model;

use core\lib\Model;

class Praise extends Model
{

    public function checkPraise($username,$article_id)
    {
        return $this->table('praise')->where(['username'=>"{$username}",'article_id'=>"{$article_id}"])->select();
    }

    public function addPraise($username, $article_id)
    {
        return $this->table('praise')->insert(['username' => "{$username}", 'article_id' => "{$article_id}"]);
    }

    public function cancelPraise($username, $article_id)
    {
        return $this->table('praise')->where(['username' => "{$username}", 'article_id' => "{$article_id}"])->delete();
    }
}