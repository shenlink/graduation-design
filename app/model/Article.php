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
        $pdo = $this->init();
        try {
            $pdo->beginTransaction();
            $articleSql = "delete from article where article_id=?";
            $stmt = $pdo->prepare($articleSql);
            $stmt->bindParam(1, $article_id);
            $stmt->execute();
            $userSql = "update user set article_count=article_count-1 where username=?";
            $stmt = $pdo->prepare($userSql);
            $stmt->bindParam(1, $author);
            $stmt->execute();
            $categorySql = "update category set article_count=article_count-1 where category=?";
            $stmt = $pdo->prepare($categorySql);
            $stmt->bindParam(1, $category);
            $stmt->execute();
            $pdo->commit();
            return true;
        } catch (\PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }

    // 获取所有被管理员推荐的文章
    public function recommend()
    {
        return $this->table('article')->field('article_id,title')->where(['recommend' => 1, 'status' => 1])->order('created_at desc')->selectAll();
    }

    public function getAllArticle($currentPage=1, $pageSize=5)
    {
        return $this->table('article')->field('article_id,author,category,title,content,created_at,collect_count,comment_count,praise_count')->pages($currentPage, $pageSize, 'article');
    }


    public function getManageArticle($username, $currentPage = 1, $pageSize = 5)
    {
        return $this->table('article')->field('article_id,title,content,category,created_at,collect_count,praise_count,comment_count,share_count,status')->where(['author' => "{$username}"])->pages($currentPage, $pageSize, 'article');
    }

    public function getUserArticle($username, $currentPage = 1, $pageSize = 5)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count,status')->where(['author' => "{$username}"])->pages($currentPage, $pageSize, 'article');
    }

    // 处理用户在写文章页面提交的数据
    public function checkWrite($author, $category, $title, $content,  $created_at)
    {
        $pdo = $this->init();
        try {
            $pdo->beginTransaction();
            $shareSql = "insert into article (author,category,title,content,created_at) values (?,?,?,?,?)";
            $stmt = $pdo->prepare($shareSql);
            $stmt->bindParam(1, $author);
            $stmt->bindParam(2, $category);
            $stmt->bindParam(3, $title);
            $stmt->bindParam(4, $content);
            $stmt->bindParam(5, $created_at);
            $stmt->execute();
            $userSql = "update user set article_count=article_count+1 where username=?";
            $stmt = $pdo->prepare($userSql);
            $stmt->bindParam(1, $author);
            $stmt->execute();
            $userSql = "update category set article_count=article_count+1 where category=?";
            $stmt = $pdo->prepare($userSql);
            $stmt->bindParam(1, $category);
            $stmt->execute();
            $pdo->commit();
            return true;
        } catch (\PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }


    public function getCategoryArticle($category, $currentPage = 1, $pageSize = 5)
    {
        return $this->table('article')->field('article_id,title,content,created_at,collect_count,comment_count')->where(['category' => "{$category}", 'status' => 1])->pages($currentPage, $pageSize);
    }
}
