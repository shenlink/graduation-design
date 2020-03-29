<?php

namespace app\controller;

use core\lib\Controller;

class Index extends Controller
{

    // 显示首页
    public function index($type = 'pagination', $pagination = 1)
    {
        $announcements = $this->announcement->getAnnouncement();
        $data = $this->article->getIndexArticle($pagination, 5, $type);
        $articles = $data['items'];
        $articlePage = $data['pageHtml'];
        $recommends = $this->article->recommend();
        $this->view->assign('announcements', $announcements);
        $this->view->assign('articles', $articles);
        $this->view->assign('articlePage', $articlePage);
        $this->view->assign('recommends', $recommends);
        $this->view->display('index.html');
    }

    public function test()
    {
        // echo $this->admin;
        $this->view->display('test.html');
    }

    public function __call($method, $args)
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }
}
