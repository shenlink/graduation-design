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
        $article = Factory::createArticle();
        $data = $article->php();
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
        $article = Factory::createArticle();
        $data = $article->mysql();
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
        $article = Factory::createArticle();
        $data = $article->javaScript();
        $view = Factory::createView();
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('javaScript.html');
    }

    public function __call($method, $args)
    {
        // 优化思路：分类只用一个HTML文件即可
        $pattern = '/php|mysql|javaScript/i';
        $category = $method;
        if (preg_match($pattern, $category)) {
            $view = Factory::createView();
            $view->display('notfound.html');
            exit();
        }
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
