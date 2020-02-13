<?php


namespace core\lib;

use core\lib\Db;
use core\lib\View;
// use core\lib\
use core\lib\RegisterTree;


//工厂模式
class Factory
{
    public static function createDatabase()
    {
        // 单例模式
        $key = 'shen';
        $db = RegisterTree::get($key);
        if (!$db) {
            $db = Db::getInstance();
            //注册树模式
            RegisterTree::set('shen', $db);
        }
        return $db;
    }
    public static function createView()
    {
        // 单例模式
        $key = 'view';
        $view = RegisterTree::get($key);
        if (!$view) {
            $view = View::getInstance();
            //注册树模式
            RegisterTree::set('view', $view);
        }
        return $view;
    }
    public static function createUser()
    {
        // 单例模式
        $key = 'user';
        $user = RegisterTree::get($key);
        if (!$user) {
            $view = User::getInstance();
            //注册树模式
            RegisterTree::set('user', $user);
        }
        return $user;
    }

}
