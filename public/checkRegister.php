<?php
require_once 'Db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$db = new Db();
// $sql = 'select * from users where username = :username and password = :password';
$res = $db->table('user')->where(array('username' => '{$username}', 'password' => '{$password}'))->select();
if($res->rowCount == 1){
    $_SESSION['username']=$username;
    echo 1;
}else{
    echo 0;
}



