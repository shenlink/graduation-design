<?php

namespace app\model;

use core\lib\Model;

class Fans extends Model
{
    public function checkFans($author, $username)
    {
        return $this->table('fans')->where(['author' => "{$author}",'username' => "{$username}" ])->select();
    }

    public function addFans($author, $username)
    {
        return $this->table('fans')->insert(['author' => "{$author}",'username' => "{$username}"]);
    }

    public function cancelFans($author, $username)
    {
        return $this->table('fans')->where(['author' => "{$author}", 'username' => "{$username}"])->delete();
    }
}