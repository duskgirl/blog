<?php
// 载入配置文件
require_once './config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  login();
}
function login () {
  // 1. 接收并校验
  // 2. 持久化
  // 3. 响应
  if (empty($_POST['username'])) {
    $GLOBALS['message'] = '请填写用户名';
    return;
  }
  if (empty($_POST['password'])) {
    $GLOBALS['message'] = '请填写密码';
    return;
  }
  $username = $_POST['username'];
  $password = $_POST['password'];

  // 当客户端提交过来的完整的表单信息就应该开始对其进行数据校验
  // 连接数据库
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if (!$conn) {
    exit('连接数据库失败');
  }
  // 查询数据库
  $query = mysqli_query($conn, "select id,name,password from adminuser where name = '{$username}' limit 1");
  if (!$query) {
    $GLOBALS['message'] = '登录失败，请重试！';
    return;
  }
  // 获取登录用户
  $user = mysqli_fetch_assoc($query);
  if (!$user) {
    // 用户不存在
    $GLOBALS['message'] = '当前用户不存在';
    return;
  }
  // 一般密码是加密存储的
  if ($user['password'] !== md5($password)) {
    // 密码不正确
    $GLOBALS['message'] = '用户名与密码不匹配';
    return;
  }

  // 存一个登录标识
  $_SESSION['is_logged_in'] = true;
  // 为了后续可以直接获取当前登录用户的信息，这里直接将用户信息放到 session 中
  $_SESSION['current_login_user'] = $user;
  $_SESSION['current_login_user_id'] = $user['id'];
  // 一切OK 可以跳转
  header('Location: /blog/admin/index.php');
}
// 退出登陆功能
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'logout'){
  unset($_SESSION['current_login_user']);
}
?>

  <!DOCTYPE html>
  <html lang="zh-CN">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>大思考-注册，登陆</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="favicon.ico">
    <!--[if lt IE 9]>
    <script src="lib/html5shiv/html5shiv.min.js"></script>
    <script src="lib/respond/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="blog_admin_login">
      <div class="cover">
        <div class="container">
          <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 content">
            <h3>大思考后台管理</h3>
            <!-- 有错误信息时展示 -->
            <?php if (isset($message)): ?>
            <div class="alert alert-danger">
              <strong>错误！</strong> <?php echo $message; ?>
            </div>
            <?php endif ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="login" novalidate>
              <div class="form-group">
                <p class="name">用户名：</p>
                <div class="error_container">
                  <input type="text" name="username" placeholder="请输入您的用户名" class="form-username form-control">
                </div>  
              </div>
              <div class="form-group">
                <p class="name">密&nbsp;&nbsp;码：</p>
                <div class="error_container">
                  <input type="password" name="password" placeholder="请输入您的密码" class="form-password form-control">
                </div>
              </div>
              <input type="submit" value="登录" class="btn">
            </form>
            <p class="clearfix">
              <span class="skip_register pull-left">没有账户,<a href="/blog/admin/register.php">立即注册<span class="fa fa-angle-double-right"></span></a></span>
              <span class="forget_password pull-right"><a href="/blog/admin/forget-password.php">忘记密码</a></span>
            </p>
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

  <script src="./lib/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
  <script>
    // 初步检验表单内容
    // 登录页面忘记密码怎么弄
    $(function(){
      $('.login').bootstrapValidator({
        message: 'This value is not valid',
          feedbackIcons: {
        　　valid: 'glyphicon glyphicon-ok',
        　　invalid: 'glyphicon glyphicon-remove',
        　　validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
            username: {
            // verbose:false,
            threshold: 2,
            message: '用户名验证失败',
            validators: {
              notEmpty: {
                message: '用户名不能为空'
              },
              stringLength:{
                min: 2,
                max: 10,
                message: '用户名长度必须在2到10位之间'
              },
              regxp: {
                regexp: /^[a-zA-Z0-9_]+$/,
                message: '用户名只能包含大写，小写，数字和下划线'
              }
            }
          },
          password: {
            message: '密码验证失败',
            threshold: 2,
            validators: {
              notEmpty: {
                message: '密码不能为空',
              },
              stringLength:{
                min: 6,
                max: 10,
                message: '密码长度必须在6到10位之间'
              },
              regxp: {
                regexp: /^[a-zA-Z0-9_]+$/,
                message: '密码只能包含大写，小写，数字和下划线'
              }
            }
          }
        }
      })
    })
  </script>

  </body>

  </html>