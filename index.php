<?php


//定义根目录
// define('Shen', $_SERVER['DOCUMENT_ROOT']);
define('Shen',str_replace('\\','/',dirname(realpath(__FILE__))));
define('CORE',Shen.'/core');
define('APP',Shen.'/app');
define('MODULE', 'app');
define('DEBUG', true);

if (DEBUG) {
    ini_set('display_error', 'On');
} else {
    ini_set('display_error', 'Off');
}
include CORE . '/common/function.php';
// 引入自动加载类
include CORE.'/common/Loader.php';


spl_autoload_register('\core\common\Loader::autoload');

\core\common\Start::run();
