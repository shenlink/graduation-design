<?php


namespace core\lib;

use app\model\Announcement;
use app\model\Article;
use app\model\Category;
use app\model\Collect;
use app\model\Comment;
use app\model\Follow;
use app\model\Message;
use app\model\Praise;
use app\model\Share;
use app\model\Receive;
use app\model\User;
use core\lib\Db;
use core\lib\View;
use core\lib\RegisterTree;



//工厂模式
class Factory
{

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

    public static function createMessage()
    {
        // 单例模式
        $key = 'message';
        $message = RegisterTree::get($key);
        if (!$message) {
            $message = Message::getInstance();
            //注册树模式
            RegisterTree::set('message', $message);
        }
        return $message;
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

    public static function createReceive()
    {
        // 单例模式
        $key = 'receive';
        $receive = RegisterTree::get($key);
        if (!$receive) {
            $receive = Receive::getInstance();
            //注册树模式
            RegisterTree::set('receive', $receive);
        }
        return $receive;
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
}
