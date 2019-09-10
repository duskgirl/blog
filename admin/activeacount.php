<?php
// 载入配置文件
// 载入配置文件
require_once './config.php';
require_once './functions.php';
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
  $sql = "select id,name,email,password,userstats,modified_time from adminuser where email = '{$email}' limit 1";
  $row = blog_select_one($sql);
  if(!$row){
    exit('无效的链接');
  }
  // 查询用户存在
  $mt = md5($row['email'].$row['name'].$row['password'].$row['userstats']);
  // 目前是验证密令
  // 密令不符合,也可能是已经验证通过了
  // 这个我如何保证它是重复验证过了呢？我将密令包含userstats就行了
  if($mt != $token) {
    header('Location:/blog/admin/vertify.php?register=1');
  }
  // 密令符合,但是时间过期,应该重新发送激活账户的链接 
  // 重新发送链接的都应该重新更新下modified_time,否则时间一直停留在最初的时间则可能有使链接一直处于过期时间
  if(time()-strtotime($row['modified_time']) > 60){
    // 修改时间
    $modified_time_sql = "update adminuser set modified_time=current_timestamp where email='{$email}'";
    $result = blog_update($modified_time_sql);
    // 更改时间失败
    if(!$result){
      exit('更新数据失败');
    }
    // 更新时间成功再组合验证码
    // 组合验证码，token:验证码
    $username = $row['name'];
    $password = $row['password'];
    $userstats = $row['userstats'];
    $token = md5($email.$username.$password.$userstats);
    // 构造URL让用户激活账户
    // 除了这个时候可以发送链接到用户邮箱，登录的时候也可以发送类似的链接到邮箱
    $url = "http://127.0.0.1:3000/blog/admin/activeacount.php?email={$email}&token={$token}";   
     // 收件人，标题，邮件内容
    $header = '大思考账户激活';
    $content = "您好，感谢您在大思考注册账户！<br /> 请点击下方链接进行激活账户:<br /><a href='{$url}'>{$url}<a><br />大思考";
    $result = sendmail($email,$header,$content);
    if($result == 1) {
      // 表示超时
      header('Location:/blog/admin/sendmail-success.php?time_out=1');
      // $msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
    } else {
      $GLOBALS['message'] = $result;
    }
    $GLOBALS['message'] = '该激活链接已过期,系统已重新将激活账户链接发送到您的邮箱,请及时登录您的邮箱激活账户!';
  }
  // 一切链接点击有效
  // 修改时间
  // 修改用户状态为1，表示已激活
  
  $active_sql = "update adminuser set modified_time=current_timestamp,userstats=1 where email = '{$email}'";
  $result = blog_update($active_sql);



  // $active_query = mysqli_query($connect,$active_sql);
  // if(!$active_query){
  //   exit('查询数据失败');
  // }
  if(!$result){
    exit('激活账户失败,请稍后重试');
  }
  $GLOBALS['message_success'] = '激活成功!';

  // $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  // if(!$connect){
  //   exit('数据库连接失败!');
  // }
  // mysqli_set_charset($connect,'utf8');
  // $sql = "select id,name,email,password,userstats,modified_time from adminuser where email = '{$email}' limit 1";
  // $query = mysqli_query($connect,$sql);
  // if(!$query){
  //   exit('查询数据失败!');
  // }
  // $row = mysqli_fetch_array($query);
  
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
    <link rel="stylesheet" href="./css/activeacount.css">
    <link rel="shortcut icon" href="favicon.ico">
    <!--[if lt IE 9]>
    <script src="lib/html5shiv/html5shiv.min.js"></script>
    <script src="lib/respond/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="blog_admin_activeacount">
      <div class="cover">
        <div class="container">
          <p class="bggreen"><span class="fa fa-check-circle"></span></p>
          <?php if(isset($message)):?>
          <div class="alert alert-success success">
            <?php echo $message; ?>
          </div>
          <?php endif?>
          <?php if(isset($message_success)):?>
          <div class="alert alert-success success">
            <?php echo $message_success; ?><strong><a href="/blog/admin/login.php"> 点此登录</a></strong> 
          </div>
          <?php endif?>
          <p class="problem_text">若遇到问题，请邮件联系:<br />duskgirl@126.com</p>
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