<?php

namespace app\controller;

use core\lib\Controller;

class Receive extends Controller
{
    // 显示404页面
    public function displayNone()
    {
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }

    public function delReceive()
    {
        if (isset($_POST['receive_id'])) {
            $receive_id = $_POST['receive_id'];
            $result = $this->receive->delReceive($receive_id);
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
        // 显示404页面
        $this->view->assign('error', 'error');
        $this->view->display('error.html');
    }
}
