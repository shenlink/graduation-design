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
        if (isset($_POST['author'])) {
            $author = $_POST['author'];
            $result =  $this->follow->checkFollow($author, $this->username);
            if ($result) {
                $cancel = $this->follow->cancelFollow($author, $this->username);
                echo $cancel ? '0' : '00';
            } else {
                date_default_timezone_set('PRC');
                $follow_at = date('Y-m-d H:i:s', time());
                $add = $this->follow->addFollow($author, $this->username, $follow_at);
                echo $add ? '1' : '11';
            }
        } else {
            $this->displayNone();
        }
    }

    public function delFollow()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['author'])) {
            $author = $_POST['author'];
            $result =  $this->follow->cancelFollow($author, $this->username);
            echo $result ? '1' : '0';
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