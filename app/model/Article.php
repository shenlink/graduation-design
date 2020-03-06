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

    // 处理搜索
    public function search($content)
    {
        $content = '%' . $content . '%';
        return $this->table('article')->field('title,content,created_at,collect_count,comment_count')->where("content like \"{$content}\" or title like \"{$content}\"")->selectAll();
    }

    public function checkArticleId($article_id)
    {
        return $this->table('article')->field('article_id')->where(['article_id' => "{$article_id}"])->select();
    }

    public function getAuthor($article_id)
    {
        return $this->table('article')->field('author')->where(['article_id' => "{$article_id}"])->select();
    }

    // 获取某一篇文章的数据
    public function getArticle($article_id)
    {
        return $this->table('article')->field('article_id,title,content,author,created_at,category,comment_count,praise_count,collect_count')->where(['article_id' => "{$article_id}", 'status' => 1])->select();
    }

    // 获取个人页面的文章数据
    public function personal($author)
    {
        return $this->table('article')->field('article_id,author,title,content,created_at,category,comment_count,praise_count,collect_count')->where(['author' => "{$author}", 'status' => 1])->order('created_at desc')->selectAll();
    }

    // 获取用户管理页面的文章数据
    public function manage($username)
    {
        return $this->table('article')->field('article_id,title,status,created_at,updated_at,category,comment_count,praise_count,collect_count,share_count')->where(['author' => "{$username}"])->order('article_id')->selectAll();
    }

    // 查询article表中的数据
    public function getAllArticle()
    {
        return $this->table('article')->field('article_id,author,title,status,created_at,category,comment_count,praise_count,collect_count')->selectAll();
    }

    public function getCategoryArticle($category)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => "{$category}", 'status' => 1])->selectAll();
    }


    // 拉黑某篇文章
    public function defriendArticle()
    {
        return $this->table('article')->field('status')->update(['status' => 0]);
    }

    public function normalArticle()
    {
        return $this->table('article')->field('status')->update(['status' => 1]);
    }

    // 处理用户编辑文章页面传来的数据
    public function checkEdit($article_id, $category, $title, $content, $updated_at)
    {
        return $this->table('article')->where(['article_id' => "{$article_id}"])->update(['category' => "{$category}", 'title' => "{$title}", 'content' => "{$content}", 'updated_at' => "{$updated_at}"]);
    }

    // 处理删除文章
    public function delArticle($article_id, $author, $category)
    {
        $articles = $this->table('article')->where(['article_id' => "{$article_id}"])->delete();
        $users =  $this->table('user')->field('article_count')->where(['username' => "{$author}"])->update('article_count = article_count-1');
        $categorys =  $this->table('category')->field('article_count')->where(['category' => "{$category}"])->update('article_count = article_count-1');
        return $articles && $users && $categorys;
    }

    // 获取所有被管理员推荐的文章
    public function recommend()
    {
        return $this->table('article')->field('article_id,title')->where(['recommend' => 1, 'status' => 1])->order('created_at desc')->selectAll();
    }

    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstPage()
    {
        return $this->table('article')->field('article_id,author,category,title,content,created_at,collect_count,comment_count,praise_count')->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changePage($currentPage, $pageSize)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count,status')->where(['status' => 1])->pages($currentPage, $pageSize);
    }

    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstManagePage($username)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count,status')->where(['author' => "{$username}"])->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changeManagePage($username, $currentPage, $pageSize)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count,status')->where(['username' => "{$username}"])->pages($currentPage, $pageSize);
    }

    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstUserPage($username)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count,status')->where(['author' => "{$username}"])->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changeUserPage($username, $currentPage, $pageSize)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count,status')->where(['username' => "{$username}"])->pages($currentPage, $pageSize);
    }

    // 处理用户在写文章页面提交的数据
    public function checkWrite($author, $category, $title, $content,  $created_at)
    {
        $articles = $this->table('article')->insert(['title' => "{$title}", 'content' => "{$content}", 'category' => "{$category}", 'author' => "{$author}", 'created_at' => "{$created_at}"]);
        $users =  $this->table('user')->field('article_count')->where(['username' => "{$author}"])->update('article_count = article_count+1');
        $categorys =  $this->table('category')->field('article_count')->where(['category' => "{$category}"])->update('article_count = article_count+1');
        return $articles && $users && $categorys;
    }


    public function changeCategoryPage($category, $currentPage, $pageSize)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => "{$category}", 'status' => 1])->pages($currentPage, $pageSize);
    }

    public function firstCategoryPage($category)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => "{$category}", 'status' => 1])->pages(1, 5);
    }
}
