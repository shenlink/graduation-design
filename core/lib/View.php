<?php

namespace core\lib;

include_once Shen . '/core/common/smarty/Smarty.class.php';
class View
{
    public $assign = array();
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
