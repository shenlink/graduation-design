<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Article extends Controller
{
    public function prevent()
    {
        $pattern = '/(article)|php|mysql|javascript|html|python|java|foundation|prevent/i';
        $url = $_SERVER['REQUEST_URI'];
        if (preg_match($pattern, $url)) {
            $view = Factory::createView();
            $view->display('notfound.html');
            exit();
        }
    }
    public function search()
    {
        $view = Factory::createView();
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
            $view->assign('name', $name);
            $view->assign('data', $data);
            $view->display('search.html');
        } else {
            $view->display('notfound.html');
        }
    }

    public function index()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->index();
        return $data;
    }

    public function php()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->php();
        return $data;
    }

    public function mysql()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->mysql();
        return $data;
    }

    public function javaScript()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->javaScript();
        return $data;
    }

    public function html()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->html();
        return $data;
    }

    public function python()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->python();
        return $data;
    }

    public function java()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->java();
        return $data;
    }

    public function foundation()
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->foundation();
        return $data;
    }

    public function personal($username)
    {
        $this->prevent();
        $article = Factory::createArticle();
        $data = $article->personal($username);
        return $data;
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        if (is_numeric($method)) {
            $article_id = $method;
            $article = Factory::createArticle();
            $data = $article->getArticle($article_id);
            if ($data) {
                $category = $data['category_id'];
                switch ($category) {
                    case "1":
                        $category = 'php';
                        break;
                    case "2":
                        $category = 'mysql';
                        break;
                    case "3":
                        $category = 'javaScript';
                        break;
                    case "4":
                        $category = 'html';
                        break;
                    case "5":
                        $category = 'python';
                        break;
                    case "6":
                        $category = 'java';
                        break;
                    case "7":
                        $category = '计算机基础';
                        break;
                }
                $view->assign('category', $category);
                $view->assign('data', $data);
                $view->display('article.html');
            } else {
                $view->display('notfound.httml');
            }
        } else {
            $view->display('notfound.httml');
        }
    }
}
