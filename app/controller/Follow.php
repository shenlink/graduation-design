<?php

namespace app\controller;

use core\lib\Controller;


class Follow extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    // 确认关注
    public function checkFollow()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['author']) && isset($_POST['username'])) {
            $author = $_POST['author'];
            $username = $_POST['username'];
            $result =  $this->follow->checkFollow($author, $username);
            if ($result) {
                $cancel = $this->follow->cancelFollow($author, $username);
                if ($cancel) {
                    echo "0";
                }
            } else {
                date_default_timezone_set('PRC');
                $follow_at = date('Y-m-d H:i:s', time());
                $add = $this->follow->addFollow($author, $username, $follow_at);
                if ($add) {
                    echo "1";
                }
            }
        } else {
            $this->displayNone();
        }
    }

    public function delFollow()
    {
        if (isset($_POST['author']) && isset($_POST['username'])) {
            $author = $_POST['author'];
            $username = $_POST['username'];
            $result =  $this->follow->cancelFollow($author, $username);
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
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }
}