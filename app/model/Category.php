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

    // 查询category表中的数据
    public function getAllCategory()
    {
        return $this->table('category')->field('category_id,category,status,article_count')->selectAll();
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






    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstPage()
    {
        return $this->table('category')->field('category_id,category,status,article_count')->where(['status' => 1])->pages(1, 5);

        return $this->table('category')->field('category_id,category,status,article_count')->selectAll();
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changePage($currentPage, $pageSize)
    {
        return $this->table('category')->field('category_id,category,status,article_count')->where(['status' => 1])->pages($currentPage, $pageSize);
    }

    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstUserPage($username)
    {
        return $this->table('category')->field('category_id,category,status,article_count')->where(['status' => 1, 'username' => "{$username}"])->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changeUserPage($username, $currentPage, $pageSize)
    {
        return $this->table('category')->field('category_id,category,status,article_count')->where(['status' => 1, 'username' => "{$username}"])->pages($currentPage, $pageSize);
    }
}
