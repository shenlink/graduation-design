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
            $view->display('notfound.html');
            exit();
        }
    }

    public static function checkAccess()
    {
        self::prevent();
        session_start();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $validate = new \app\model\Validate();
            $urls = $validate->checkValidate($username);
            $urls = explode(',', $urls);
            foreach ($urls as $value) {
                if ($value == '/user/write') {
                    self::$access = '2';
                }
                if ($value == '/admin/manage') {
                    self::$access = '1';
                    break;
                }
            }
        } else {
            self::$access = '3';
        }
        return self::$access;
    }

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
