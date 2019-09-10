<?php
// 载入配置文件
require_once './config.php';
require_once './functions.php';
// 校验邮箱唯一性
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  resetPassword();
}
function resetPassword(){
  if(empty($_POST['email'])){
    $GLOBALS['message'] = '请输入注册邮箱';
    return;
  }
  $email = $_POST['email'];
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  mysqli_set_charset($connect,'utf8');
  // 要验证Email是否存在系统用户表中,如果有，
  // 则读取用户信息，将用户id、用户名和密码进行md5加密生成一个特别的字符串作为找回密码的验证码，然后构造URL;
  // 同时我们为了控制URL链接的时效性，将记录用户提交找回密码动作的操作时间，最后调用邮件发送类发送邮件到用户邮箱

  $sql = "select id,name,email,password from adminuser where email = '{$email}' limit 1";
  // var_dump($sql);
  $query = mysqli_query($connect,$sql);
  if(!$query){
    exit('查询邮箱失败');
  }
  $row = mysqli_fetch_array($query);
  if(!$row) {
    $GLOBALS['message'] = '该邮箱尚未注册';
    return;
  }
  // 到目前为止也就是该邮箱已注册，然后找回该邮箱的密码
  
  // 同时我们为了控制URL链接的时效性，将记录用户提交找回密码动作的操作时间，最后调用邮件发送类发送邮件到用户邮箱
  $id = $row['id'];
  $name = $row['name'];
  // 读取用户信息，将用户id、用户名和密码进行md5加密生成一个特别的字符串作为找回密码的验证码，然后构造URL;
  // 组合验证码，token:验证码
  $token = md5($id.$name.$row['password']);
  // 构造URL
  $url = "http://127.0.0.1:3000/blog/admin/reset-password.php?email={$email}&token={$token}";    
  // 更新数据发送时间,保证时效性
  $time_sql = "update adminuser set modified_time = CURRENT_TIMESTAMP where id = {$id}";
  $time_query = mysqli_query($connect,$time_sql);
  if(!$time_query) {
    exit('数据更新失败');
  }
  if(mysqli_affected_rows($connect) < 1) {
    exit('数据更新失败');
  }
  // 收件人，标题，邮件内容
  $header = '大思考账户密码重置';
  $content = "您好，您正在重置大思考账户{$name}的密码<br /> 请点击下方链接修改密码:<br /><a href='{$url}'>{$url}<a><br />大思考";
  $result = sendmail($email,$header,$content);
  if($result == 1) {
    header('Location:/blog/admin/sendmail-success.php?resetpassword=1');
    // $msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
  } else {
    $GLOBALS['message'] = $result;
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
    <link href="lib/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/forget-password.css">
    <link rel="shortcut icon" href="favicon.ico">
    <!--[if lt IE 9]>
    <script src="lib/html5shiv/html5shiv.min.js"></script>
    <script src="lib/respond/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="blog_admin_forget_password">
      <div class="cover">
        <div class="container">
          <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 content">
            <h3>重置密码</h3>
            <!-- 有错误信息时展示 -->
            <?php if (isset($message)): ?>
            <div class="alert alert-danger">
              <strong>错误！</strong> <?php echo $message; ?>
            </div>
            <?php endif ?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="forget_password" novalidate>
              <div class="form-group">
                <p class="name">邮&nbsp;&nbsp;箱：</p>
                <div class="error_container">
                  <input type="email" name="email" placeholder="请输入注册邮箱" class="form-email form-control">
                </div>
              </div>
              <input type="submit" value="提交" class="btn">
            </form>
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
      $('.forget_password').bootstrapValidator({
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
                message: '该邮箱尚未注册',
                type: 'POST',
                // 自定义提交数据，默认值提交当前input value
                data: {
                  email: function(){
                    return $.trim($('.register').find('.form-email').val())
                  },
                  unique: function(){
                    return false
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