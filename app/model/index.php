<?php

namespace app\model;

use core\lib\Model;

class index extends Model
{
    public function user(){
        return $this->table('user');
    }
}
