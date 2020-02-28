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

    // 确认用户名，在用户注册的时候，在用户名输入框输入后失去焦点时触发ajax，访问该方法
    public function checkUsername()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $user = Factory::createUser();
            $res =  $user->checkUsername($username);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            $this->displayNone();
        }
    }

    // 显示注册页面
    public function register()
    {
        $view = Factory::createView();
        $view->display('register.html');
    }

    // 显示电量页面
    public function login()
    {
        $view = Factory::createView();
        $view->display('login.html');
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

    // 处理注册页面提交的数据
    public function checkRegister()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $user = Factory::createUser();
            $res = $user->checkRegister($username, $password);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 处理登录页面提交的数据
    public function checkLogin()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $user = Factory::createUser();
            $res = $user->checkLogin($username, $password);
            if ($res) {
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

    // 显示写文章页面
    public function write()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $view->assign('username', $username);
            $view->display('write.html');
        } else {
            $view->display('nologin.html');
        }
    }

    // 处理写文章页面提交的数据
    public function checkWrite()
    {
        if (isset($_POST['title']) && isset($_POST['content'])) {
            // 还有category
            $title = $_POST['title'];
            $content = $_POST['content'];
            $user = Factory::createUser();
            $res = $user->checkWrite($title, $content);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 显示个人首页
    public function personal()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            $article = new \app\controller\Article();
            $data = $article->personal($username);
            $user = Factory::createUser();
            $user = $user->personal($username);
            $view->assign('username', $username);
            $view->assign('data', $data);
            $view->assign('user', $user);
            $view->display('personal.html');
        } else {
            $view->display('nologin.html');
        }
    }

    // 私信功能
    public function addInformation()
    {
        if (isset($_POST['author'])) {
            $author = $_POST['author'];
            $view = Factory::createView();
            $view->assign('author', $author);
            $view->display('add.html');
        }else{
            $this->displayNone();
        }
    }

    // 处理用户发的私信数据
    public function checkInformation()
    {
        if (isset($_POST['author']) && isset($_POST['username']) && isset($_POST['content'])) {
            $author = $_POST['author'];
            $username = $_POST['username'];
            $content = $_POST['content'];

            $user = Factory::createUser();
            $res = $user->checkInformation($author, $username, $content);
            if($res){
                echo '1';
            }else{
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 显示用户修稿密码和个人简介的页面
    public function change()
    {
        $access = Validate::checkAccess();
        $view = Factory::createView();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $user = Factory::createUser();
            $user = $user->personal($username);
            $view->assign('username', $username);
            $view->assign('user', $user);
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
                $res = $user->checkChange($username, $password, $introduction);
            }
            if ($res) {
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
            $articles = $article->manage($username);
            $comment = new \app\model\Comment();
            $comment = $comment->manage($username);
            $information = new \app\model\Information();
            $information = $information->getInformation($username);
            $view->assign('username', $username);
            $view->assign('articles', $articles);
            $view->assign('comment', $comment);
            $view->assign('information', $information);
            $view->display('manage.html');
        } else {
            $view->display('nologin.html');
        }
    }

    // 显示编辑文章页面
    public function editArticle()
    {
        if (isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $view = Factory::createView();
            $article = Factory::createArticle();
            $article = $article->getArticle($article_id);
            $view->assign('article', $article);
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
            $res = $article->editArticle($article_id, $title, $content);
            if ($res) {
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
            $res = $article->delArticle($article_id);
            if ($res) {
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
            $comment  = new \app\model\Comment();
            $res = $comment->delComment($comment_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    // 删除私信
    public function delInformation()
    {
        if (isset($_POST['information_id'])) {
            $information_id = $_POST['information_id'];
            $information  = new \app\model\Information();
            $res = $information->delInformation($information_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    // 当用户在URL中输入/user/之后的是用户名时，访问该用户
    public function __call($method, $args)
    {
        $author = $method;
        $view = Factory::createView();
        $user = Factory::createUser();
        $realUsername = $user->getUsername($author);
        if (!$realUsername) {
            $view->display('notfound.html');
            exit();
        }
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            $article = new \app\controller\Article();
            $data = $article->personal($author);
            $user = Factory::createUser();
            $user = $user->personal($author);
            $follows = new \app\model\Follows();
            $follows = $follows->getFollows($author);
            foreach ($follows as $values) {
                foreach ($values as $value) {
                    $allFollows .= $value . ',';
                }
            }
            if (in_array($username, explode(',', $allFollows))) {
                $follows = true;
                $view->assign('follows', $follows);
            }
            // 粉丝
            $view->assign('username', $username);
            $view->assign('data', $data);
            $view->assign('user', $user);
            $view->display('personal.html');
        } else {
            $view->display('nologin.html');
        }
    }
}
