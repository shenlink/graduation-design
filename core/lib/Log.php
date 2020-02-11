<?php

namespace core\lib;

use core\lib\Config;

class log
{

    public static $class;
    /**
     * 1.确定日志的存储方式
     * 2.写日志
     */
    public static function init()
    {
        //确定存储方式
        $driver = Config::get('DRIVER', 'log');
        $class = '\core\lib\driver\log\\' . $driver;
        self::$class = new $class;
    }

    public static function log($name, $file = 'log')
    {
        //调用core\lib\driver下的File类的log方法
        self::$class->log($name, $file);
    }
}
