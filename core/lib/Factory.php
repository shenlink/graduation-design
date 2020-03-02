<?php


namespace core\lib;

use core\lib\Db;
use core\lib\View;
use app\model\User;
use app\model\Article;
use app\model\Category;
use app\model\Collect;
use app\model\Comment;
use app\model\Information;
use app\model\Praise;
use app\model\Share;
use app\model\Follow;
use app\model\Announcement;
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

    public static function createCollect()
    {
        // 单例模式
        $key = 'collect';
        $collect = RegisterTree::get($key);
        if (!$collect) {
            $collect = Collect::getInstance();
            //注册树模式
            RegisterTree::set('collect', $collect);
        }
        return $collect;
    }

    public static function createComment()
    {
        // 单例模式
        $key = 'comment';
        $comment = RegisterTree::get($key);
        if (!$comment) {
            $comment = Comment::getInstance();
            //注册树模式
            RegisterTree::set('comment', $comment);
        }
        return $comment;
    }

    public static function createInformation()
    {
        // 单例模式
        $key = 'information';
        $information = RegisterTree::get($key);
        if (!$information) {
            $information = Information::getInstance();
            //注册树模式
            RegisterTree::set('information', $information);
        }
        return $information;
    }

    public static function createPraise()
    {
        // 单例模式
        $key = 'praise';
        $praise = RegisterTree::get($key);
        if (!$praise) {
            $praise = Praise::getInstance();
            //注册树模式
            RegisterTree::set('praise', $praise);
        }
        return $praise;
    }

    public static function createShare()
    {
        // 单例模式
        $key = 'share';
        $share = RegisterTree::get($key);
        if (!$share) {
            $share = Share::getInstance();
            //注册树模式
            RegisterTree::set('share', $share);
        }
        return $share;
    }

    public static function createFollow()
    {
        // 单例模式
        $key = 'follow';
        $follow = RegisterTree::get($key);
        if (!$follow) {
            $follow = Follow::getInstance();
            //注册树模式
            RegisterTree::set('follow', $follow);
        }
        return $follow;
    }

    public static function createAnnouncement()
    {
        // 单例模式
        $key = 'announcement';
        $announcement = RegisterTree::get($key);
        if (!$announcement) {
            $announcement = Announcement::getInstance();
            //注册树模式
            RegisterTree::set('announcement', $announcement);
        }
        return $announcement;
    }
}
