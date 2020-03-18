<?php

namespace app\controller;

use core\lib\Controller;
use app\controller\Validate;


class User extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    // 搜索相关操作的方法
    public function search()
    {
        $access = Validate::checkAccess();
        if (isset($_POST['type']) && isset($_POST['content'])) {
            if ($access == 1 || $access == 2) {
                $username = $_SESSION['username'];
            }
            $type = $_POST['type'];
            $content = $_POST['content'];
            $articles = $this->article->search($content);
            $categorys = $this->category->getCategory();
            $users = $this->user->search($content);
            if ($type == '1') {
                $type = '用户名查询结果';
                $this->view->assign('users', $users);
            } else {
                $type = '文章查询结果';
                $this->view->assign('articles', $articles);
            }
            $this->view->assign('username', $username);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('type', $type);
            $this->view->assign('users', $users);
            $this->view->display('search.html');
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
            $result =  $this->user->checkUsername($username);
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
        $pattern = '/displayNone|search|checkUsername|getIntercept|register|login|logout|checkRegister|checkLogin|write|checkWrite|change|checkChange|manage|editArticle|checkEdit|__call/i';
        $intercept = preg_match($pattern, $username);
        return $intercept;
    }

    // 显示注册页面
    public function register()
    {
        $categorys = $this->category->getCategory();
        $this->view->assign('categorys', $categorys);
        $this->view->display('register.html');
    }

    // 处理注册页面提交的数据
    public function checkRegister()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            date_default_timezone_set('PRC');
            $created_at = date('Y-m-d H:i:s', time());
            $result = $this->user->checkRegister($username, $password, $created_at);
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
        $categorys = $this->category->getCategory();
        $this->view->assign('categorys', $categorys);
        $this->view->display('login.html');
    }

    // 处理登录页面提交的数据
    public function checkLogin()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $result = $this->user->checkLogin($username, $password);
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
            $this->view->assign('nologin', 'nologin');
            $this->view->display('error.html');
        }
    }

    // 显示个人首页
    public function personal()
    {
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            $categorys = $this->category->getCategory();
            if (isset($_POST['type'])) {
                if ($_POST['articlePages']) {
                    $data = $this->article->getUserArticle($username, $_POST['articlePages'], 5);
                } else {
                    $data = $this->article->getUserArticle($username, 1, 5);
                }
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $this->view->assign('articlePage', $articlePage);

                if ($_POST['collectPages']) {
                    $data = $this->collect->getCollect($username, $_POST['collectPages'], 5);
                } else {
                    $data = $this->collect->getCollect($username, 1, 5);
                }
                $collects = $data['items'];
                $collectPage = $data['pageHtml'];
                $this->view->assign('collectPage', $collectPage);

                if ($_POST['commentPages']) {
                    $data = $this->comment->getComment($username, $_POST['articlePages'], 5);
                } else {
                    $data = $this->comment->getComment($username, 1, 5);
                }
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $this->view->assign('commentPage', $commentPage);

                if ($_POST['praisePages']) {
                    $data = $this->praise->getPraise($username, $_POST['praisePages'], 5);
                } else {
                    $data = $this->praise->getPraise(1, 5);
                }
                $praises = $data['items'];
                $praisePage = $data['pageHtml'];
                $this->view->assign('praisePage', $praisePage);

                if ($_POST['sharePages']) {
                    $data = $this->share->getShare($username, $_POST['sharePages'], 5);
                } else {
                    $data = $this->share->getShare(1, 5);
                }
                $shares = $data['items'];
                $sharePage = $data['pageHtml'];
                $this->view->assign('sharePage', $sharePage);
            } else {
                $data = $this->article->getUserArticle($username);
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $this->view->assign('articlePage', $articlePage);

                $data = $this->collect->getCollect($username);
                $collects = $data['items'];
                $collectPage = $data['pageHtml'];
                $this->view->assign('collectPage', $collectPage);

                $data = $this->comment->getComment($username);
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $this->view->assign('commentPage', $commentPage);

                $data = $this->praise->getPraise($username);
                $praises = $data['items'];
                $praisePage = $data['pageHtml'];
                $this->view->assign('praisePage', $praisePage);

                $data = $this->share->getShare($username);
                $shares = $data['items'];
                $sharePage = $data['pageHtml'];
                $this->view->assign('sharePage', $sharePage);
            }
            $recents = $this->article->getRecentArticle($username);
            $users = $this->user->personal($username);
            $this->view->assign('username', $username);
            $this->view->assign('articles', $articles);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('collects', $collects);
            $this->view->assign('comments', $comments);
            $this->view->assign('recents', $recents);
            $this->view->assign('praises', $praises);
            $this->view->assign('shares', $shares);
            $this->view->assign('users', $users);
            $this->view->display('personal.html');
        } else {
            $this->view->assign('nologin', 'nologin');
            $this->view->display('error.html');
        }
    }

    // 显示用户修稿密码和个人简介的页面
    public function change()
    {
        $access = Validate::checkAccess();
        if ($access == '1' || $access == '2') {
            $username = $_SESSION['username'];
            $categorys = $this->category->getCategory();
            $users = $this->user->personal($username);
            $this->view->assign('username', $username);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('users', $users);
            $this->view->display('change.html');
        } else if ($access == '3') {
            $this->view->assign('nologin', 'nologin');
            $this->view->display('error.html');
        }
    }

    // 处理从修稿页面提交的数据
    public function checkChange()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['introduction'])) {
            $username = trim($_POST['username']);
            $password = md5(trim($_POST['password']));
            $introduction = trim($_POST['introduction']);
            if (isset($username) && isset($password) && isset($introduction)) {
                $result = $this->user->checkChange($username, $password, $introduction);
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
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            $categorys = $this->category->getCategory();
            if (isset($_POST['type'])) {
                if ($_POST['articlePages']) {
                    $data = $this->article->getManageArticle($username, $_POST['articlePages'], 5);
                } else {
                    $data = $this->article->getManageArticle(1, 5);
                }
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $this->view->assign('articlePage', $articlePage);

                if ($_POST['commentPages']) {
                    $data = $this->comment->getManageComment($username, $_POST['commentPages'], 5);
                } else {
                    $data = $this->comment->getManageComment(1, 5);
                }
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $this->view->assign('commentPage', $commentPage);

                if ($_POST['followPage']) {
                    $data = $this->follow->getFollow($username, $_POST['followPage'], 5);
                } else {
                    $data = $this->follow->getFollow(1, 5);
                }
                $follows = $data['items'];
                $followPage = $data['pageHtml'];
                $this->view->assign('followPage', $followPage);

                if ($_POST['fansPages']) {
                    $data = $this->follow->getFans($username, $_POST['commentPages'], 5);
                } else {
                    $data = $this->follow->getFans(1, 5);
                }
                $fans = $data['items'];
                $fnasPage = $data['pageHtml'];
                $this->view->assign('fnasPage', $fnasPage);

                if ($_POST['receivePages']) {
                    $data = $this->receive->getReceive($username, $_POST['receivePages'], 5);
                } else {
                    $data = $this->receive->getReceive($username, 1, 5);
                }
                $receives = $data['items'];
                $receivePage = $data['pageHtml'];
                $this->view->assign('receivePage', $receivePage);
            } else {
                $data = $this->article->getManageArticle($username);
                $articles = $data['items'];
                $articlePage = $data['pageHtml'];
                $this->view->assign('articlePage', $articlePage);

                $data = $this->comment->getManageComment($username);
                $comments = $data['items'];
                $commentPage = $data['pageHtml'];
                $this->view->assign('commentPage', $commentPage);

                $data = $this->follow->getFollow($username);
                $follows = $data['items'];
                $followPage = $data['pageHtml'];
                $this->view->assign('followPage', $followPage);

                $data = $this->follow->getFans($username,);
                $fans = $data['items'];
                $fnasPage = $data['pageHtml'];
                $this->view->assign('fnasPage', $fnasPage);

                $data = $this->receive->getReceive($username);
                $receives = $data['items'];
                $receivePage = $data['pageHtml'];
                $this->view->assign('receivePage', $receivePage);
            }
            $this->view->assign('username', $username);
            $this->view->assign('articles', $articles);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('comments', $comments);
            $this->view->assign('follows', $follows);
            $this->view->assign('fans', $fans);
            $this->view->assign('receives', $receives);
            $this->view->display('manage.html');
        } else {
            $this->view->assign('nologin', 'nologin');
            $this->view->display('error.html');
        }
    }

    // 拉黑用户
    public function defriendUser()
    {
        // 获取前端ajax传来的user_id
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $result = $this->user->defriendUser($user_id);
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
            $result = $this->user->normalUser($user_id);
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
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $result = $this->user->delUser($user_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }

    // 当用户在URL中输入/user/之后的是用户名时，访问该用户
    public function __call($method, $args)
    {
        $author = $method;
        $realUsername = $this->user->getUsername($author);
        if (!$realUsername) {
            $this->view->assign('error', 'error');
            $this->view->display('error.html');
            exit();
        }
        $access = Validate::checkAccess();
        if ($access == 1 || $access == 2) {
            $username = $_SESSION['username'];
            if (isset($_POST['pagination'])) {
                $data = $this->article->getUserArticle($username, $_POST['pagination'], 5);
            } else {
                $data = $this->article->getUserArticle($username);
            }
            $articles = $data['items'];
            $articlePage = $data['pageHtml'];
            $this->view->assign('articlePage', $articlePage);
            $categorys = $this->category->getCategory();
            $users = $this->user->personal($author);
            $follows = $this->follow->checkFollow($author, $username);
            $recents = $this->article->getRecentArticle($author);
            $this->view->assign('username', $username);
            $this->view->assign('articles', $articles);
            $this->view->assign('categorys', $categorys);
            $this->view->assign('follows', $follows);
            $this->view->assign('recents', $recents);
            $this->view->assign('users', $users);
            $this->view->display('user.html');
        } else {
            $this->view->assign('nologin', 'nologin');
            $this->view->display('error.html');
        }
    }
}
