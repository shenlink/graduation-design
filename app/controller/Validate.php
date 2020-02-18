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
            $urls = $validate->checkValidate($username);
            $urls = explode(',', $urls);
            foreach ($urls as $key => $value) {
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
        return self::$access;
    }
}
