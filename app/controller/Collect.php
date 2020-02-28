<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Collect extends Controller
{
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
            $view = Factory::createView();
            $view->display('notfound.html');
        }
    }
}
