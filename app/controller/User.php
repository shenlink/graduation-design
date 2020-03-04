<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;
use app\controller\Validate;


class User extends Controller
{

    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 搜索相关操作的方法
    public function search()
    {

        $view = Factory::createView();
        $access = Validate::checkAccess();
        if (isset($_POST['type']) && isset($_POST['content'])) {
            if ($access == 1 || $access == 2) {
                $username = $_SESSION['username'];
            }
            $type = $_POST['type'];
            $content = $_POST['content'];
            $article = Factory::createArticle();
            $category = Factory::createCategory();
            $user = Factory::createUser();
            $articles = $article->search($content);
            $categorys = $category->getCategory();
            $users = $user->search($content);
            if ($type == '1') {
                $type = '用户名查询结果';
                $view->assign('users', $users);
            } else {
                $type = '文章查询结果';
                $view->assign('articles', $articles);
            }
            $view->assign('username', $username);
            $view->assign('categorys', $categorys);
            $view->assign('type', $type);
            $view->assign('users', $users);
            $view->display('search.html');
        } else {
            $this->displayNone();
        }
    }

    // 确认用户名，在用户注册的时候，在用户名输入框输入后失去焦点时触发ajax，访问该方法
    public function checkUsername()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $user = Factory::createUser();
            $result =  $user->checkUsername($username);
            $intercept = $this->getIntercept($username);
            if ($result || $intercept) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            $this->displayNone();
        }
    }

    public function getIntercept($username)
    {
        $pattern = '/Admin|Article|Category|index|User|Validate|displayNone|checkUsername|register|login|logout|checkRegister|checkLogin|write|checkWrite|checkCollect|addComment|delaComment|checkFollow|checkPraise|checkShare|personal|addMessage|checkMessage|change|checkChange|manage|editArticle|checkEdit|delArticle|delComment|delMessage/i';
        $intercept = preg_match($pattern, $username);
        return $intercept;
    }

    // 显示注册页面
    public function register()
    {
        $category = Factory::createCategory();
        $view = Factory::createView();
        $categorys = $category->getCategory();
        $view->assign('categorys', $categorys);
        $view->display('register.html');
    }

    // 处理注册页面提交的数据
    public function checkRegister()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $user = Factory::createUser();
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $user->checkRegister($username, $password, $created_at);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 显示登录页面
    public function login()
    {
        $category = Factory::createCategory();
        $view = Factory::createView();
        $categorys = $category->getCategory();
        $view->assign('categorys', $categorys);
        $view->display('login.html');
    }

    // 处理登录页面提交的数据
    public function checkLogin()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $user = Factory::createUser();
            $result = $user->checkLogin($username, $password);
            if ($result) {
                session_start();
                $_SESSION['username'] = $username;
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 退出登录功能的实现
    public function logout()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            unset($_SESSION['username']);
            echo "<script>window.location.href='/'</script>";
        } else {
            $view = Factory::createView();
            $view->display('nologin.html');
        }
    }

    // 显示个人首页
    public function personal()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            $article = Factory::createArticle();
            $category = Factory::createCategory();
            $collect =  Factory::createCollect();
            $comment =  Factory::createComment();
            $praise =  Factory::createPraise();
            $share =  Factory::createShare();
            $user = Factory::createUser();
            $articles = $article->personal($username);
            $categorys = $category->getCategory();
            $collects = $collect->getCollect($username);
            $comments = $comment->getComment($username);
            $praises = $praise->getPraise($username);
            $shares = $share->getShare($username);
            $users = $user->personal($username);
            $view->assign('username', $username);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('collects', $collects);
            $view->assign('comments', $comments);
            $view->assign('praises', $praises);
            $view->assign('shares', $shares);
            $view->assign('users', $users);
            $view->display('personal.html');
        } else {
            $view->display('nologin.html');
        }
    }

    // 显示用户修稿密码和个人简介的页面
    public function change()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $category = Factory::createCategory();
            $user = Factory::createUser();
            $categorys = $category->getCategory();
            $users = $user->personal($username);
            $view->assign('username', $username);
            $view->assign('categorys', $categorys);
            $view->assign('users', $users);
            $view->display('change.html');
        } else if ($access == '3') {
            $view->display('nologin.html');
        } else {
            $this->displayNone();
        }
    }

    // 处理从修稿页面提交的数据
    public function checkChange()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_SESSION['introduction'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $introduction = trim($_POST['introduction']);
            $user = Factory::createUser();
            if (isset($username) && isset($password) && isset($introduction)) {
                $result = $user->checkChange($username, $password, $introduction);
            }
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 显示用户管理页面
    public function manage()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            $article = Factory::createArticle();
            $category = Factory::createCategory();
            $comment =  Factory::createComment();
            $receive = Factory::createReceive();
            $articles = $article->manage($username);
            $categorys = $category->getCategory();
            $comments = $comment->manage($username);
            $receives = $receive->getReceive($username);
            $view->assign('username', $username);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('comments', $comments);
            $view->assign('receives', $receives);
            $view->display('manage.html');
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
            $this->displayNone();
        }
    }

    // 恢复用户的状态为正常
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

    // 当用户在URL中输入/user/之后的是用户名时，访问该用户
    public function __call($method, $args)
    {
        $author = $method;
        $user = Factory::createUser();
        $view = Factory::createView();
        $realUsername = $user->getUsername($author);
        if (!$realUsername) {
            $view->display('notfound.html');
            exit();
        }
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            $article = Factory::createArticle();
            $category = Factory::createCategory();
            $follow =  Factory::createFollow();
            $articles = $article->personal($author);
            $categorys = $category->getCategory();
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
            $view->assign('users', $users);
            $view->display('user.html');
        } else {
            $view->display('nologin.html');
        }
    }
}
