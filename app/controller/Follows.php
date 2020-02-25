<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Follows extends Controller
{
    public function checkFollows()
    {
        header("Content-type:text/html;charset=utf-8");
        if (isset($_POST['author']) && isset($_POST['username'])) {
            $author = $_POST['author'];
            $username = $_POST['username'];
            $follows = new \app\model\Follows();
            $res =  $follows->checkFollows($author, $username);
            if ($res) {
                if ($follows->cancelFollows($author, $username)) {
                    echo "取消关注成功";
                } else {
                    echo '取消关注失败';
                }
            } else {
                if ($follows->addFollows($author, $username)) {
                    echo "关注成功";
                } else {
                    echo '关注失败';
                }
            }
        } else {
            $view = Factory::createView();
            $view->display('notfound.html');
        }
    }
}
