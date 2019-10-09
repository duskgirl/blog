<?php
require_once './config.php';
require_once './functions.php';
$user = blog_get_current_user();
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  // 必须先注册登陆才能进去
  if($user == null){
    $_SESSION['url'] = '/blog/person_set.php';
    header('Location: /blog/user/login.php');
  }
  $email = $user['email'];
  $sql = "select name,avatar from user where email = '{$email}'";
  $result = blog_select_one($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>大思考个人中心</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
  <link href="/blog/lib/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/sidebar.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/person_nav.css">
  <link rel="stylesheet" href="./css/person_set.css">
  <link rel="stylesheet" href="./css/public.css">
</head>

<body>
  <?php include 'topbar.php'?>
  <!-- 左侧导航包括 -->
    <!-- 我的消息 -->
    <!-- 个人设置（基本资料）  -->


   
    <!-- 网站主体内容 -->
  <!-- 左侧：博客标题、博客发表时间、作者、所属分类，文章主图 -->
  <main class="blog_main container">
    <section class="mainbar">
      <?php include 'person_nav.php'?>
      <div class="person_detail" id="person">        
        <div class="person_set">
          <h4 class="hidden-xs">基本资料</h4>
          <form class="modify">
            <div class="form-group">
              <!-- 注册邮箱不能修改，其他均可以修改 -->
              <p class="text">注册邮箱:</p> 
              <input type="email" class="form-control email" disabled name="email" value="<?php echo $user['email']?>">
            </div>
            <div class="form-group">
              <p class="text">用户名 *</p>
              <div class="err_container">
                <input type="text" class="form-control username" name="username" value="<?php echo $result['name']?>">
              </div>
            </div>
            <div class="form-group">
              <p class="text">密码 *</p>
              <div class="err_container">
                <input type="password" class="form-control password" name="password" /> 
              </div>
            </div>
            <div class="form-group">
              <p class="text">确认密码 *</p>
              <div class="err_container">
                <input type="password" class="form-control repassword" name="repassword" />
              </div>
            </div>
            <div class="form-group avatar">
              <p class="text">选择您的头像 *</span></p>
              <div id="wrapper">
                <div id="scroller">
                  <ul>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar.jpg" /><img src="/blog/images/avatar/avatar.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar1.jpg"  /><img src="/blog/images/avatar/avatar1.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar2.jpg"  /><img src="/blog/images/avatar/avatar2.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar3.jpg"  /><img src="/blog/images/avatar/avatar3.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar4.jpg"  /><img src="/blog/images/avatar/avatar4.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar5.jpg"  /><img src="/blog/images/avatar/avatar5.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar6.jpg"  /><img src="/blog/images/avatar/avatar6.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar7.jpg"  /><img src="/blog/images/avatar/avatar7.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar8.jpg"  /><img src="/blog/images/avatar/avatar8.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar9.jpg"  /><img src="/blog/images/avatar/avatar9.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar10.jpg" /><img src="/blog/images/avatar/avatar10.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar11.jpg" /><img src="/blog/images/avatar/avatar11.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar12.jpg" /><img src="/blog/images/avatar/avatar12.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar13.jpg" /><img src="/blog/images/avatar/avatar13.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar14.jpg" /><img src="/blog/images/avatar/avatar14.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar15.jpg" /><img src="/blog/images/avatar/avatar15.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar16.jpg" /><img src="/blog/images/avatar/avatar16.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar17.jpg" /><img src="/blog/images/avatar/avatar17.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar18.jpg" /><img src="/blog/images/avatar/avatar18.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar19.jpg" /><img src="/blog/images/avatar/avatar19.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar20.jpg" /><img src="/blog/images/avatar/avatar20.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar21.jpg" /><img src="/blog/images/avatar/avatar21.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar22.jpg" /><img src="/blog/images/avatar/avatar22.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar23.jpg" /><img src="/blog/images/avatar/avatar23.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar24.jpg" /><img src="/blog/images/avatar/avatar24.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar25.jpg" /><img src="/blog/images/avatar/avatar25.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar26.jpg" /><img src="/blog/images/avatar/avatar26.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar27.jpg" /><img src="/blog/images/avatar/avatar27.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar28.jpg" /><img src="/blog/images/avatar/avatar28.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar29.jpg" /><img src="/blog/images/avatar/avatar29.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar30.jpg" /><img src="/blog/images/avatar/avatar30.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar31.jpg" /><img src="/blog/images/avatar/avatar31.jpg" alt=""></li>
                    <li><input type="radio" name="avatar" class="selected" value="/blog/images/avatar/avatar32.jpg" /><img src="/blog/images/avatar/avatar32.jpg" alt=""></li>
                  </ul> 
                </div>
              </div>
            </div>
            <input type="submit" value="修改基本资料" class="btn modify_btn" />
          </form>
        </div>
      </div>
 
    </section>
  </main>
  <?php include 'footer.php'?>
  <script src="/blog/lib/jquery/jquery.min.js"></script>
  <script src="/blog/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="/blog/lib/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
  <script src="/blog/lib/iscroll/iscroll-probe.js"></script>
  <script src="/blog/lib/artDialog-master/dialog.js"></script>
  <script src="/blog/js/person.js"></script>
  <script>
    $(function(){
      // 设置用户头像被选中
      var avatar_old = "<?php echo $result['avatar']?>";
      $('.selected').each(function(){
        if($(this).next().attr('src') == avatar_old) {
          $(this).prop('checked','checked');
        }
      })
      // 点击修改提交，则发送ajax请求
      // 因为我这里填了密码初始校验的密码长度为6-10位，但是我把他32位那种填上去会发生校验错误，密码就不填上去好了
      $('.modify_btn').on('click', function() {
        // 用户邮箱必须校验；
        // 用户名
        // 密码
        // 确认密码
        // 头像
        // 保证用户不能修改邮箱
        event.preventDefault();
        var email = $('.email').val();
        var email_init = '<?php echo $user['email']?>';
        // 修改了用户邮箱
        // console.log(email);
        // console.log(email_init);
        if(email != email_init){
          warn('警告','暂不支持修改用户邮箱!');
          return;
        }
        var username = $('.username').val();
        // 保证两次密码输入一致
        
        var password = $('.password').val();
        var repassword = $('.repassword').val();
        if(password != repassword){
          warn('警告','两次密码输入不一致!');
          return;
        }
        // 还要如何保证选择头像按钮时就选择了图片;
        var avatar = $('input:radio[name="avatar"]:checked').next().attr('src');
        if(username.length<1 || password.length<1 || avatar.length <1) {
          warn('警告','带星号的选项均为必填选项!');
          return;
        }
        $.ajax({
          url: '/blog/information_modify.php',
          type: 'POST',
          dataType: 'json',
          data : {
            email: email,
            name: username,
            password: password,
            repassword: repassword,
            avatar: avatar
          },
          success: function(data){
            if(data.save){
              warn('恭喜',data.message);
            } else {
              warn('警告',data.message);
            }
          }
        })
      });
      function warn(title,content){
        var d = dialog({
    	    title: title,
          content: content,
          cancel: false,
	        ok: function () {},
          quickClose: true
        });
        d.show(document.getElementById('option-quickClose'));
        setTimeout(function () {
        	d.close().remove();
        }, 5000);
      }
    })
  </script>
</body>

</html>