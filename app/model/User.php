<?php

namespace app\model;

use core\lib\Model;

class User extends Model
{
    public function checkName()
    {
        header("Content-type:text/html;charset=utf-8");
        $username = $_POST['usernameValue'];
        return $this->table('user')->where(array('username' => "{$username}"))->select();
    }
    public function register()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        return $this->table('user')->where(array('username' => "{$username}", 'password' => "{$password}"))->select();
    }
    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        return $this->table('users')->where(array('username' => "{$username}", 'password' => '{$password}'))->select();
    }
}