<?php

namespace app\model;

use core\lib\Log;
use core\lib\Model;

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

    public function getCategory()
    {
        return $this->table('category')->field('category')->where(['status' => 1])->selectAll();
    }

    public function checkCategory($category)
    {
        return $this->table('category')->field('category')->where(['category' => "{$category}"])->select();
    }

    //处理删除分类
    public function delCategory($category)
    {
        return $this->table('category')->where(['category' => "{$category}"])->delete();
    }

    // 处理管理员拉黑分类
    public function defriendCategory($category)
    {
        $pdo = $this->init();
        try {
            $pdo->beginTransaction();
            $categorySql = "update category set status = 0 where `category` = ?";
            $stmt = $pdo->prepare($categorySql);
            $stmt->bindParam(1, $category);
            $stmt->execute();
            $articleSql = "update article set status = 0 where category=?";
            $stmt = $pdo->prepare($articleSql);
            $stmt->bindParam(1, $category);
            $stmt->execute();
            $pdo->commit();
            return true;
        } catch (\PDOException $e) {
            Log::init();
            session_start();
            $username = $_SESSION['username'];
            Log::log("用户{$username}:" . '执行sql语句发生错误:' . $e->getMessage());
            $pdo->rollBack();
            return false;
        }
    }

    // 处理管理员恢复分类的状态到正常
    public function normalCategory($category)
    {
        $pdo = $this->init();
        try {
            $pdo->beginTransaction();
            $categorySql = "update category set status = 1 where `category` = ?";
            $stmt = $pdo->prepare($categorySql);
            $stmt->bindParam(1, $category);
            $stmt->execute();
            $articleSql = "update article set status = 1 where category=?";
            $stmt = $pdo->prepare($articleSql);
            $stmt->bindParam(1, $category);
            $stmt->execute();
            $pdo->commit();
            return true;
        } catch (\PDOException $e) {
            Log::init();
            session_start();
            $username = $_SESSION['username'];
            Log::log("用户{$username}:" . '执行sql语句发生错误:' . $e->getMessage());
            $pdo->rollBack();
            return false;
        }
    }

    // 处理添加分类
    public function addCategory($categoryName)
    {
        return $this->table('category')->insert(['category' => "{$categoryName}"]);
    }

    public function getAllCategory($currentPage = 1, $pageSize)
    {
        return $this->table('category')->field('category_id,category,status,article_count')->where('status = 1  or status =0')->pages($currentPage, $pageSize, '/admin/manage', 'category');
    }
}
