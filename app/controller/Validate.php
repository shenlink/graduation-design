<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;


class Validate extends Controller
{
    private static $access;
    public static function prevent()
    {
        $pattern = '/(validate)|prevent|checkAccess/i';
        $url = $_SERVER['REQUEST_URI'];
        if (preg_match($pattern, $url)) {
            $view = Factory::createView();
            $view->assign('error', 'error');
            $view->display('error.html');
            exit();
        }
    }

    public static function checkAccess()
    {
        self::prevent();
        session_start();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            if ($username == 'shen') {
                self::$access = '1';
            } else {
                self::$access = '2';
            }
        } else {
            self::$access = '3';
        }
        return self::$access;
    }

    public function __call($method, $args)
    {
        // 显示404页面
        $view = Factory::createView();
        $view->assign('error', 'error');
        $view->display('error.html');
    }
}
