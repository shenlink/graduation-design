<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Praise extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    // 确认点赞
    public function checkPraise()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['author']) && isset($_POST['title'])) {
            $article_id = $_POST['article_id'];
            $username = $_POST['username'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $praise =  Factory::createPraise();
            $result =  $praise->checkPraise($article_id,$username);
            if ($result) {
                $cancel = $praise->cancelPraise($article_id, $username);
                if ($cancel) {
                    echo "0";
                }else{
                    echo '00';
                }
            } else {
                date_default_timezone_set('PRC');
                $praise_at = date('Y-m-d H:i:s', time());
                $add = $praise->addPraise($article_id, $author, $title, $username, $praise_at);
                if ($add) {
                    echo "1";
                }else{
                    echo '11';
                }
            }
        } else {
            echo '404';
            // $this->displayNone();
        }
    }

    public function delPraise()
    {
        if (isset($_POST['article_id']) && isset($_POST['praise_id'])) {
            $article_id = $_POST['article_id'];
            $praise_id = $_POST['praise_id'];
            $praise =  Factory::createPraise();
            $result = $praise->delPraise($article_id, $praise_id);
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
