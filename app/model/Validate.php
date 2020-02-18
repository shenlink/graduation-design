<?php

namespace app\model;

use core\lib\Model;

class Validate extends Model
{
    public function checkValidate($username)
    {
        // 判断出这个role有哪些权限，返回即可
        $role = $this->table('user_role')->field('role_id')->where(['username'=>"{$username}"])->select();

        $role = $role['role_id'];
        $access = $this->table('role_access')->field('access_id')->where(['role_id'=>"{$role}"])->select();
        return $access;
    }
}