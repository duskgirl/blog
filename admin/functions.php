<?php
// 载入配置文件
require_once './config.php';
session_start();
// 连接数据库
function blog_connect(){
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect){
    exit('连接数据库失败');
  }
  mysqli_set_charset($connect,'utf8');
  return $connect;
}
// 数据查询唯一操作
function blog_select_one($sql){
  $connect = blog_connect();
  $query = mysqli_query($connect,$sql);
  if(!$query) {
    exit('数据查询失败');
  }
  $GLOBALS['row'] = mysqli_fetch_array($query);
  return isset($GLOBALS['row']) ? $GLOBALS['row'] : null;
}
// 数据查询所有操作
function blog_select_all($sql){
  $connect = blog_connect();
  $query = mysqli_query($connect,$sql);
  if(!$query) {
    exit('数据查询失败');
  }
  while($row = mysqli_fetch_array($query)){
    $GLOBALS['array'][] = $row;
  }
  return isset($GLOBALS['array']) ? $GLOBALS['array'] : null;
}
// 增删改数据操作
function blog_update($sql){
  $connect = blog_connect();
  $query = mysqli_query($connect,$sql);
  if(!$query) {
    exit('数据查询失败');
  }
  // false表示数据更新失败
  if(mysqli_affected_rows($connect)<1){
    return false;
  }
  // true表示数据更新成功
  return true;
}

// 获取当前登陆用户信息，如果没有获取到则直接跳转到登录页面
function blog_get_current_user(){
  if(empty($_SESSION['current_login_user'])) {
    header('Location:/blog/admin/login.php');
  } else {
    return $_SESSION['current_login_user'];
  }
}
// 获取当前登陆用户是否是管理员权限
function is_admin(){
  blog_get_current_user();
  if($_SESSION['current_login_user']['permission'] != 1) {
    $GLOBALS['err_message'] = '当前用户权限不足！操作失败';
    return false;
  } else {
    return true;
  }
}
