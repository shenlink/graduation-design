<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Index extends Controller
{
    // 显示首页
    public function index()
    {
        $access = Validate::checkAccess();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
        }
        $announcement = Factory::createAnnouncement();
        $article = Factory::createArticle();
        $category = Factory::createCategory();
        $view = Factory::createView();
        $announcements = $announcement->getAnnouncement();
        $recommends = $article->recommend();
        $categorys = $category->getCategory();
        if (isset($_POST['pageNumber'])) {
            $pageNumber = $_POST['pageNumber'];
            $article = new \app\model\Article();
            $data = $article->getAllArticle($pageNumber, 5);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
        } else {
            // 因为直接返回了对象，所以不能再直接取注册树上的对象了
            $article = new \app\model\Article();
            $data = $article->getAllArticle();
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
        }
        $view->assign('username', $username);
        $view->assign('announcements', $announcements);
        $view->assign('articles', $articles);
        $view->assign('categorys', $categorys);
        $view->assign('articlePage', $articlePage);
        $view->assign('recommends', $recommends);
        $view->display('index.html');
    }

    public function __call($method, $args)
    {
        // 显示404页面
        $view = Factory::createView();
        $view->assign('error', 'error');
        $view->display('error.html');
    }
}
