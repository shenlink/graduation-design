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
            // 获取当前登录的用户的用户名
            $username = $_SESSION['username'];
            $admin = Factory::createAdmin();
            $category = Factory::createCategory();
            $category = $category->getCategory();
            // 获取user表里所有用户信息
            $user = $admin->user();
            // 获取article表里的所有文章信息
            $article = $admin->article();
            //获取category表里的所有分类信息
            $category = $admin->category();
            //获取comment表里的所有评论信息
            $comment = $admin->comment();
            //获取announcement表里的所有公告信息
            $announcement = $admin->announcement();
            // assign赋值操作
            $view->assign('username', $username);
            $view->assign('category', $category);
            $view->assign('user', $user);
            $view->assign('article', $article);
            $view->assign('category', $category);
            $view->assign('comment', $comment);
            $view->assign('announcement', $announcement);
            // 展示admin页面
            $view->display('admin.html');
        } else if ($access == '2') {
            // 如果权限为2，即普通用户时，提示没有权限
            $view->display('noadmin.html');
        } else {
            // 如果权限为3，即用户未登录，提示用户未登录
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
            $admin = Factory::createAdmin();
            $result = $admin->defriendArticle($article_id);
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

    // 规范，model数据操作应在相应的表中
    // 删除评论
    public function delComment()
    {
        if (isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $comment  = new \app\model\Comment();
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

    // 添加公告
    public function addAnnouncement()
    {
        if (isset($_POST['announcement_id'])) {
            $announcement_id = $_POST['announcement_id'];
            $announcement  = new \app\model\Announcement();
            $result = $announcement->addAnnouncement($announcement_id);
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
            $announcement  = new \app\model\Announcement();
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
            $view->display('add.html');
        } else if (isset($_POST['announcement'])) {
            $announcement = $_POST['announcement'];
            $view->assign('announcement', $announcement);
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
            $announcement  = new \app\model\Announcement();
            $result = $announcement->addAnnouncement($content);
            if ($result) {
                echo '<script>window.location.href="/admin/manage"</script>';
            } else {
                echo '0';
            }
        } else if (isset($_POST['category'])) {
            $categorys = $_POST['category'];
            $category = Factory::createCategory();
            $result = $category->addCategory($categorys);
            if ($result) {
                echo '<script>window.location.href="/admin/manage"</script>';
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
