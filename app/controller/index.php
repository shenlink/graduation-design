<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    // 显示首页
    public function index()
    {
        // 太冗余了
        session_start();
        $view = Factory::createView();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }
        $article = Factory::createArticle();
        $recommend = $article->recommend();
        $category = Factory::createCategory();
        $category = $category->getCategory();
        if (isset($_POST['currentPage'])) {
            $currentPage = $_POST['currentPage'];
            $index = new \app\model\Index();
            $data = $index->mutativePage($currentPage, 5);
            $article = $data['data'];
            $pageHtml = $data['pageHtml'];
            $announcement = new \app\model\Announcement();
            $announcement = $announcement->getAnnouncement();
            $view->assign('announcement', $announcement);
            $view->assign('recommend', $recommend);
            $view->assign('category', $category);
            $view->assign('pageHtml', $pageHtml);
            $view->assign('username', $username);
            $view->assign('article', $article);
            $view->display('index.html');
        } else {
            $index = new \app\model\Index();
            $data = $index->pagination();
            $article = $data['data'];
            $pageHtml = $data['pageHtml'];
            $announcement = new \app\model\Announcement();
            $announcement = $announcement->getAnnouncement();
            $view->assign('announcement', $announcement);
            $view->assign('recommend', $recommend);
            $view->assign('category', $category);
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
