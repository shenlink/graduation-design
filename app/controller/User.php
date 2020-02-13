<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;
// 优化建议：把user的实例化挂在注册树上，因为user被多次实例化了

class User extends Controller
{
    public function checkUsername()
    {
        header("Content-type:text/html;charset=utf-8");
        $username = $_POST['usernameValue'];
        $user = new \app\model\User();
        $res =  $user->checkUsername($username);
        if ($res) {
            echo "1";
        } else {
            echo "0";
        }
    }
    public function register()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // $view = Factory::createView();
        $user = new \app\model\User();
        $res = $user->register($username, $password);
        if ($res) {
            echo '注册成功';
        } else {
            echo '注册失败';
        }
    }
    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = new \app\model\User();
        $res = $user->login($username, $password);
        if ($res) {
            echo '登录成功';
        } else {
            echo '登录失败';
        }
    }
}
