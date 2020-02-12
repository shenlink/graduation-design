<?php

namespace core\lib;
use core\lib\Factory;

include_once Shen . '/core/common/smarty/Smarty.class.php';
class View
{
    // private static $view = null;
    public $assign = array();
    public function __construct()
    {
        return Factory::createView();
    }
    // private function __clone()
    // {

    // }
    // public static function getInstance()
    // {
    //     // if (self::$view == null) {
    //     //     self::$view = new self();
    //     // }
    //     // return self::$view;
    // }

    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }
    public function display($file)
    {
        $file = APP . '/view/' . $file;
        if (is_file($file)) {
            $smarty = new \Smarty();
            $smarty->caching = false;
            $smarty->template_dir = APP.'/view';
            $smarty->compile_dir = Shen.'/runtime/smarty/templates_c';
            $smarty->cache_dir = Shen."/runtime/smarty/cache";
            $smarty->cache_lifetime = 60;
            $smarty->left_delimiter = "{";
            $smarty->right_delimiter = "}";
            $smarty->assign($this->assign);
            $smarty->display($file);
        }
    }
}
