<?php


//定义根目录
define('Shen', __DIR__);
// 引入自动加载类
include Shen.'/core/Loader.php';

spl_autoload_register('\\IMooc\\Loader::autoload');
