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
        $recommends = $article->recommend();
        unset($article);
        $categorys = $category->getCategory();
        if (isset($_POST['pageNumber'])) {
            $pageNumber = $_POST['pageNumber'];
            $article = Factory::createArticle();
            $data = $article->changePage($pageNumber, 5);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
        } else {
            // 因为直接返回了对象，所以不能再直接取注册树上的对象了
            $article = new \app\model\Article();
            $data = $article->firstPage();
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

    public function test()
    {
        // $test = new \app\model\Test();
        // $test = $test->test();
        // $arr1 = ['shen','shen2'];
        // $arr2 = ['shen','shen2','shen3'];
        // $test = array_merge($arr1,$arr2);
        // echo '<pre>';
        // var_dump($test['items']);
        // echo $test;
        // $articles = $test['items'];
        // $view = Factory::createView();
        // $view->assign('articles',$articles);
        // $view->display('index.html');
        $article = Factory::createArticle();
        $data = $article->firstPage();
        var_dump($data);
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
