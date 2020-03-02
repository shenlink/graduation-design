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

    public function getArticle($category)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => "{$category}"])->selectAll();
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


}
