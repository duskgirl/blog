
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>大思考个人中心</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/sidebar.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/person_nav.css">
  <link rel="stylesheet" href="./css/person_set.css">
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
      <div class="person_detail">        
        <div class="person_set">
          <h4>基本资料</h4>
          <form action="" class="modify">
            <div class="input-group">
              <!-- 注册邮箱不能修改，其他均可以修改 -->
              <p class="text">注册邮箱:</p>
              <input type="email" class="form-control" disabled name="email" placeholder="16898@qq.com">
            </div>
            <div class="input-group">
              <p class="text">用户名:</p>
              <input type="text" class="form-control" name="username" placeholder="大思考">
            </div>
            <div class="input-group">
              <p class="text">密码:</p>
              <input type="password" class="form-control" name="userpassword" placeholder="123456" />
            </div>
            <div class="input-group">
              <p class="text">用户头像:</p>
              <!-- 这里注意如何设置用户只能上传图片之类的图形 -->
              <input type="file" name="avatar"><span>只能上传单张10M以下png,jpg,gif图片</span>
              <!-- 显示用户的头像 -->
              <!-- 注意怎么裁剪用户头像 -->
              <img src="images/avatar.jpg" alt="">
              <img src="images/banner_1.jpg" alt="">
            </div>
            <input type="submit" value="提交修改" class="btn" />
          </form>
        </div>
      </div>
 
    </section>
    <!-- 右侧：搜索框 最近发表  -->
    <?php include 'sidebar.php'?>
  </main>
  <?php include 'footer.php'?>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>