<?php
namespace core\common;

class Loader
{
    public static $classMap = array();
    public static function autoload($class)
    {
        $class = str_replace('\\', '/', $class);
        $file = SHEN . '/' . $class . '.php';
        if (is_file($file)) {
            include $file;
            self::$classMap[$class] = $class;
        } else {
            return false;
        }
    }
}