<?php

namespace app\model;

use core\lib\Model;

class Follows extends Model
{

    public function getFollows($author)
    {
        return $this->table('follows')->field('username')->where(['author' => "{$author}"])->selectAll();
    }

    public function checkFollows($author, $username)
    {
        return $this->table('follows')->where(['author' => "{$author}", 'username' => "{$username}"])->select();
    }

    public function addFollows($author, $username)
    {
        return $this->table('follows')->insert(['author' => "{$author}", 'username' => "{$username}"]);
    }

    public function cancelFollows($author, $username)
    {
        return $this->table('follows')->where(['author' => "{$author}", 'username' => "{$username}"])->delete();
    }

}