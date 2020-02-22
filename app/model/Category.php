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
    public function php()
    {
        $article = Factory::createArticle();
        $data = $article->php();
        return $data;
    }

    public function mysql()
    {
        $article = Factory::createArticle();
        $data = $article->mysql();
        return $data;
    }

    public function javaScript()
    {
        $article = Factory::createArticle();
        $data = $article->javaScript();
        return $data;
    }

    public function html()
    {
        $article = Factory::createArticle();
        $data = $article->html();
        return $data;
    }

    public function python()
    {
        $article = Factory::createArticle();
        $data = $article->python();
        return $data;
    }

    public function java()
    {
        $article = Factory::createArticle();
        $data = $article->java();
        return $data;
    }

    public function foundation()
    {
        $article = Factory::createArticle();
        $data = $article->foundation();
        return $data;
    }

    public function delCategory($category)
    {
        return $this->table('category')->where(['category' => "{$category}"])->delete();
    }
}