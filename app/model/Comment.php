<?php

namespace app\model;

use core\lib\Model;

class Comment extends Model
{

    private static $comment;
    public static function getInstance()
    {
        if (self::$comment) {
            return self::$comment;
        } else {
            self::$comment = new self();
            return self::$comment;
        }
    }

    // 处理删除评论
    public function delComment($article_id, $comment_id)
    {
        $pdo = $this->init();
        try {
            $pdo->beginTransaction();
            $collectSql = "delete from comment where comment_id=?";
            $stmt = $pdo->prepare($collectSql);
            $stmt->bindParam(1, $comment_id);
            $stmt->execute();
            $articleSql = "update article set comment_count=comment_count-1 where article_id=?";
            $stmt = $pdo->prepare($articleSql);
            $stmt->bindParam(1, $article_id);
            $stmt->execute();
            $pdo->commit();
            return true;
        } catch (\PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }

    // 处理添加评论
    public function addComment($article_id, $author, $title, $content, $username, $comment_at)
    {
        $pdo = $this->init();
        try {
            $pdo->beginTransaction();
            $commentSql = "insert into comment (article_id,author,title,content,username,comment_at) values (?,?,?,?,?,?)";
            $stmt = $pdo->prepare($commentSql);
            $stmt->bindParam(1, $article_id);
            $stmt->bindParam(2, $author);
            $stmt->bindParam(3, $title);
            $stmt->bindParam(4, $content);
            $stmt->bindParam(5, $username);
            $stmt->bindParam(6, $comment_at);
            $stmt->execute();
            $comment_id = $pdo->lastInsertId();
            $articleSql = "update article set comment_count=comment_count+1 where article_id=?";
            $stmt = $pdo->prepare($articleSql);
            $stmt->bindParam(1, $article_id);
            $stmt->execute();
            $pdo->commit();
            return $comment_id;
        } catch (\PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }

    // 处理每篇文章要获取的评论
    public function getArticleComment($article_id)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['article_id' => "{$article_id}"])->order('comment_at desc')->selectAll();
    }

    public function getAllComment($currentPage = 1, $pageSize = 5)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->pages($currentPage, $pageSize, 'comment');
    }


    public function getComment($username, $currentPage = 1, $pageSize = 5)
    {
        return $this->table('comment')->field('comment_id,author,title,content,username,comment_at')->where(['username' => "{$username}"])->pages($currentPage, $pageSize, 'comment');
    }

    public function getShare($username, $currentPage = 1, $pageSize = 5)
    {
        return $this->table('share')->field('share_id,article_id,author,title,share_at')->where(['username' => "{$username}"])->pages($currentPage, $pageSize, 'share');
    }

    public function getCommentCount($username)
    {
        return $this->table('comment')->where(['username' => "{$username}"])->count();
    }

    public function getManageComment($username, $currentPage = 1, $pageSize = 5)
    {
        return $this->table('comment')->field('comment_id,content,username,article_id,comment_at')->where(['username' => "{$username}"])->pages($currentPage, $pageSize, 'comment');
    }
}
