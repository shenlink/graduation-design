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
        return $this->table('category')->field('category')->where(['status' => '正常'])->selectAll();
    }

    public function checkCategory($category)
    {
        return $this->table('category')->field('category')->where(['category' => "{$category}"])->select();
    }

    public function getArticle($category)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => "{$category}"])->selectAll();
    }

    // 处理添加分类
    public function addCategory($category)
    {
        return $this->table('category')->insert(['category' => "{$category}"]);
    }

    //处理删除分类
    public function delCategory($category)
    {
        return $this->table('category')->where(['category' => "{$category}"])->delete();
    }
}
