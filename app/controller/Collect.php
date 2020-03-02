<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Collect extends Controller
{

    // 显示404页面
    public function displayNone()
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }

    public function checkCollect()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['username']) && isset($_POST['article_id']) && isset($_POST['author']) && isset($_POST['title'])) {
            $username = $_POST['username'];
            $article_id = $_POST['article_id'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $collect =  Factory::createCollect();
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

    public function delCollect()
    {
        if (isset($_POST['collect_id'])) {
            $collect_id = $_POST['collect_id'];
            $collect =  Factory::createCollect();
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

}