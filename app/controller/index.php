<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    // 显示首页
    public function index()
    {
        session_start();
        $view = Factory::createView();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }
        $article = Factory::createArticle();
        $recommend = $article->recommend();
        if (isset($_POST['currentPage'])) {
            $currentPage = $_POST['currentPage'];
            $index = new \app\model\Index();
            $data = $index->mutativePage($currentPage, 5);
            $article = $data['data'];
            $pageHtml = $data['pageHtml'];
            $view->assign('recommend', $recommend);
            $view->assign('pageHtml', $pageHtml);
            $view->assign('username', $username);
            $view->assign('article', $article);
            $view->display('index.html');
        } else {
            $index = new \app\model\Index();
            $data = $index->pagination();
            $article = $data['data'];
            $pageHtml = $data['pageHtml'];
            $view->assign('recommend', $recommend);
            $view->assign('pageHtml', $pageHtml);
            $view->assign('username', $username);
            $view->assign('article', $article);
            $view->display('index.html');
        }
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
