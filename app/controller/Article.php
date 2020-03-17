<?php

namespace app\controller;

use core\lib\Controller;

class Article extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    // 显示写文章页面
    public function write()
    {
        $access = Validate::checkAccess();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $categorys = $this->category->getCategory();
            $this->view->assign('username', $username);
            $this->view->assign('categorys', $categorys);
            $this->view->display('write.html');
        } else {
            $this->view->assign('nologin','nologin');
            $this->view->display('error.html');
        }
    }

    // 处理写文章页面提交的数据
    public function checkWrite()
    {
        if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category'])) {
            session_start();
            $author = $_SESSION['username'];
            $category = $_POST['category'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $this->article->checkWrite($author, $category, $title,  $content,  $created_at);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 显示编辑文章页面
    public function editArticle()
    {
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $articles = $this->article->getArticle($article_id);
            $categorys = $this->category->getCategory();
            $this->view->assign('articles', $articles);
            $this->view->assign('categorys', $categorys);
            $this->view->display('edit.html');
        } else {
            $this->displayNone();
        }
    }

    // 处理文章编辑页面提交的数据
    public function checkEdit()
    {
        if (isset($_POST['article_id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category'])) {
            $article_id = $_POST['article_id'];
            $category = $_POST['category'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            date_default_timezone_set('PRC');
            $updated_at = date('Y-m-d H:i:s', time());
            $result = $this->article->checkEdit($article_id, $category, $title, $content, $updated_at);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 拉黑文章
    public function defriendArticle()
    {
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $result = $this->article->defriendArticle($article_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    public function normalArticle()
    {
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $result = $this->article->normalArticle($article_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    //删除文章
    public function delArticle()
    {
        session_start();
        if (isset($_POST['article_id']) && isset($_POST['category'])) {
            $article_id = $_POST['article_id'];
            $author = $_SESSION['username'];
            $category = $_POST['category'];
            $result = $this->article->delArticle($article_id, $author, $category);
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
        $article_id = $method;
        if (!is_numeric($article_id)) {
            $this->view->assign('error','error');
            $this->view->display('error.html');
            exit();
        }
        $realArticle_id = $this->article->checkArticleId($article_id);
        if ($realArticle_id) {
            $articles = $this->article->getArticle($article_id);
            $categorys = $this->category->getCategory();
            $comments = $this->comment->getArticleComment($article_id);
            $access = Validate::checkAccess();
            if ($access == 1 || $access == 2) {
                $username = $_SESSION['username'];
            }
            $author = $this->article->getAuthor($article_id);
            $author = $author['author'];
            $users = $this->user->personal($author);
            $follows = $this->follow->checkFollow($author,$username);
            $recents = $this->article->getRecentArticle($author);
            $this->view->assign('username', $username);
            $this->view->assign('articles', $articles);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('comments', $comments);
            $this->view->assign('follows', $follows);
            $this->view->assign('recents', $recents);
            $this->view->assign('users', $users);
            $this->view->display('article.html');
        } else {
            $this->view->assign('error','error');
            $this->view->display('error.html');
        }
    }
}
