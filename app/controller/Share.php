<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Share extends Controller
{
    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
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
            $share =  Factory::createShare();
            $result =  $share->checkShare($username, $article_id);
            if ($result) {
                $cancel = $share->cancelShare($username, $article_id);
                if ($cancel) {
                    echo "0";
                }
            } else {
                date_default_timezone_set('PRC');
                $share_at = date('Y-m-d H:i:s', time());
                $add = $share->addShare($article_id, $author, $title, $username, $share_at);
                if ($add) {
                    echo "1";
                }
            }
        } else {
            $this->displayNone();
        }
    }

    public function delShare()
    {
        if (isset($_POST['share_id']) && isset($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
            $share_id = $_POST['share_id'];
            $share =  Factory::createShare();
            $result = $share->delShare($article_id,$share_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->displayNone();
        }
    }
}