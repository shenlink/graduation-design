<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Article extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 拉黑文章
    public function defriendArticle()
    {
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $article = Factory::createArticle();
            $result = $article->defriendArticle($article_id);
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
        // 获取前端ajax传来的user_id
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $article = Factory::createArticle();
            $result = $article->normalArticle($article_id);
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
            $article = Factory::createArticle();
            $category = Factory::createCategory();
            $view = Factory::createView();
            $articles = $article->getArticle($article_id);
            $categorys = $category->getCategory();
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->display('edit.html');
        } else {
            $this->displayNone();
        }
    }

    // 处理文章编辑页面提交的数据
    public function checkEdit()
    {
        if (isset($_POST['article_id']) && isset($_POST['title']) && isset($_POST['content'])) {
            $article_id = $_POST['article_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $article = Factory::createArticle();
            date_default_timezone_set('PRC');
            $updated_at = date('Y-m-d H:i:s', time());
            $result = $article->editArticle($article_id, $title, $content, $updated_at);
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
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $article = Factory::createArticle();
            $result = $article->delArticle($article_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 显示写文章页面
    public function write()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('username', $username);
            $view->assign('categorys', $categorys);
            $view->display('write.html');
        } else {
            $view->display('nologin.html');
        }
    }

    // 处理写文章页面提交的数据
    public function checkWrite()
    {
        if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            $user = Factory::createUser();
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $user->checkWrite($title, $content, $category, $created_at);
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
        $view = Factory::createView();
        $article_id = $method;
        if (!is_numeric($article_id)) {
            $view->display('notfound.html');
            exit();
        }
        $article = Factory::createArticle();
        $realArticle_id = $article->checkArticleId($article_id);
        if ($realArticle_id) {
            $category = Factory::createCategory();
            $comment =  Factory::createComment();
            $articles = $article->getArticle($article_id);
            $categorys = $category->getCategory();
            $comments = $comment->getArticleComment($article_id);
            $access = Validate::checkAccess();
            if ($access == 1 || $access == 2) {
                $username = $_SESSION['username'];
            }
            $author = $articles['author'];
            $user = Factory::createUser();
            $follow =  Factory::createFollow();
            $users = $user->personal($author);
            $follows = $follow->getFollow($author);
            foreach ($follows as $values) {
                foreach ($values as $value) {
                    $allFollows .= $value . ',';
                }
            }
            if (in_array($username, explode(',', $allFollows))) {
                $follows = true;
                $view->assign('follows', $follows);
            }
            $view->assign('username', $username);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('comments', $comments);
            $view->assign('users', $users);
            $view->display('article.html');
        } else {
            $view->display('notfound.html');
        }
    }
}
