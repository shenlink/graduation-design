<?php

namespace app\model;

use core\lib\Log;
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

    // 处理搜索
    public function search($condition, $currentPage = 1, $pageSize)
    {
        $content = '%' . $condition . '%';
        return $this->table('article')->field('article_id,title,content,updated_at,collect_count,comment_count')->where("content like \"{$content}\" or title like \"{$content}\"")->pages($currentPage, $pageSize, "/article/search", $condition);
    }

    public function checkArticleId($article_id)
    {
        return $this->table('article')->field('article_id')->where(['article_id' => "{$article_id}", 'status' => 1])->select();
    }

    public function getAuthor($article_id)
    {
        return $this->table('article')->field('author')->where(['article_id' => "{$article_id}"])->select();
    }

    // 获取某一篇文章的数据
    public function getArticle($article_id)
    {
        return $this->table('article')->field('article_id,title,content,author,updated_at,category,comment_count,praise_count,collect_count,share_count')->where(['article_id' => "{$article_id}", 'status' => 1])->select();
    }

    public function getEditArticle($article_id)
    {
        return $this->table('article')->field('article_id,title,content,author,updated_at,category,comment_count,praise_count,collect_count,share_count')->where(['article_id' => "{$article_id}"])->select();
    }

    // 拉黑某篇文章
    public function defriendArticle($article_id)
    {
        return $this->table('article')->field('status')->where(['article_id' => "{$article_id}"])->update(['status' => 0]);
    }

    public function normalArticle($article_id)
    {
        return $this->table('article')->field('status')->where(['article_id' => "{$article_id}"])->update(['status' => 1]);
    }

    // 处理用户编辑文章页面传来的数据
    public function checkEdit($article_id, $category, $title, $content, $updated_at)
    {
        return $this->table('article')->where(['article_id' => "{$article_id}"])->update(['category' => "{$category}", 'title' => "{$title}", 'content' => "{$content}", 'updated_at' => "{$updated_at}"]);
    }

    // 处理删除文章
    public function delArticle($article_id, $author, $category)
    {
        return $this->table('article')->where(['article_id' => "{$article_id}", 'author' => "{$author}"])->delete();
    }

    // 获取所有被管理员推荐的文章
    public function recommend()
    {
        return $this->table('article')->field('article_id,title')->where(['status' => 1])->order('comment_count desc')->limit(10)->selectAll();
    }

    public function getIndexArticle($currentPage = 1, $pageSize, $type)
    {
        return $this->table('article')->field('article_id,author,category,status,title,content,updated_at,collect_count,comment_count,praise_count')->where(['status' => 1])->order('updated_at desc')->pages($currentPage, $pageSize, '/index/index', $type);
    }

    public function getAllArticle($currentPage = 1, $pageSize)
    {
        return $this->table('article')->field('article_id,author,category,status,title,content,updated_at,collect_count,comment_count,praise_count')->order('updated_at desc')->pages($currentPage, $pageSize, '/admin/manage', 'article');
    }

    public function getManageArticle($username, $currentPage = 1, $pageSize)
    {
        return $this->table('article')->field('article_id,title,content,category,updated_at,updated_at,collect_count,praise_count,comment_count,share_count,status')->where(['author' => "{$username}"])->pages($currentPage, $pageSize, '/user/manage', 'article');
    }

    public function getUserArticle($username, $currentPage = 1, $pageSize)
    {
        return $this->table('article')->field('article_id,title,content,updated_at,collect_count,comment_count,status')->where(['author' => "{$username}"])->order('updated_at desc')->pages($currentPage, $pageSize, "/user/{$username}", 'article');
    }

    public function getRecentArticle($author)
    {
        return $this->table('article')->field('article_id,title')->where(['author' => "{$author}"])->order('updated_at desc')->limit(5)->selectAll();
    }

    // 处理用户在写文章页面提交的数据
    public function checkWrite($author, $category, $title, $content,   $updated_at)
    {
        return $this->table('article')->insert(['author' => "{$author}", 'title' => "{$title}", 'content' => "{$content}", 'category' => "{$category}", 'updated_at' => "{$updated_at}"]);
    }

    public function getCategoryArticle($category, $currentPage = 1, $pageSize)
    {
        return $this->table('article')->field('article_id,title,content,updated_at,collect_count,comment_count')->where(['category' => "{$category}", 'status' => 1])->order('updated_at desc')->pages($currentPage, $pageSize, "/category/{$category}");
    }
}
