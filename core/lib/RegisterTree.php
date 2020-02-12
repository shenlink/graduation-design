<?php
namespace core\lib;

class RegisterTree{
    private static $objects=array();
    // 与工厂模式共用
    public static function get($name)
    {
        //获取对象
        return self::$objects[$name];
    }
    public static function set($alias,$object){
        //设置对象
        self::$objects[$alias]=$object;
    }
    public static function remove($alias){
        //移除对象
        unset(self::$objects[$alias]);
    }
}