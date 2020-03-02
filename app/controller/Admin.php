<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;
use core\lib\Factory;

class Admin extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 显示管理员的管理页面
    public function manage()
    {
        // 确认权限，为1时允许操作
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1') {
            $username = $_SESSION['username'];
            $category = Factory::createCategory();
            $categorys = $category->category();
            $article = Factory::createArticle();
            $comment =  Factory::createComment();
            $announcement =  Factory::createAnnouncement();
            $user = Factory::createUser();
            $users = $user->user();
            $articles = $article->article();
            $comments = $comment->comment();
            $announcements = $announcement->announcement();
            $view->assign('username', $username);
            $view->assign('categorys', $categorys);
            $view->assign('users', $users);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('comments', $comments);
            $view->assign('announcements', $announcements);
            $view->display('admin.html');
        } else if ($access == '2') {
            $view->display('noadmin.html');
        } else {
            $view->display('nologin.html');
        }
    }

    // 拉黑用户
    public function defriendUser()
    {
        // 获取前端ajax传来的user_id
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $user = Factory::createUser();
            $result = $user->defriendUser($user_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            // 当$_POST['user_id']不存在时，即用户直接访问该方法时，显示404页面
            $this->displayNone();
        }
    }

    // 回复用户的状态为正常
    public function normalUser()
    {
        // 获取前端ajax传来的user_id
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $user = Factory::createUser();
            $result = $user->normalUser($user_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            // 当$_POST['user_id']不存在时，即用户直接访问该方法时，显示404页面
            $this->displayNone();
        }
    }

    // 删除用户
    public function delUser()
    {
        // 获取前端ajax传来的user_id
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $user = Factory::createUser();
            $result = $user->delUser($user_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            // 当$_POST['user_id']不存在时，即用户直接访问该方法时，显示404页面
            $this->displayNone();
        }
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

    // 删除文章
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

    // 删除评论
    public function delComment()
    {
        if (isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $comment  =  Factory::createComment();
            $result = $comment->delComment($comment_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 删除公告
    public function delAnnouncement()
    {
        if (isset($_POST['announcement_id'])) {
            $announcement_id = $_POST['announcement_id'];
            $announcement  =  Factory::createAnnouncement();
            $result = $announcement->delAnnouncement($announcement_id);
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
            $view->assign('categorys',$categorys);
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
            $result = $announcement->addAnnouncement($content,$created_at);
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

    // 当用户调用Admin类中不存在的方法时，提示404页面
    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
