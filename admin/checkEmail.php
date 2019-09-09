<?php
require_once './config.php';
// 校验邮箱唯一性
if(empty($_GET['email'])){
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
  if(mysqli_fetch_array($email_query)){
    // 这里表示查询到不存在,表示该用户尚未注册
    echo json_encode(array('valid' => $isAvailable));
  } else {
  // 这里表示查询到存在，表示该用户注册过，则不用提示任何信息
    $isAvailable = false;
    echo json_encode(array('valid' => $isAvailable));
  }
}