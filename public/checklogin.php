<?php
require_once 'Db.php';

$username = trim($_POST['username']);
$password = md5(trim($_POST['password']));
// select * from users where username=username and password = password;
$db = new Db();
$res = $db->table('users')->where(array('username' => '{$usernaem}', 'password' => '{$password}'))->select();
if (isset($_POST['keep'])) {
    setcookie('username', $rows['username'], time() + 604800);
} else {
    setcookie('username', $rows['username']);
}
if ($res == 1) {
    echo "<script>alert('登录成功');window.location.href='index.html';</script>";
} else {
    echo "<script>alert('登录失败');history.back();</script>";
    exit();
}
