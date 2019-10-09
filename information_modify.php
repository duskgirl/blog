<?php
require_once './config.php';
require_once './functions.php';
// 保存用户修改的信息
header('Content-Type','application/json');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  save_modify();
}
function save_modify(){
  if(empty($_POST['email'])){
    echo result('save','请正确操作修改资料!',false);
    return;
  }
  // 应该先查询该用户是否存在，如果不存在也不能往后继续
  $email = $_POST['email'];
  $sql = "select name,password,avatar from user where email = '{$email}'";
  $result = blog_select_one($sql);
  // 该用户原来的信息
  $name_old = $result['name'];
  $password_old = $result['password'];
  $avatar_old = $result['avatar'];
  // 该用户不存在
  if(empty($result)){
    echo result('save','请正确操作修改资料!',false);
    return;
  }

  // 用户名/密码,不能让他为空
  // 这里我只看等不等于原来那个
  if(empty($_POST['name']) || empty($_POST['password']) || empty($_POST['repassword']) || empty($_POST['avatar'])){
    echo result('save','请正确操作修改资料!',false);
    return;
  }
  // 如果两个都不相等
  if($_POST['password'] != $_POST['repassword']){
    echo result('save','两次密码输入不一致',false);
    return;
  }
  // 头像没有选中则就不修改头像
  // 保存用户修改的信息
  $name = $_POST['name'];
  $password = md5($_POST['password']);
  $avatar = $_POST['avatar'];
  // 用户名修改||密码修改||用户头像修改
  // 用户名修改 && 密码修改 || 用户头像修改 && 密码修改 || 头像 && 用户名修改 
  // 三者一起修改

  $modify_name =  $name_old != $name ? true : false;
  $modify_password = $password_old != $password ? true : false;
  $modify_avatar = $avatar_old != $avatar ? true : false;
  if(!$modify_name && !$modify_password && !$modify_avatar){
    echo result('save','修改的资料不能和以前一样哟!',false);
    return;
  }
  // 最开始要设置的设置一个变量
  $modify_sql = "";
  if($modify_name){
    $modify_sql .= "name='{$name}',";
  }elseif(!$modify_password && !$modify_avatar){
    $modify_sql .= "name='{$name}'";
  } 
  if($modify_password){
    $modify_sql .= "password='{$password}',";
  }elseif(!$modify_avatar){
    $modify_sql .= "password='{$password}'";
  }
  if($modify_avatar){
    $modify_sql .= "avatar='{$avatar}'";
  }
  $sql = "update user set {$modify_sql} where email = '{$email}'";
  $result = blog_update($sql);
  if(!$result){
    echo result('save','修改资料失败，请稍后重试',false);
    return;
  }
  echo result('save','修改资料成功！',true);
}
function result($title,$message,$value){
  if(empty($message)){
    $result = array(
      $title => $value
    );
  } else {
      $result = array(
        $title => $value,
        'message' => $message
      );
    }
  $result = json_encode($result);
  return $result;
}