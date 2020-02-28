<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;


class Category extends Controller
{
    
    public function __call($method, $args)
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $categoryName = $method;
        $category = Factory::createCategory();
        $view = Factory::createView();
        $realCategory = $category->checkCategory($categoryName);
        if (!$realCategory) {
            $view->display('notfound.html');
            exit();
        }
        $article = Factory::createArticle();
        $articles = $category->getArticle($categoryName);
        $recommend = $article->recommend();
        $view->assign('categoryName',$categoryName);
        $view->assign('recommend', $recommend);
        $view->assign('username', $username);
        $view->assign('articles', $articles);
        $view->display('category.html');
    }
}
