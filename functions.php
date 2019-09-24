<?php
// 载入配置文件
require_once 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'lib/PHPMailer-master/Exception.php';
require_once 'lib/PHPMailer-master/PHPMailer.php';
require_once 'lib/PHPMailer-master/SMTP.php';

// session_start();
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
  $row = mysqli_fetch_array($query);
  return $row;
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
  return empty($GLOBALS['array']) ?  null: $GLOBALS['array'];
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
// 给用户发送邮箱
function sendmail($email,$header,$content){
  $mail = new PHPMailer(true);
  try {
  //Server settings:服务器配置
  $mail->CharSet = 'UTF-8';
  $mail->SMTPDebug = 2;                                       // Enable verbose debug output
  $mail->isSMTP();                                            // Set mailer to use SMTP
  $mail->Host       = 'smtp.126.com';  // Specify main and backup SMTP servers
  $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
  $mail->Username   = 'duskgirl@126.com';                     // SMTP username
  $mail->Password   = 'dusk1993';                               // SMTP password
  $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
  $mail->Port       = 465;                                    // TCP port to connect to
  
  $mail->setFrom('duskgirl@126.com', '大思考');
  $mail->addAddress($email, $email);     // Add a recipient

  $mail->addReplyTo('duskgirl@126.com', '大思考');
  
  $mail->isHTML(true);                                  // Set email format to HTML
  // 这里是邮件标题
  $mail->Subject = $header;
  // 这里是邮件内容
  $mail->Body    = $content;
  // 如果邮件客户端不支持HTML则显示此内容
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  $mail->send();
  // 邮件发送成功,我自行设置返回1，表示成功
  // return 'Message has been sent';
  return 1;
  } catch (Exception $e) {
  // 邮件发送失败
    // return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return "发送邮件失败: {$mail->ErrorInfo}";
  }
}