  <?php
  if($_SERVER['REQUEST_METHOD'] === 'GET') {
    getValue();
  }
  function getValue(){
    if(empty($_GET['register']) && empty($_GET['resetpassword'])){
      exit('缺少必要的参数');
    }
    if(isset($_GET['register'])){
      if($_GET['register'] == 1) {
        $GLOBALS['register'] = "激活账户";
        return;
      } else {
        exit('参数错误');
      }
    }
    if(isset($_GET['resetpassword'])){
      if($_GET['resetpassword'] == 1) {
        $GLOBALS['resetpassword'] = "重置密码";
        return;
      } else {
        exit('参数错误');
      }
    }
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
    <link href="./css/sendmail-success.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico">
    <!--[if lt IE 9]>
    <script src="lib/html5shiv/html5shiv.min.js"></script>
    <script src="lib/respond/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="blog_admin_sendmail_success">
      <div class="cover">
        <div class="container">
          <p class="bggreen"><span class="fa fa-check-circle"></span></p>
          <?php if(isset($register)):?>
          <p class="green"><?php echo $register?></p>
          <p class="text">系统已将激活账户链接发送到您的邮箱,请及时登录您的邮箱激活账户</p>
          <?php endif?>
          <?php if(isset($resetpassword)):?>
          <p class="green"><?php echo $resetpassword?></p>
          <p class="text">系统已将密码重置链接发送到您的邮箱,请及时登录您的邮箱重置密码</p>
          <?php endif?>
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