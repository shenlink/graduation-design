<?php

namespace core\lib;

// include_once Shen . '/core/common/smarty/Smarty.class.php';
class View
{

    // public function __construct()
    // {
    //     $smarty = new \Smarty();
    //     //五配置
    //     $smarty->left_delimiter = "{";
    //     $smarty->right_delimiter = "}";
    //     $smarty->template_dir = "tpl";
    //     $smarty->compile_dir = "template_c";
    //     $smarty->cache_dir = "cache";
    //     //开启缓存的另两个配置
    //     $smarty->caching = true;
    //     $smarty->cache_lifetime = 120;
    //     $smarty->display($this->assign);
    // }
    public $assign = array();
    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }
    public function display($file)
    {
        $file = APP . '/view/' . $file;
        if (is_file($file)) {
            extract($this->assign);
            include $file;
        }
    }
}
