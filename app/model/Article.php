<?php

namespace app\model;

use core\lib\Model;

class Article extends Model
{
    private static $article;
    public static function getInstance()
    {
        if (self::$article) {
            return self::$article;
        } else {
            self::$article = new self();
            return self::$article;
        }
    }
    public function index()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->selectAll();
    }
    public function php()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->where(['category_id'=>1])->selectAll();
    }
    public function mysql()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->where(['category_id' => 2])->selectAll();
    }
    public function javaScript()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->where(['category_id' => 3])->selectAll();
    }
    public function html()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->where(['category_id' => 4])->selectAll();
    }
    public function python()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->where(['category_id' => 5])->selectAll();
    }
    public function java()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->where(['category_id' => 6])->selectAll();
    }
    public function foundation()
    {
        return $this->table('article')->field('title, content,created_at,collect_count,comment_count')->where(['category_id' => 7])->selectAll();
    }
}