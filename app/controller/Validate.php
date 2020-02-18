<?php

namespace app\controller;

use core\lib\Controller;


class Validate extends Controller
{
    private static $access;
    public static function checkAccess()
    {
        session_start();
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $validate = new \app\model\Validate();
            $access = $validate->checkValidate($username);
            $access = $access['access_id'];
            self::$access = $access;
        } else {
            self::$access = '3';
        }
        return self::$access;
    }
}