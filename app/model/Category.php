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
        $php = Factory::createArticle();
        $data = $php->php();
        return $data;
    }

    public function mysql()
    {
        $mysql = Factory::createArticle();
        $data = $mysql->mysql();
        return $data;
    }

    public function javaScript()
    {
        $javaScript = Factory::createArticle();
        $data = $javaScript->javaScript();
        return $data;
    }

    public function html()
    {
        $html = Factory::createArticle();
        $data = $html->html();
        return $data;
    }

    public function python()
    {
        $python = Factory::createArticle();
        $data = $python->python();
        return $data;
    }

    public function java()
    {
        $java = Factory::createArticle();
        $data = $java->java();
        return $data;
    }

    public function foundation()
    {
        $foundation = Factory::createArticle();
        $data = $foundation->foundation();
        return $data;
    }
}