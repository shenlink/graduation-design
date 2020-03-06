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

    public function getCategory()
    {
        return $this->table('category')->field('category')->where(['status' => 1])->selectAll();
    }

    public function checkCategory($category)
    {
        return $this->table('category')->field('category')->where(['category' => "{$category}"])->select();
    }

    //处理删除分类
    public function delCategory($category)
    {
        return $this->table('category')->where(['category' => "{$category}"])->delete();
    }

    // 处理管理员拉黑分类
    public function defriendcategory($category)
    {
        return $this->table('category')->where(['category' => "{$category}"])->update(['status' => 0]);
    }

    // 处理管理员恢复分类的状态到正常
    public function normalCategory($category)
    {
        return $this->table('category')->where(['category' => "{$category}"])->update(['status' => 1]);
    }

    // 处理添加分类
    public function addCategory($categoryName)
    {
        return $this->table('category')->insert(['category' => "{$categoryName}"]);
    }


    public function getAllCategory($currentPage = 1, $pageSize = 5)
    {
        return $this->table('category')->field('category_id,category,status,article_count')->pages($currentPage, $pageSize, 'category');
    }

    public function firstUserPage($username, $currentPage=1, $pageSize=5)
    {
        return $this->table('category')->field('category_id,category,status,article_count')->where(['status' => 1, 'username' => "{$username}"])->pages($currentPage, $pageSize,'category');
    }
}
