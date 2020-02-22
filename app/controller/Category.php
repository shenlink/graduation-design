<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;


class Category extends Controller
{
    public function php()
    {
        $access = Validate::checkAccess();
        if($access == 1 || $access == 2){
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->php();
        $view = Factory::createView();
        $view->assign('username',$username);
        $view->assign('data', $data);
        $view->display('php.html');
    }

    public function mysql()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->mysql();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('mysql.html');
    }

    public function javaScript()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->javaScript();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('javaScript.html');
    }

    public function html()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->html();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('html.html');
    }
    public function python()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->python();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('python.html');
    }
    public function java()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->java();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('java.html');
    }

    public function foundation()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $category = Factory::createCategory();
        $data = $category->foundation();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('foundation.html');
    }

    public function __call($method, $args)
    {
        // 优化思路：分类只用一个HTML文件即可
        // $pattern = '/php|mysql|javaScript|html|python|java|foundation/i';
        // $category = $method;
        // if (preg_match($pattern, $category)) {
        //     $view = Factory::createView();
        //     $view->display('notfound.html');
        //     exit();
        // }
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
