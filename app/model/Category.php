<?php

namespace app\model;
use core\lib\Model;
// use core\lib\Factory;

class Category extends Model
{
    public function foundation()
    {
        return $this->table('article')->selectAll();
    }


}