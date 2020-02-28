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
        $pattern = '/Admin|Article|Category|index|User|Validate|displayNone|checkUsername|register|login|logout|checkRegister|checkLogin|write|checkWrite|checkCollect|addComment|delaComment|checkFollow|checkPraise|checkShare|personal|addInformation|checkInformation|change|checkChange|manage|editArticle|checkEdit|delArticle|delComment|delInformation/i';
        $intercept = preg_match($pattern, $username);
        return $intercept;
    }

    // 显示注册页面
    public function register()
    {
        $category = Factory::createCategory();
        $category = $category->getCategory();
        $view = Factory::createView();
        $view->assign('category', $category);
        $view->display('register.html');
    }

    // 显示登录页面
    public function login()
    {
        $category = Factory::createCategory();
        $category = $category->getCategory();
        $view = Factory::createView();
        $view->assign('category', $category);
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
            $category = Factory::createCategory();
            $category = $category->getCategory();
            $view->assign('username', $username);
            $view->assign('category', $category);
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
            $res = $user->checkWrite($title, $content, $category);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 确认收藏
    public function checkCollect()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $collect = new \app\model\Collect();
            $res =  $collect->checkCollect($username, $article_id);
            if ($res) {
                $cancel = $collect->cancelCollect($username, $article_id);
                if ($cancel) {
                    echo "0";
                }
            } else {
                $add = $collect->addCollect($username, $article_id);
                if ($add) {
                    echo "1";
                }
            }
        } else {
            $this->displayNone();
        }
    }

    // 确认添加评论
    public function addComment()
    {
        if (isset($_POST['content']) && isset($_POST['username']) && isset($_POST['article_id'])) {
            $content = $_POST['content'];
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $comment = new \app\model\Comment();
            $res = $comment->addComment($content, $username, $article_id);
            if ($res) {
                echo $res;
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 确认删除文章的评论
    public function delArticleComment()
    {
        if (isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $comment = new \app\model\Comment();
            $res = $comment->delComment($comment_id);
            if ($res) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 确认关注
    public function checkFollow()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['author']) && isset($_POST['username'])) {
            $author = $_POST['author'];
            $username = $_POST['username'];
            $follow = new \app\model\Follow();
            $res =  $follow->checkFollow($author, $username);
            if ($res) {
                if ($follow->cancelFollow($author, $username)) {
                    echo "取消关注成功";
                } else {
                    echo '取消关注失败';
                }
            } else {
                if ($follow->addFollow($author, $username)) {
                    echo "关注成功";
                } else {
                    echo '关注失败';
                }
            }
        } else {
            $this->displayNone();
        }
    }

    // 确认点赞
    public function checkPraise()
    {
        // 思路：只有按钮，用户点击之后，先确认用户是否已经点赞，若已经点赞，则取消点赞，否则点赞加1
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $praise = new \app\model\Praise();
            $res =  $praise->checkPraise($username, $article_id);
            if ($res) {
                // 如果已经点赞了，返回0,顺便取消点赞
                $res = $praise->cancelPraise($username, $article_id);
                if ($res) {
                    // 已经取消点赞
                    echo "0";
                }
            } else {
                // 如果还没有点赞
                $res = $praise->addPraise($username, $article_id);
                if ($res) {
                    // 已经点赞
                    echo "1";
                }
            }
        } else {
            $this->displayNone();
        }
    }

    // 确认分享
    public function checkShare()
    {
        // 思路：只有按钮，用户点击之后，先确认用户是否已经点赞，若已经点赞，则取消点赞，否则点赞加1
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $share = new \app\model\Share();
            $res =  $share->checkShare($username, $article_id);
            if ($res) {
                $cancel = $share->cancelShare($username, $article_id);
                if ($cancel) {
                    echo "0";
                }
            } else {
                $add = $share->addShare($username, $article_id);
                if ($add) {
                    echo "1";
                }
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
            $user = Factory::createUser();
            $user = $user->personal($username);
            $article = Factory::createArticle();
            $article = $article->personal($username);
            $collect = new \app\model\Collect();
            $collect = $collect->getCollect($username);
            $share = new \app\model\Share();
            $share = $share->getShare($username);
            $praise = new \app\model\Praise();
            $praise = $praise->getPraise($username);
            $category = Factory::createCategory();
            $category = $category->getCategory();
            $view->assign('username', $username);
            $view->assign('category', $category);
            $view->assign('article', $article);
            $view->assign('collect', $collect);
            $view->assign('share', $share);
            $view->assign('praise', $praise);
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
            $category = Factory::createCategory();
            $category = $category->getCategory();
            $view->assign('category', $category);
            $view->assign('author', $author);
            $view->display('add.html');
        } else {
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
            if ($res) {
                echo '1';
            } else {
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
            $category = Factory::createCategory();
            $category = $category->getCategory();
            $view->assign('username', $username);
            $view->assign('category', $category);
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
            $category = Factory::createCategory();
            $category = $category->getCategory();
            $view->assign('username', $username);
            $view->assign('articles', $articles);
            $view->assign('category', $category);
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
            $category = Factory::createCategory();
            $category = $category->getCategory();
            $view->assign('article', $article);
            $view->assign('category', $category);
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
            $article = Factory::createArticle();
            $article = $article->personal($author);
            $category = Factory::createCategory();
            $category = $category->getCategory();
            $user = Factory::createUser();
            $user = $user->personal($author);
            $follow = new \app\model\Follow();
            $follow = $follow->getFollow($author);
            foreach ($follow as $values) {
                foreach ($values as $value) {
                    $allFollow .= $value . ',';
                }
            }
            if (in_array($username, explode(',', $allFollow))) {
                $follow = true;
                $view->assign('follow', $follow);
            }
            $view->assign('username', $username);
            $view->assign('category', $category);
            $view->assign('article', $article);
            $view->assign('user', $user);
            $view->display('user.html');
        } else {
            $view->display('nologin.html');
        }
    }
}
