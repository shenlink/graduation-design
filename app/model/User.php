<?php

namespace app\model;

use core\lib\Model;

class User extends Model
{
    private static $user;
    public static function getInstance()
    {
        if (self::$user) {
            return self::$user;
        } else {
            self::$user = new self();
            return self::$user;
        }
    }


    public function checkUsername($username)
    {
        // $_POST变量是超全局变量，可以直接在模型类获取表单提交的数据，但是，不提倡这么做，因为本来表单是提交到控制器的，表单传过来的值应该由控制器传到模型类中
        // 这个$this是Model类的对象
        return $this->table('user')->where(array('username' => "{$username}"))->select();
    }

    public function register($username, $password)
    {
        return $this->table('user')->insert(array('username' => "{$username}", 'password' => "{$password}"));
    }

    public function login($username, $password)
    {
        return $this->table('user')->where(array('username' => "{$username}", 'password' => "{$password}"))->select();
    }
}