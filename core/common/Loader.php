<?php
namespace core\common;

class Loader
{
    static function autoload($class)
    {
        require Shen.'/'.str_replace('\\', '/', $class).'.php';
    }
}