<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;


class Validate extends Controller
{
    private static $access;
    public static function checkAccess()
    {
        session_start();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $validate = new \app\model\Validate();
            $urls = $validate->checkValidate($username);
            $urls = explode(',', $urls);
            foreach ($urls as $value) {
                if ($value == '/admin/manage') {
                    self::$access = '1';
                    break;
                } else if ($value == '/user/write') {
                    self::$access = '2';
                    break;
                }
            }
        } else {
            self::$access = '3';
        }
        if ($_SERVER['REQUEST_URI'] == '/validate/checkaccess') {
            $view = Factory::createView();
            $view->display('noadmin.html');
        }
        return self::$access;
    }
    public function __call($method, $args)
    {
        $view = Factory::createView();
        $view->display('notfound.html');
    }
}
