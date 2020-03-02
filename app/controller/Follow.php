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
        $view->display('notfound.html');
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
}