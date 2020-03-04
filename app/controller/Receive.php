<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Receive extends Controller
{
    public function delReceive()
    {
        if (isset($_POST['receive_id'])) {
            $receive_id = $_POST['receive_id'];
            $receive  =  Factory::createReceive();
            $result = $receive->delReceive($receive_id);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        }else{
            $view = Factory::createView();
            $view->display('error.html');
        }
    }
}