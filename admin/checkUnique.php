<?php
require_once './config.php';
// 校验邮箱唯一性
if(empty($_GET['email']) && empty($_GET['username'])){
  exit('缺少必要参数');
}
if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['email'])){
  $email = $_GET['email'];
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  mysqli_set_charset($connect,'utf8');
  $email_sql = "select email from adminuser where email = '{$email}' limit 1";
  //var_dump($email_sql);
  $email_query = mysqli_query($connect,$email_sql);
  if(!$email_query){
    exit('查询失败');
  }
  $isAvailable = true;
  if(!mysqli_fetch_array($email_query)){
    // 这里表示查询到不存在
    echo json_encode(array('valid' => $isAvailable));
  } else {
  // 这里表示查询到存在
    $isAvailable = false;
    echo json_encode(array('valid' => $isAvailable));
  }
}
// 校验用户名的唯一性
if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['username'])){
  $username = $_GET['username'];
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  mysqli_set_charset($connect,'utf8');
  $username_sql = "select name from adminuser where name = '{$username}' limit 1";
  $username_query = mysqli_query($connect,$username_sql);
  if(!$username_query){
    exit('查询失败');
  }
  $isAvailable = true;
  if(!mysqli_fetch_array($username_query)){
    // 这里表示查询到不存在
    echo json_encode(array('valid' => $isAvailable));
  } else {
  // 这里表示查询到存在
    $isAvailable = false;
    echo json_encode(array('valid' => $isAvailable));
  }
}