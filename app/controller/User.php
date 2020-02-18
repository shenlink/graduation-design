<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;


class User extends Controller
{
    public function checkUsername()
    {
        header("Content-type:text/html;charset=utf-8");
        $username = $_POST['username'];
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

    public function checkRegister()
    {
        header("Content-type:text/html;charset=utf-8");
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = Factory::createUser();
        $res = $user->register($username, $password);
        if ($res) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function checkLogin()
    {
        header("Content-type:text/html;charset=utf-8");
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sevenCheck = $_POST['sevenCheck'];
        $user = Factory::createUser();
        $res = $user->login($username, $password);
        if ($res) {
            if($sevenCheck){
                setcookie('username', $username, time() + 604800);
            }
            session_start();
            $_SESSION['username'] = $username;
            echo '1';
        } else {
            echo '0';
        }
    }

    public function write()
    {
        $view = Factory::createView();
        if(!isset($_SESSION['username'])){
            $view->display('nologin.html');
        }else{
            $view->display('write.html');
        }
    }

    public function checkWrite()
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user = Factory::createUser();
        $res = $user->checkWrite($title,$content);
        if($res){
            echo '1';
        }else{
            echo '0';
        }

    }
}
