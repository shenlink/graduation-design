<?php
namespace core\common;

class Loader
{
    public static $classMap = array();
    public static function autoload($class)
    {
        // require Shen . '/' . str_replace('\\', '/', $class) . '.php';

        $class = str_replace('\\', '/', $class);
        $file = Shen . '/' . $class . '.php';
        if (is_file($file)) {
            include $file;
            self::$classMap[$class] = $class;
        } else {
            return false;
        }
    }
}