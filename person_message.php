<?php
require_once './config.php';
require_once './functions.php';
$user = blog_get_current_user();
?>

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
  <link rel="stylesheet" href="./css/person_message.css">
  <link rel="stylesheet" href="./css/public.css">
</head>

<body>
  <?php include 'topbar.php'?>
  <main class="blog_main container">
    <section class="mainbar">
      <?php include 'person_nav.php'?>
      <div class="person_detail" id="person">        
        <!-- 我的评论页面 -->
        <div class="person_message">
          <h4 class="underline hidden-xs">我的消息</h4>
          <!-- 做翻页 -->
          <p class="total ellipsis">共有<strong>5</strong>条消息</p>
          <table class="table table-hover table-striped table_message">
            <thead>
              <tr>
                <th><input type="checkbox" /></th>
                <th>主题</th>
                <th>时间</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="check"><input type="checkbox" /></td>
                <td class="message ellipsis"><a href="javascript:;"><span class="fa fa-envelope email"></span>恭喜！您的评论已经通过管理员审核了！</a></td>
                <td class="time">2019-10-9</td>
              </tr>
              <tr>
                <td class="check"><input type="checkbox" /></td>
                <td class="message ellipsis"><a href="javascript:;" class="ellipsis"><span class="fa fa-envelope email"></span>冷冷赞了你的评论！</a></td>
                <td class="time">2019-10-9</td>
              </tr>
              <tr>
                <td class="check"><input type="checkbox" /></td>
                <td class="message ellipsis"><a href="javascript:;" class="ellipsis"><span class="fa fa-envelope email"></span>冷冷回复了你的评论！</a></td>
                <td class="time">2019-10-9</td>
              </tr>
              <tr class="read">
                <td class="check"><input type="checkbox" /></td>
                <td class="message ellipsis"><a href="javascript:;" class="ellipsis"><span class="fa fa-envelope-open email"></span>很抱歉！您的评论未通过管理员审核！</a></td>
                <td class="time">2019-10-9</td>
              </tr>
            </tbody>
          </table>
      </div>

    </section>
  </main>
  <?php include 'footer.php'?>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="/blog/lib/artDialog-master/dialog.js"></script>
  <script src="/blog/lib/art-template/template-web.js"></script>

    


</body>

</html>