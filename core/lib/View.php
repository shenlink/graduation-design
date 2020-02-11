<?php

namespace core\lib;

include_once Shen . '/core/common/smarty/Smarty.class.php';
class View
{
    public $assign=array();
    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }
    public function display($file)
    {
        $file = APP . 'view' . $file;
        if (is_file($file)) {
            extract($this->assign);
            include $file;
        }
    }
}
