<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;
use app\controller\Validate;

class Category extends Controller
{
    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 拉黑分类
    public function defriendcategory()
    {
        if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $category = Factory::createCategory();
            $result = $category->defriendcategory($categorys);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 恢复分类
    public function normalCategory()
    {
        if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $category = Factory::createCategory();
            $result = $category->normalCategory($categorys);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 删除分类
    public function delCategory()
    {
        if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $category = Factory::createCategory();
            $result = $category->delCategory($categorys);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 添加页面，共有添加分类，公告功能
    public function add()
    {
        $view = Factory::createView();
        if (isset($_POST['addCategory'])) {
            $addCategory = $_POST['addCategory'];
            $view->assign('addCategory', $addCategory);
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('categorys', $categorys);
            $view->display('add.html');
        } else if (isset($_POST['addAnnouncement'])) {
            $addAnnouncement = $_POST['addAnnouncement'];
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('categorys', $categorys);
            $view->assign('addAnnouncement', $addAnnouncement);
            $view->display('add.html');
        } else {
            $this->displayNone();
        }
    }

    // 确认添加
    public function checkAdd()
    {
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
            $announcement  =  Factory::createAnnouncement();
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $announcement->addAnnouncement($content, $created_at);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $category = Factory::createCategory();
            $result = $category->addCategory($categorys);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    public function __call($method, $args)
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
        }
        $categoryName = $method;
        $category = Factory::createCategory();
        $view = Factory::createView();
        $realCategory = $category->checkCategory($categoryName);
        if (!$realCategory) {
            $view->display('notfound.html');
            exit();
        }
        $article = Factory::createArticle();
        $articles = $category->getArticle($categoryName);
        $categorys = $category->getCategory();
        $recommends = $article->recommend();
        $view->assign('username', $username);
        $view->assign('articles', $articles);
        $view->assign('categorys', $categorys);
        $view->assign('categoryName',$categoryName);
        $view->assign('recommends', $recommends);
        $view->display('category.html');
    }
}
