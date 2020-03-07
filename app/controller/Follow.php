<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;


class Follow extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->assign('error', 'error');
        $view->display('error.html');
    }

    // 确认关注
    public function checkFollow()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['author']) && isset($_POST['username'])) {
            $author = $_POST['author'];
            $username = $_POST['username'];
            $follow =  Factory::createFollow();
            $result =  $follow->checkFollow($author, $username);
            if ($result) {
                $cancel = $follow->cancelFollow($author, $username);
                if ($cancel) {
                    echo "0";
                }
            } else {
                date_default_timezone_set('PRC');
                $follow_at = date('Y-m-d H:i:s', time());
                $add = $follow->addFollow($author, $username, $follow_at);
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
            $follow =  Factory::createFollow();
            $result =  $follow->cancelFollow($author, $username);
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
        $view->assign('error', 'error');
        $view->display('error.html');
    }
}