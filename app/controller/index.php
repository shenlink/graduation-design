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
        $recommends = $this->article->recommend();
        $categorys = $this->category->getCategory();
        if (isset($_POST['pageNumber'])) {
            $pageNumber = $_POST['pageNumber'];
            $data = $this->article->getAllArticle($pageNumber, 5);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
        } else {
            // 因为直接返回了对象，所以不能再直接取注册树上的对象了

            $data = $this->article->getAllArticle();
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
        }
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
        // 显示404页面
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }
}
