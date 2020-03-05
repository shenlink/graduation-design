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

    // 获取所有用户的文章的评论数据
    public function manage($username)
    {
        return $this->table('comment')->field('comment_id,content,article_id,username,comment_at')->where(['username' => "{$username}"])->selectAll();
    }

    // 处理删除评论
    public function delComment($article_id, $comment_id)
    {
        $comments = $this->table('comment')->where(['comment_id' => "{$comment_id}"])->delete();
        $articles =  $this->table('article')->where(['article_id' => "{$article_id}"])->update('comment_count = comment_count-1');
        return $comments && $articles;
    }

    // 处理添加评论
    public function addComment($article_id, $author, $title, $content, $username, $comment_at)
    {
        $comments = $this->table('comment')->insert(['article_id' => "{$article_id}", 'author' => "{$author}", 'title' => "{$title}", 'content' => "{$content}", 'username' => "{$username}", 'comment_at' => "{$comment_at}"]);
        $articles =  $this->table('article')->where(['article_id' => "{$article_id}"])->update('comment_count = comment_count+1');
        return $comments && $articles;
    }

    // 处理每篇文章要获取的评论
    public function getArticleComment($article_id)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['article_id' => "{$article_id}"])->order('comment_at desc')->selectAll();
    }

    public function getComment($username)
    {
        return $this->table('comment')->field('comment_id,content,article_id,title,author,username,comment_at')->where(['username' => "{$username}"])->order('comment_at desc')->selectAll();
    }

    // 查询comment表中的数据
    public function getAllComment()
    {
        return $this->table('comment')->field('article_id,comment_id,content,status,username,comment_at')->selectAll();
    }




    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstPage()
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1])->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changePage($currentPage, $pageSize)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1])->pages($currentPage, $pageSize);
    }

    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstUserPage($username)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1, 'username' => "{$username}"])->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changeUserPage($username, $currentPage, $pageSize)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1, 'username' => "{$username}"])->pages($currentPage, $pageSize);
    }

    // 当用户访问首页时，执行此方法,感觉这个方法可以和下面的方法合二为一
    public function firstManagePage($username)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1, 'username' => "{$username}"])->pages(1, 5);
    }

    // 当用户点击首页下的页码时，执行此方法
    public function changeManagePage($username, $currentPage, $pageSize)
    {
        return $this->table('comment')->field('comment_id,content,username,comment_at')->where(['status' => 1, 'username' => "{$username}"])->pages($currentPage, $pageSize);
    }
}
