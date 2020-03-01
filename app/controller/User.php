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
    // 这个方法一个放在user类中
    public function search()
    {
        // 用工厂类实例化View类
        $view = Factory::createView();
        if (isset($_POST['type']) && isset($_POST['content'])) {
            $type = $_POST['type'];
            $content = $_POST['content'];
            $article = Factory::createArticle();
            $articles = $article->search($content);
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $user = Factory::createUser();
            $users = $user->search($content);
            if ($type == '1') {
                $type = '用户名查询结果';
                $view->assign('users', $users);
            } else {
                $type = '文章查询结果';
                $view->assign('articles', $articles);
            }
            $view->assign('type', $type);
            $view->assign('categorys', $categorys);
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
        $pattern = '/Admin|Article|Category|index|User|Validate|displayNone|checkUsername|register|login|logout|checkRegister|checkLogin|write|checkWrite|checkCollect|addComment|delaComment|checkFollow|checkPraise|checkShare|personal|addInformation|checkInformation|change|checkChange|manage|editArticle|checkEdit|delArticle|delComment|delInformation/i';
        $intercept = preg_match($pattern, $username);
        return $intercept;
    }

    // 显示注册页面
    public function register()
    {
        $category = Factory::createCategory();
        $categorys = $category->getCategory();
        $view = Factory::createView();
        $view->assign('categorys', $categorys);
        $view->display('register.html');
    }

    // 显示登录页面
    public function login()
    {
        $category = Factory::createCategory();
        $categorys = $category->getCategory();
        $view = Factory::createView();
        $view->assign('categorys', $categorys);
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
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $res = $user->checkRegister($username, $password, $created_at);
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
            $res = $user->checkWrite($title, $content, $category, $created_at);
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


    // 确认添加评论
    public function addComment()
    {
        if (isset($_POST['content']) && isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['comment_at'])) {
            $content = $_POST['content'];
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $comment_at = $_POST['comment_at'];
            $comment = new \app\model\Comment();
            $res = $comment->addComment($content, $username, $article_id, $comment_at);
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
            $result =  $follow->checkFollow($author, $username);
            if ($result) {
                $cancel = $follow->cancelFollow($author, $username);
                if ($cancel) {
                    echo "取消关注成功";
                } else {
                    echo '取消关注失败';
                }
            } else {
                date_default_timezone_set('PRC');
                $follow_at = date('Y-m-d H:i:s', time());
                $add = $follow->addFollow($author, $username, $follow_at);
                if ($add) {
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
        if (isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['author']) && isset($_POST['title'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $praise = new \app\model\Praise();
            $result =  $praise->checkPraise($username, $article_id);
            if ($result) {
                // 如果已经点赞了，返回0,顺便取消点赞
                $cancel = $praise->cancelPraise($username, $article_id);
                if ($cancel) {
                    // 已经取消点赞
                    echo "0";
                }
            } else {
                // 如果还没有点赞
                date_default_timezone_set('PRC');
                $praise_at = date('Y-m-d H:i:s', time());
                $add = $praise->addPraise($username, $article_id, $author, $title, $praise_at);
                if ($add) {
                    // 已经点赞
                    echo "1";
                }
            }
        } else {
            $this->displayNone();
        }
    }

    public function checkCollect()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['author']) && isset($_POST['title'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $collect = new \app\model\Collect();
            $result =  $collect->checkCollect($username, $article_id);
            if ($result) {
                $cancel = $collect->cancelCollect($username, $article_id);
                if ($cancel) {
                    echo "0";
                }
            } else {
                date_default_timezone_set('PRC');
                $collect_at = date('Y-m-d H:i:s', time());
                $add = $collect->addCollect($username, $article_id, $author, $title, $collect_at);
                if ($add) {
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
        if (isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['author']) && isset($_POST['title'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $share = new \app\model\Share();
            $result =  $share->checkShare($username, $article_id);
            if ($result) {
                $cancel = $share->cancelShare($username, $article_id);
                if ($cancel) {
                    echo "0";
                }
            } else {
                date_default_timezone_set('PRC');
                $share_at = date('Y-m-d H:i:s', time());
                $add = $share->addShare($username, $article_id, $author, $title, $share_at);
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
            $users = $user->personal($username);
            $article = Factory::createArticle();
            $articles = $article->personal($username);
            $collect = new \app\model\Collect();
            $collects = $collect->getCollect($username);
            $share = new \app\model\Share();
            $shares = $share->getShare($username);
            $praise = new \app\model\Praise();
            $praises = $praise->getPraise($username);
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('username', $username);
            $view->assign('categorys', $categorys);
            $view->assign('articles', $articles);
            $view->assign('collects', $collects);
            $view->assign('shares', $shares);
            $view->assign('praises', $praises);
            $view->assign('users', $users);
            $view->display('personal.html');
        } else {
            $view->display('nologin.html');
        }
    }

    public function delPraise()
    {
        if (isset($_POST['praise_id'])) {
            $praise_id = $_POST['praise_id'];
            $praise = new \app\model\Praise();
            $result = $praise->delPraise($praise_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    public function delCollect()
    {
        if (isset($_POST['collect_id'])) {
            $collect_id = $_POST['collect_id'];
            $collect = new \app\model\Collect();
            $result = $collect->delCollect($collect_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    public function delShare()
    {
        if (isset($_POST['share_id'])) {
            $share_id = $_POST['share_id'];
            $share = new \app\model\Share();
            $result = $share->delShare($share_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    public function addInformation()
    {
        if (isset($_POST['author'])) {
            $author = $_POST['author'];
            $view = Factory::createView();
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('categorys', $categorys);
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
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $res = $user->checkInformation($author, $username, $content, $created_at);
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
            $users = $user->personal($username);
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
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
            $comments = $comment->manage($username);
            $information = new \app\model\Information();
            $informations = $information->getInformation($username);
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $view->assign('username', $username);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('comments', $comments);
            $view->assign('informations', $informations);
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
            $articles = $article->getArticle($article_id);
            $category = Factory::createCategory();
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
            $res = $article->editArticle($article_id, $title, $content, $updated_at);
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
            $articles = $article->personal($author);
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $users = $user->personal($author);
            $follow = new \app\model\Follow();
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
            $view->assign('categorys', $categorys);
            $view->assign('articles', $articles);
            $view->assign('users', $users);
            $view->display('user.html');
        } else {
            $view->display('nologin.html');
        }
    }
}
