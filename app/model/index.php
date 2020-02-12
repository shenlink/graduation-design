<?php

namespace app\model;

use core\lib\Model;

class Index extends Model
{
    public function user(){
        return $this->table('user')->select();
    }
}
