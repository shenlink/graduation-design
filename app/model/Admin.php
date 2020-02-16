<?php

namespace app\model;

use core\lib\Model;

class Admin extends Model
{
    private static $admin;
    public static function getInstance()
    {
        if (self::$admin) {
            return self::$admin;
        } else {
            self::$admin = new self();
            return self::$admin;
        }
    }
    public function user()
    {
        return $this->table('user')->selectAll();
    }
    public function article()
    {
        return $this->table('article')->selectAll();
    }
    public function category()
    {
        return $this->table('category')->selectAll();
    }
    public function comment()
    {
        return $this->table('comment')->selectAll();
    }
    public function announcement()
    {
        return $this->table('announcement')->selectAll();
    }
}
