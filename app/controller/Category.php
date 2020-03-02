<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;
use app\controller\Validate;

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
        $categorys = $category->getCategory();
        $recommends = $article->recommend();
        $view->assign('username', $username);
        $view->assign('articles', $articles);
        $view->assign('categorys', $categorys);
        $view->assign('categoryName',$categoryName);
        $view->assign('recommends', $recommends);
        $view->display('category.html');
    }
}
