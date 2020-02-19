<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;
use app\controller\Validate;


class User extends Controller
{
    public function checkUsername()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $user = Factory::createUser();
            $res =  $user->checkUsername($username);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo '404';
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
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $user = Factory::createUser();
            if (isset($username) && isset($password)) {
                $res = $user->register($username, $password);
            }
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $view = Factory::createView();
            $view->display('notfound.html');
        }
    }

    public function checkLogin()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $sevenCheck = $_POST['sevenCheck'];
            $user = Factory::createUser();
            if (isset($username) && isset($password)) {
                $res = $user->login($username, $password);
            }
            if ($res) {
                if ($sevenCheck) {
                    setcookie('username', $username, time() + 604800);
                }
                session_start();
                $_SESSION['username'] = $username;
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $view = Factory::createView();
            $view->display('notfound.html');
        }
    }

    public function write()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1' || $access == '2') {
            $view->display('write.html');
        } else {
            $view->display('nologin.html');
        }
    }

    public function checkWrite()
    {
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $user = Factory::createUser();
            $res = $user->checkWrite($title, $content);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $view = Factory::createView();
            $view->display('notfound.html');
        }
    }

    public function personal()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $article = new \app\controller\Article();
            $data = $article->personal($username);
            $user = Factory::createUser();
            $user = $user->personal($username);
            $view->assign('data', $data);
            $view->assign('user', $user);
            $view->display('personal.html');
        } else {
            $view->display('nologin.html');
        }
    }

    public function __call($method, $args)
    {
        $username = $method;
        $view = Factory::createView();
        $user = Factory::createUser();
        $username = $user->getUsername($username);
        if (!$username) {
            $view->display('notfound.html');
            exit();
        }
        $access = Validate::checkAccess();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $article = new \app\controller\Article();
            $data = $article->personal($username);
            $user = Factory::createUser();
            $user = $user->personal($username);
            $view->assign('data', $data);
            $view->assign('user', $user);
            $view->display('personal.html');
        } else {
            $view->display('nologin.html');
        }
    }
}
