<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;


class Category extends Controller
{
    // 显示分类下的php分类
    public function php()
    {
        $access = Validate::checkAccess();
        if($access == 1 || $access == 2){
            $username = $_SESSION['username'];
        }
        $article = Factory::createArticle();
        $data = $article->php();
        $recommend = $article->recommend();
        $view = Factory::createView();
        $view->assign('recommend',$recommend);
        $view->assign('username',$username);
        $view->assign('data', $data);
        $view->display('php.html');
    }

    // 显示分类下的mysql分类
    public function mysql()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $article = Factory::createArticle();
        $data = $article->mysql();
        $recommend = $article->recommend();
        $view = Factory::createView();
        $view->assign('recommend', $recommend);
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('mysql.html');
    }

    // 显示分类下的javaScript分类
    public function javaScript()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $article = Factory::createArticle();
        $data = $article->javaScript();
        $recommend = $article->recommend();
        $view = Factory::createView();
        $view->assign('recommend', $recommend);
        $view->assign('username', $username);
        $view->assign('data', $data);
        $view->display('javaScript.html');
    }

    // 当用户访问不存在的分类时，提示404页面
    public function __call($method, $args)
    {
        // 优化思路：分类只用一个HTML文件即可
        $pattern = '/php|mysql|javaScript/i';
        $category = $method;
        $view = Factory::createView();
        if (preg_match($pattern, $category)) {
            $view->display('notfound.html');
            exit();
        }
        $view->display('notfound.html');
    }
}
