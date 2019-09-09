<?php
// 载入配置文件
// 载入配置文件
require_once './config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once './lib/PHPMailer-master/Exception.php';
require_once './lib/PHPMailer-master/PHPMailer.php';
require_once './lib/PHPMailer-master/SMTP.php';
date_default_timezone_set('PRC');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
  activeUser();
}
function activeUser(){
  if(empty($_GET['email']) || empty($_GET['token'])){
    exit('缺少必要的参数!');
  }
  $email = $_GET['email'];
  $token = $_GET['token'];
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect){
    exit('数据库连接失败!');
  }
  mysqli_set_charset($connect,'utf8');
  $sql = "select id,name,email,password,modified_time from adminuser where email = '{$email}' limit 1";
  $query = mysqli_query($connect,$sql);
  if(!$query){
    exit('查询数据失败!');
  }
  $row = mysqli_fetch_array($query);
  if(!$row){
    exit('无效的链接');
  }
  // 查询用户存在
  $mt = md5($row['email'].$row['name'].$row['password']);
  // 目前是验证密令
  // 密令不符合,也可能是已经验证通过了
  if($mt != $token) {
    header('Location:/blog/admin/vertify.php?register=1');
  }
  // 密令符合,但是时间过期,应该重新发送激活账户的链接 
  if(time()-strtotime($row['modified_time']) > 24*60*60){
    exit('该链接已过期!');
  }
  // 一切链接点击有效
  // 修改时间
  // 修改用户状态为1，表示已激活
  $active_sql = "update adminuser set modified_time=current_timestamp,userstats=1";
  $active_query = mysqli_query($connect,$active_sql);
  if(!$active_query){
    exit('查询数据失败');
  }
  if(mysqli_affected_rows($connect)<1){
    exit('激活账户失败,请稍后重试');
  }
  $GLOBALS['message'] = '激活成功';
}

  

?>

  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>大思考-注册，登陆</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/reset-password.css">
    <link rel="shortcut icon" href="favicon.ico">
    <!--[if lt IE 9]>
    <script src="lib/html5shiv/html5shiv.min.js"></script>
    <script src="lib/respond/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="blog_admin_reset_password">
      <div class="cover">
        <div class="container">
          <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 content">
            <h3>重置密码</h3>
            <?php if(isset($user)):?>
            <p class="reset_password_text">您正在重置大思考账户<span class="username"><?php echo $user['name']?></span>的密码</p>
            <?php endif?>
            <!-- 有错误信息时展示 -->
            <?php if(isset($message)): ?>
            <div class="alert alert-danger">
              <strong>错误！</strong> <?php echo $message; ?>
            </div>
            <?php endif ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" novalidate class="reset-password">
            <?php if(isset($user)):?>
              <input type="email" name="email" placeholder="请输入您的邮箱" class="hidden" value="<?php echo $user['email']?>"> 
            <?php endif?>
              <div class="form-group">
                <p class="name">新密码：</p>
                <div class="error_container">
                  <input type="password" name="password" placeholder="请输入您的新密码" class="form-password form-control">
                </div>
              </div>
              <div class="form-group">
                <p class="name">确认密码：</p>
                <div class="error_container">
                  <input type="password" name="repassword" placeholder="请再次输入以确认您的密码" class="form-repassword form-control">
                </div>
              </div>
              <input type="submit" class="btn" value="提交">
            </form>
            <?php if(isset($success_message)): ?>
            <div class="alert alert-success success">
              <?php echo $success_message; ?><strong><a href="/blog/admin/login.php"> 点此登录</a></strong> 
            </div>
            <?php endif ?>
            <p class="problem_text">若遇到问题，请邮件联系:<br />duskgirl@126.com</p>
          </div>
        </div>
      </div>
    </div>


    <!-- Javascript -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- 轮播图插件 -->
    <!-- <script src="lib/backstretch/jquery.backstretch.min.js"></script> -->
    <!--[if lt IE 10]>
    <script src="lib/placeholder/jquery.placeholder.min.js"></script>
  <![endif]-->


  </body>

  </html>