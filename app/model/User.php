<?php

namespace app\model;

use core\lib\Model;

class User extends Model
{
    private static $user;
    public static function getInstance()
    {
        if (self::$user) {
            return self::$user;
        } else {
            self::$user = new self();
            return self::$user;
        }
    }


    // 在用户注册的时候，用户输入完成后，输入框失去焦点时，执行此方法，告诉用户此用户名是否被注册了
    public function checkUsername($username)
    {
        // $_POST变量是超全局变量，可以直接在模型类获取表单提交的数据，但是，不提倡这么做，因为本来表单是提交到控制器的，表单传过来的值应该由控制器传到模型类中
        // 这个$this是Model类的对象
        return $this->table('user')->where(array('username' => "{$username}"))->select();
    }

    // 处理注册操作
    public function checkRegister($username, $password)
    {
        return $this->table('user')->insert(array('username' => "{$username}", 'password' => "{$password}"));
    }

    // 处理登录操作
    public function checkLogin($username, $password)
    {
        return $this->table('user')->where(array('username' => "{$username}", 'password' => "{$password}"))->select();
    }

    // 处理用户在写文章页面提交的数据
    public function checkWrite($title, $content, $category)
    {
        return $this->table('article')->insert(['title'=>"{$title}",'content'=>"{$content}",'category'=>"{$category}"]);
    }

    // 获取单个用户的所有信息
    public function getUsername($username)
    {
        return $this->table('user')->field('username')->where(['username'=>"{$username}"])->select();
    }

    // 获取个人页面的用户信息
    public function personal($username)
    {
        return $this->table('user')->field('username,created_at,introduction,article_count,follows_count,fans_count')->where(['username'=>"{$username}"])->select();
    }

    // 处理用户提交的私信数据
    public function checkInformation($author, $username, $content)
    {
        return $this->table('information')->insert(['author'=>"{$author}",'username'=>"{$username}",'content'=>"{$content}"]);
    }

    // 处理用户在个人信息修改页面提交的数据
    public function checkChange($username, $password, $introduction)
    {
        return $this->table('user')->where(['username'=>"{$username}"])->update(['password'=>"{$password}",'introduction'=>"{$introduction}"]);
    }

    // 处理管理员拉黑用户
    public function defriendUser($user_id)
    {
        return $this->table('user')->where(['user_id'=>"{$user_id}"])->update(['status' => 0]);
    }

    // 处理管理员恢复用户的状态到正常
    public function normalUser($user_id)
    {
        return $this->table('user')->where(['user_id' => "{$user_id}"])->update(['status' => 1]);
    }

    // 处理管理员删除用户
    public function delUser($user_id)
    {
        return $this->table('user')->where(['user_id' => "{$user_id}"])->delete();
    }
}