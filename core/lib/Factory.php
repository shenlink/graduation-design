<?php


namespace core\lib;

use core\lib\Db;
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
}
