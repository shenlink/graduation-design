<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    // 显示首页
    public function index()
    {
        // 太冗余了，这有问题，
        $access = Validate::checkAccess();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
        }
        $announcement = Factory::createAnnouncement();
        $article = Factory::createArticle();
        $category = Factory::createCategory();
        $view = Factory::createView();
        $announcements = $announcement->getAnnouncement();
        $categorys = $category->getCategory();
        $recommends = $article->recommend();
        if (isset($_POST['pageNumber'])) {
            $pageNumber = $_POST['pageNumber'];
            $article = Factory::createArticle();
            $data = $article->changePage($pageNumber, 5);
            $articles = $data['article'];
            $pageHtml = $data['pageHtml'];
            $view->assign('username', $username);
            $view->assign('announcements', $announcements);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('pageHtml', $pageHtml);
            $view->assign('recommends', $recommends);
            $view->display('index.html');
        } else {
            $data = $article->firstPage();
            $articles = $data['article'];
            $pageHtml = $data['pageHtml'];
            $view->assign('username', $username);
            $view->assign('announcements', $announcements);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('pageHtml', $pageHtml);
            $view->assign('recommends', $recommends);
            $view->display('index.html');
        }
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
