<?php
require_once 'Db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$db = new Db();
// $sql = 'select * from users where username = :username and password = :password';
$res = $db->table('user')->where(array('username' => '{$username}', 'password' => '{$password}'))->select();
if ($res == 1) {
    echo "<script>alert('注册成功');window.location.href='./login.html';</script>";
} else {
    echo "<script>alert('注册不成功');window.location.href=register.html</script>";
}



