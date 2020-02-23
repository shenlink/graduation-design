<?php

namespace app\model;
use core\lib\Model;
use core\lib\Factory;

class Category extends Model
{
    private static $category;
    public static function getInstance()
    {
        if (self::$category) {
            return self::$category;
        } else {
            self::$category = new self();
            return self::$category;
        }
    }

    public function addCategory($category)
    {
        return $this->table('category')->insert(['category' => "{$category}"]);
    }

    public function delCategory($category)
    {
        return $this->table('category')->where(['category' => "{$category}"])->delete();
    }
}