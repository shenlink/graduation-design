<?php

namespace app\controller;

use core\lib\Controller;

class Category extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    // 拉黑分类
    public function defriendCategory()
    {
        if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $result = $this->category->defriendCategory($categorys);
            echo $result ? '1' : '0';
        } else {
            $this->displayNone();
        }
    }

    // 恢复分类
    public function normalCategory()
    {
        if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $result = $this->category->normalCategory($categorys);
            echo $result ? '1' : '0';
        } else {
            $this->displayNone();
        }
    }

    // 删除分类
    public function delCategory()
    {
        if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $result = $this->category->delCategory($categorys);
            echo $result ? '1' : '0';
        } else {
            $this->displayNone();
        }
    }

    // 添加页面，共有添加分类，公告功能
    public function addCategory()
    {
        if (isset($_POST['addCategory'])) {
            $addCategory = $_POST['addCategory'];
            $recommends = $this->article->recommend();
            $this->view->assign('addCategory', $addCategory);
            $this->view->assign('recommends', $recommends);
            $this->view->display('add.html');
        } else {
            $this->displayNone();
        }
    }

    // 确认添加
    public function checkAddCategory()
    {
        if (isset($_POST['categoryName'])) {
            $categoryName = $_POST['categoryName'];
            $result = $this->category->addCategory($categoryName);
            echo $result ? '1' : '0';
        } else {
            $this->displayNone();
        }
    }

    public function __call($method, $args)
    {
        $categoryName = $method;
        $realCategory = $this->category->checkCategory($categoryName);
        if (!$realCategory) {
            $this->view->assign('error','error');
            $this->view->display('error.html');
            exit();
        }
        if (isset($_POST['pageNumber'])) {
            $pageNumber = $_POST['pageNumber'];
            $data = $this->article->getCategoryArticle($categoryName, $pageNumber, 5);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
            $this->view->assign('articlePage', $articlePage);
        }else{
            $data = $this->article->getCategoryArticle($categoryName);
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
            $this->view->assign('articlePage', $articlePage);
        }
        $recommends = $this->article->recommend();
        $this->view->assign('articles', $articles);
        $this->view->assign('categoryName', $categoryName);
        $this->view->assign('recommends', $recommends);
        $this->view->display('category.html');
    }
}
