<!-- 顶部通栏 -->
<!-- 只预留一个位置登陆就行了，登陆页面直接可以跳转到注册页面 登陆后直接显示个人头像，点击个人头像可以到达个人中心 -->
<!-- 到时候个人中心页面直接未设置个人头像，就用默认头像，如果设置了个人头像就用用户设置的头像 -->
<!-- 左边网站logo 右边网站导航 （前端开发 前端开发 前端开发 前端开发 这属于分类） -->
<!-- 干脆所有导航做成一排，logo和登陆页面做在一行 -->
<div class="blog_topbar">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <!-- 导航栏 -->
      <!-- 导航栏永远做一个侧边折叠效果 -->
      <div class="blog_nav">
        <a href="javascript:;" class="nav_toggle"><span class="fa fa-bars"></span></a>
        <ul class="blog_nav_content">
          <p class="back"><a href="javascript:;" class="blog_nav_close"><span class="fa fa-window-close"></span></a></p>
          <h3>大思考</h3>
          <li><a href="#"><span class="fa fa-home"></span>首页</a></li>
          <li><a href="#">前端开发</a></li>
          <li><a href="#">其它</a></li>
        </ul>
      </div>
      <div class="person_center">
        <!-- 没有登陆之前显示注册，登录 -->
        <div class="no_login">
          <!-- <a href="#" class="btn btn-default navbar-btn">注册</a>
        <a href="#" class="btn btn-default navbar-btn">登录</a> -->
        </div>
        
        <!-- 登录之后显示用户头像 -->
        <div class="is_login">
          <a href="javascript:;" class="menu_toggle"><img src="./images/avatar.jpg"></a>
          <ul class="person_menu">
            <!-- 当用户有消息的时候 个人中心后面加一个小红点 -->
            <li class="is_message"><a href="/blog/person.php">个人中心</a></li>
            <!-- 当用户没有消息的时候 个人中心后面不加小红点 -->
            <!-- <li class="no_message"><a href="#">个人中心</a></li> -->
            <li><a href="/blog/user/login.php?action=logout">退出登陆</a></li>
          </ul>
        </div>
        
      </div>
    </div>
  </nav>
</div>



<script src="/blog/lib/jquery/jquery.min.js"></script>
<script src="/blog/js/topbar.js"></script>