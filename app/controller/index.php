<?php

namespace app\controller;

use core\lib\Controller;

class Index extends Controller
{
    // 显示首页
    public function index()
    {
        $access = Validate::checkAccess();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
        }
        $announcements = $this->announcement->getAnnouncement();
        $categorys = $this->category->getCategory();
        if (isset($_POST['pageNumber'])) {
            $pageNumber = $_POST['pageNumber'];
            $data = $this->article->getAllArticle($pageNumber, 5);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
        } else {
            $data = $this->article->getAllArticle();
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
        }
        $recommends = $this->article->recommend();
        $this->view->assign('username', $username);
        $this->view->assign('announcements', $announcements);
        $this->view->assign('articles', $articles);
        $this->view->assign('categorys', $categorys);
        $this->view->assign('articlePage', $articlePage);
        $this->view->assign('recommends', $recommends);
        $this->view->display('index.html');
    }

    public function __call($method, $args)
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }
}
