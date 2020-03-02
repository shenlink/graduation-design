<?php


namespace core\lib;

use core\lib\Db;
use core\lib\View;
use app\model\User;
use core\lib\Pagination;
use app\model\Article;
use app\model\Category;
use core\lib\RegisterTree;


//工厂模式
class Factory
{
    public static function createDatabase()
    {
        // 单例模式
        $key = 'shen';
        $db = RegisterTree::get($key);
        if (!$db) {
            $db = Db::getInstance();
            //注册树模式
            RegisterTree::set('shen', $db);
        }
        return $db;
    }
    public static function createView()
    {
        // 单例模式
        $key = 'view';
        $view = RegisterTree::get($key);
        if (!$view) {
            $view = View::getInstance();
            //注册树模式
            RegisterTree::set('view', $view);
        }
        return $view;
    }
    public static function createUser()
    {
        // 单例模式
        $key = 'user';
        $user = RegisterTree::get($key);
        if (!$user) {
            $user = User::getInstance();
            //注册树模式
            RegisterTree::set('user', $user);
        }
        return $user;
    }
    public static function createPagination()
    {
        // 单例模式
        $key = 'pagination';
        $pagination = RegisterTree::get($key);
        if (!$pagination) {
            $pagination = Pagination::getInstance();
            //注册树模式
            RegisterTree::set('pagination', $pagination);
        }
        return $pagination;
    }
    
    public static function createArticle()
    {
        // 单例模式
        $key = 'article';
        $article = RegisterTree::get($key);
        if (!$article) {
            $article = Article::getInstance();
            //注册树模式
            RegisterTree::set('article', $article);
        }
        return $article;
    }
    public static function createCategory()
    {
        // 单例模式
        $key = 'category';
        $category = RegisterTree::get($key);
        if (!$category) {
            $category = Category::getInstance();
            //注册树模式
            RegisterTree::set('category', $category);
        }
        return $category;
    }

}
