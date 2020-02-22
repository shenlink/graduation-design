<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;

class Admin extends Controller
{
    public function checkSattus()
    {
    }
    public function manage()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1') {
            $username = $_SESSION['username'];
            $admin = Factory::createAdmin();
            $user = $admin->user();
            $article = $admin->article();
            $category = $admin->category();
            $comment = $admin->comment();
            $announcement = $admin->announcement();
            $view->assign('username', $username);
            $view->assign('user', $user);
            $view->assign('article', $article);
            $view->assign('category', $category);
            $view->assign('comment', $comment);
            $view->assign('announcement', $announcement);
            $view->display('admin.html');
        } else if ($access == '2') {
            $view->display('noadmin.html');
        } else {
            $view->display('nologin.html');
        }
    }

    public function defriedUser()
    {
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $admin = Factory::createAdmin();
            $res = $admin->defriedUser($user_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        }else{
            echo '404';
        }
    }

    public function delUser()
    {
        if(isset($_POST['user_id'])){
            $user_id = $_POST['user_id'];
            $admin = Factory::createAdmin();
            $res = $admin->delUser($user_id);
            if($res){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo '404';
        }
    }

    public function defriendArticle()
    {
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $admin = Factory::createAdmin();
            $res = $admin->defriendArticle($article_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '404';
        }
    }

    public function delArticle()
    {
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $article = Factory::createArticle();
            $res = $article->delArticle($article_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '404';
        }
    }

    public function delCategory()
    {
        if (isset($_POST['category'])) {
            $category = $_POST['category'];
            $category = Factory::createCategory();
            $res = $category->delArticle($category);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '404';
        }
    }

    // 规范，model数据操作应在相应的表中
    public function delComment()
    {
        if (isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $comment  = new \app\model\Comment();
            $res = $comment->delComment($comment_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '404';
        }
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
