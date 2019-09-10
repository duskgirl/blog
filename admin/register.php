<?php
// 载入配置文件
require_once './config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once './lib/PHPMailer-master/Exception.php';
require_once './lib/PHPMailer-master/PHPMailer.php';
require_once './lib/PHPMailer-master/SMTP.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  register();
}
function register () {
  // 1. 接收并校验
  // 2. 持久化
  // 3. 响应
  // $a = '111';
  if (empty($_POST['email'])) {
    $GLOBALS['message'] = '请输入您的邮箱';
    return;
  }
  if (empty($_POST['username'])) {
    $GLOBALS['message'] = '请输入您的用户名';
    return;
  }
  if (empty($_POST['password'])) {
    $GLOBALS['message'] = '请输入您的密码';
    return;
  }
  if (empty($_POST['repassword'])) {
    $GLOBALS['message'] = '请输入您的确认密码';
    return;
  }
  if($_POST['password'] !== $_POST['repassword']) {
    $GLOBALS['message'] = '两次输入的密码不一致';
    return;
  }
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  
  // 当客户端提交过来的完整的表单信息就应该开始对其进行数据校验
  // 连接数据库
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if (!$conn) {
    exit('<h1>连接数据库失败</h1>');
  }
  mysqli_set_charset($conn,'utf8');

  $sql = "insert into adminuser (email,name,password) values ('{$email}','{$username}','{$password}')";
 
  $query = mysqli_query($conn, $sql);

  if (!$query) {
    $GLOBALS['message'] = '注册失败，请重试！';
    return;
  }



  // 注册的验证是最好将修改时间/用户状态都加上
  // 读取用户信息，将用户信息进行md5加密生成一个特别的字符串作为找回密码的验证码，然后构造URL;
  // 组合验证码，token:验证码
  $userstats = 0;
  $token = md5($email.$username.$password.$userstats);
  // 构造URL让用户激活账户
  // 除了这个时候可以发送链接到用户邮箱，登录的时候也可以发送类似的链接到邮箱
  $url = "http://127.0.0.1:3000/blog/admin/activeacount.php?email={$email}&token={$token}";    
   // 收件人，标题，邮件内容
   $header = '大思考账户激活';
   $content = "您好，感谢您在大思考注册账户！<br /> 请点击下方链接进行激活账户:<br /><a href='{$url}'>{$url}<a><br />大思考";
   $result = sendmail($email,$header,$content);
   if($result == 1) {
     header('Location:/blog/admin/sendmail-success.php?register=1');
     // $msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
   } else {
     $GLOBALS['message'] = $result;
   }
 }
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
  $GLOBALS['success_message'] = '注册成功!系统已将激活账户链接发送到您的邮箱,请及时登录您的邮箱激活账户登录';

  // 数据库如何设计用户名和邮箱不能一样呢？
  // 每个信息填写的时候，发送ajax请求要求用户名和邮箱不能重复的
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
    <link rel="stylesheet" href="./css/register.css">
    <link rel="shortcut icon" href="favicon.ico">
    <!--[if lt IE 9]>
    <script src="lib/html5shiv/html5shiv.min.js"></script>
    <script src="lib/respond/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="blog_admin_register">
      <div class="cover">
        <div class="container">
          <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 content">
            <h3>大思考后台管理</h3>
            <!-- 有错误信息时展示 -->
            <?php if(isset($message)): ?>
            <div class="alert alert-danger">
              <strong>错误！</strong> <?php echo $message; ?>
            </div>
            <?php endif ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" novalidate class="register">
              <div class="form-group">
                <p class="name">邮箱：</p>
                <div class="error_container">
                  <input type="email" name="email" placeholder="需要通过邮箱激活账户" class="form-email form-control">
                </div>
                
                <!-- <span class="fa fa-check right"></span> -->
                <!-- 出现错误显示的内容例子：昵称格式：限16个字符，支持中英文、数字、减号或下划线 -->
                <!-- <label class="validate"><span class="fa fa-times false"></span> 请输入正确的邮箱地址</label> -->
                <!-- <p class="validate"><span class="fa fa-check right"></span></p> -->
              </div>
              <div class="form-group">
                <p class="name">用户名：</p>
                <div class="error_container">
                  <input type="text" name="username" placeholder="请输入您的用户名" class="form-username form-control">
                </div>
              </div>
              <div class="form-group">
                <p class="name">密码：</p>
                <div class="error_container">
                  <input type="password" name="password" placeholder="请输入您的密码" class="form-password form-control">
                </div>
              </div>
              <div class="form-group">
                <p class="name">确认密码：</p>
                <div class="error_container">
                  <input type="password" name="repassword" placeholder="请输入确认密码" class="form-repassword form-control">
                </div>
              </div>
              <input type="submit" class="btn" value="注册">
            </form>
            <?php if(isset($success_message)): ?>
            <div class="alert alert-success success">
              <?php echo $success_message; ?><strong><a href="/blog/admin/login.php"> 点此登录</a></strong> 
            </div>
            <?php endif ?>
            <p class="skip_login">已有账户,<a href="/blog/admin/login.php">直接登录<span class="fa fa-angle-double-right"></span></a></p>
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

  <!-- <script src="./js/register.js"></script> -->
  <script src="./lib/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
  <script>
    // 初步检验表单内容
    // 注册页面还是需要有一个登陆标注的
    // 还是想弄一个验证码检验用户输入的邮箱是有效地址

    // 第一种：发送验证码比对
    // 1.如何生成随机验证码
    // 2.如何将生成的随机验证码保存到数据库
    // 3.如何将生成的随机验证码用邮箱发送给用户邮箱
    // 4.如何将用户输入的随机验证码匹配对比


    // 第二种：仍然发送链接校验；
    // 1.用户填写好一切的信息后
    // 2.需要给用户发送一个链接到用户邮箱
    // 3.用户点击链接成功才可以算注册成功
    // 4.然后才能使用登陆功能

    $(function(){
      $('.register').bootstrapValidator({
        message: 'This value is not valid',
          feedbackIcons: {
        　　valid: 'glyphicon glyphicon-ok',
        　　invalid: 'glyphicon glyphicon-remove',
        　　validating: 'glyphicon glyphicon-refresh'
          },
        fields: {
          email: {
            // verbose:false,每一个input顺序验证，一个验证不通过，那么下一个验证就不走，所以只显示一条错误信息
            verbose:false,
            // threshold: 2,表示在输入几个字符以后再进行下一步验证，注意位置和validators是同级位置关系，不要写到validators里面去了
            threshold: 2,
            validators: {
              notEmpty: {
                message: '邮箱地址不能为空'
              },
              emailAddress: {
                message: '邮箱地址格式有误'
              },
              remote: {
                // ajax验证数据的唯一性,服务端返回值,true代表不重复，false代表重复 
                // server result:{"valid",true or false}
                // url:验证地址
                url: '/blog/admin/checkUnique.php',
                // 提示消息
                message: '当前邮箱已存在，请直接去<a href="/blog/admin/login.php">登录</a>吧',
                // 每输入一个字符，就发ajax请求，服务器压力太大，所以时间设置长点
                delay: 2000,
                type: 'POST',
                // 自定义提交数据，默认值提交当前input value
                data: function(){
                  return {
                    email: $.trim($('.register').find('.form-email').val())
                  }
                }
              }
            }
          },
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
                url: '/blog/admin/checkUnique.php',
                // 提示消息
                message: '当前用户名已被注册，请换个用户名试试吧',
                delay: 2000,
                type: 'POST',
                data: function(){
                  return {
                    username: $.trim($('.register').find('.form-username').val())
                  }
                }
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
          },
          repassword: {
            validators: {
              notEmpty: {
                message: '确认密码不能为空',
              },
              identical: {
                field: 'password',
                message: '两次输入的密码不一致'
              }
            }
          }
        }
      })
    })
    // 如何提示用户提交的内容和数据库的内容重复，比如当前用户已存在，
    // 当前用户已存在，请换个用户名试一试/当前邮箱已注册
    
  </script>
  </body>

  </html>