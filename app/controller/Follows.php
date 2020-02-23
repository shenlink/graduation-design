<?php

namespace app\controller;

use core\lib\Controller;

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

                if ($this->cancelFollows($author, $username)) {

                    echo "0";
                }
            } else {

                if ($this->addFollows($author, $username)) {

                    echo "1";
                }
            }
        } else {
        }
    }

    public function cancelFollows($author, $username)
    {
        $follows = new \app\model\Follows();
        $res =  $follows->cancelFollows($author, $username);
        return $res;
    }

    public function addFollows($author, $username)
    {
        $follows = new \app\model\Follows();
        $res =  $follows->addFollows($author, $username);
        return $res;
    }
}