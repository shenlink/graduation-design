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
        $user = Factory::createUser();
        $res =  $user->checkUsername($username);
        if ($res) {
            echo "1";
        } else {
            echo "0";
        }
    }


    public function register()
    {
        $view = Factory::createView();
        $view->display('register.html');
    }


    public function login()
    {
        $view = Factory::createView();
        $view->display('login.html');
    }


    public function manage()
    {
        $view = Factory::createView();
        $view->display('manage.html');
    }


    public function checkRegister()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = Factory::createUser();
        $res = $user->register($username, $password);
        $view = Factory::createView();
        $view->display('register.html');
        if ($res) {
            echo '注册成功';
        } else {
            echo '注册失败';
        }
    }


    public function checkLogin()
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

    public function write()
    {
        $view = Factory::createView();
        $view->display('write.html');
    }
}
