<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Article extends Controller
{
    public function search()
    {
        if (isset($_POST['search']) && isset($_POST['name'])) {
            $search = $_POST['search'];
            $name = $_POST['name'];
            $article = Factory::createArticle();
            $data = $article->search($search, $name);
            if ($name == '1') {
                $name = '用户名查询结果';
            } else {
                $name = '文章查询结果';
            }
            $view = Factory::createView();
            $view->assign('name', $name);
            $view->assign('data', $data);
            $view->display('search.html');
        } else {
            echo '404';
        }
    }

    public function index()
    {
        $article = Factory::createArticle();
        $data = $article->index();
        return $data;
    }

    public function php()
    {
        $article = Factory::createArticle();
        $data = $article->php();
        return $data;
    }

    public function mysql()
    {
        $article = Factory::createArticle();
        $data = $article->mysql();
        return $data;
    }

    public function javaScript()
    {
        $article = Factory::createArticle();
        $data = $article->javaScript();
        return $data;
    }

    public function html()
    {
        $article = Factory::createArticle();
        $data = $article->html();
        return $data;
    }

    public function python()
    {
        $article = Factory::createArticle();
        $data = $article->python();
        return $data;
    }

    public function java()
    {
        $article = Factory::createArticle();
        $data = $article->java();
        return $data;
    }

    public function foundation()
    {
        $article = Factory::createArticle();
        $data = $article->foundation();
        return $data;
    }

    public function personal()
    {
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
