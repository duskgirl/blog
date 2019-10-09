<?php
// 载入配置文件
require_once '../config.php';
require_once '../functions.php';
if(empty($_SESSION['url'])){
  $path = '/blog/index.php';
} else {
  $path = $_SESSION['url'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  login();
}
// 增加一个功能要是用户激活了才能登陆，否则不能登陆
function login () {
  // 1. 接收并校验
  // 2. 持久化
  // 3. 响应
  global $path;
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
  $query = mysqli_query($conn, "select id,email,name,password,userstats from user where name = '{$username}' limit 1");
  if (!$query) {
    $GLOBALS['message'] = '登录失败，请重试！';
    return;
  }
  // 获取登录用户
  $user = mysqli_fetch_assoc($query);
  if (!$user) {
    // 用户不存在
    $GLOBALS['message'] = '当前用户尚未注册';
    return;
  }

  // 检测用户是否激活账户
  // 未激活就只有直接发送链接到页面去
  // 只要发送邮件都要更新时间，因为保证链接的有效期
  if($user['userstats'] != 1) {
    // 修改时间
    $modified_time_sql = "update user set modified_time=current_timestamp where name='{$username}'";
    $result = blog_update($modified_time_sql);
    // 更改时间失败
    if(!$result){
      exit('更新数据失败');
    }
    // 组合验证码，token:验证码(要包含用户状态)
    $email = $user['email'];
    $username = $user['name'];
    $password = $user['password'];
    $userstats = $user['userstats'];
    $token = md5($email.$username.$password.$userstats);
    // 构造URL让用户激活账户
    // 除了这个时候可以发送链接到用户邮箱，登录的时候也可以发送类似的链接到邮箱
    $url = "http://127.0.0.1:3000/blog/user/activeacount.php?email={$email}&token={$token}";   
     // 收件人，标题，邮件内容
    $header = '大思考账户激活';
    $content = "您好，感谢您在大思考注册账户！<br /> 请点击下方链接进行激活账户:<br /><a href='{$url}'>{$url}<a><br />大思考";
    $result = sendmail($email,$header,$content);
    if($result == 1) {
      // 传递参数:表示该用户尚未激活
      // 数据库为1是表示已经激活，这里传递1只是为了方便服务端好接收数据，这里是表示未激活的
      header('Location:/blog/user/sendmail-success.php?userstats=1');
      // $msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
    } else {
      $GLOBALS['message'] = $result;
    }
    $GLOBALS['message'] = '当前用户尚未激活,系统已重新将激活账户链接发送到您的邮箱,请及时登录您的邮箱激活账户!';
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
  // 一切OK 可以跳转到原来的页面或者是首页
  header('Location: ' . $path);
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
    <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.min.css">
    <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../lib/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="favicon.ico">
    <!--[if lt IE 9]>
    <script src="../lib/html5shiv/html5shiv.min.js"></script>
    <script src="../lib/respond/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="blog_login">
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
              <span class="skip_register pull-left">没有账户,<a href="/blog/user/register.php">立即注册<span class="fa fa-angle-double-right"></span></a></span>
              <span class="forget_password pull-right"><a href="/blog/user/forget-password.php">忘记密码</a></span>
            </p>
          </div>
        </div>
      </div>
    </div>


    <!-- Javascript -->
    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- 轮播图插件 -->
    <!-- <script src="../lib/backstretch/jquery.backstretch.min.js"></script> -->
    <!--[if lt IE 10]>
    <script src="../lib/placeholder/jquery.placeholder.min.js"></script>
  <![endif]-->

  <script src="../lib/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
  <script>
    // 初步检验表单内容
    // 登录页面忘记密码
    // 1.初步检测用户名是否存在
    // 2.初步检测输入密码是否和当前用户匹配
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
            verbose:false,
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
              },
              remote: {
                // 检测当前用户是否注册
                url: '/blog/user/checkUnique.php',
                // 提示消息
                message: '当前用户尚未注册',
                delay: 2000,
                type: 'POST',
                data: {
                  // 这个数据是默认会传递的
                  // username: function(){
                  //   return $.trim($('.login').find('.form-username').val())
                  // },
                  unique: function(){
                    return false
                  }
                }
              }
            }
          },
          password: {
            verbose:false,
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
              },
              remote: {
                // 检测当前用户是否注册
                url: '/blog/user/checkUnique.php',
                // 提示消息
                message: '输入密码与当前用户不匹配，请重新输入',
                delay: 2000,
                type: 'POST',
                data: {
                  username: function(){
                    return $.trim($('.login').find('.form-username').val())
                  }
                }
              }
            }
          }
        }
      })
    })
  </script>

  </body>

  </html>