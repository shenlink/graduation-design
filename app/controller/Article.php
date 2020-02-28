<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Article extends Controller
{

    // 搜索相关操作的方法
    public function search()
    {
        // 用工厂类实例化View类
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

    // 当用户在URL中输入/article/之后的是数字时调用该方法
    public function __call($method, $args)
    {
        $view = Factory::createView();
        if (is_numeric($method)) {
            $article_id = $method;
            $article = Factory::createArticle();
            $article = $article->getArticle($article_id);
            $comment = new \app\model\Comment();
            $comment = $comment->getComment($article_id);
            if ($article) {
                $access = Validate::checkAccess();
                if ($access == 1 || $access == 2) {
                    $username = $_SESSION['username'];
                }
                $view->assign('comment',$comment);
                $view->assign('username', $username);
                $view->assign('article', $article);
                $view->display('article.html');
            } else {
                $view->display('notfound.httml');
            }
        } else {
            $view->display('notfound.httml');
        }
    }
}
