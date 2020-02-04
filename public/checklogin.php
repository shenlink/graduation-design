<?php
require_once 'Db.php';

$username = trim($_POST['username']);
$password = md5(trim($_POST['password']));
// select * from users where username=username and password = password;
$db = new Db();
$res = $db->table('users')->where(array('username'=>'{$usernaem}','password'=>'{$password}'))->select();
if($res->rowCount == 1){
    echo 1;
}else{
    echo 0;
}
