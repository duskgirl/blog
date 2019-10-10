<?php
require_once './config.php';
require_once './functions.php';
$user = blog_get_current_user();
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  // 必须先注册登陆才能进去
  if($user == null){
    $_SESSION['url'] = '/blog/person_message.php';
    header('Location: /blog/user/login.php');
  }
  // 设置搜索功能
  $where = '1=1';
  $search = '';
  require_once './get_message_page.php';
  if(!empty($_GET['id'])){
    delete_message();
  }
  get_person_message();
}
function delete_message(){
  if(empty($_GET['id'])){
    $GLOBALS['warn_message'] = 1;
    return;
  }
  $id = $_GET['id'];
  $sql = "delete from message where id in ({$id})";
  $result = blog_update($sql);
  if(!$result){
    $GLOBALS['warn_message'] = 1;
    return;
  }
  header('Location:'.$_SERVER['HTTP_REFERER']);
}
function get_person_message(){
  // 连接数据库；
  // 查询数据；
  // 响应
  global $skip,$every,$where,$user;
  $user_id = $user['id'];
  $total_sql = "select count(id) as total from message where receive_id={$user_id}";
  $total_result = blog_select_one($total_sql);
  $GLOBALS['total'] = $total_result['total'];
  if($GLOBALS['total']>0){
    // 默认显示六条数据
    $sql = "select id,
    message,
    send_time,
    read_status 
    from message 
    where receive_id={$user_id} order by id desc limit {$skip},{$every}";
    $GLOBALS['result'] = blog_select_all($sql);
  }
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
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/sidebar.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/person_nav.css">
  <link rel="stylesheet" href="./css/person_message.css">
  <link rel="stylesheet" href="./css/public.css">
  <link rel="stylesheet" href="./css/pagination.css">
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
          <?php if(isset($total)):?>
          <div class="total">
            <!-- /blog/api/delete_message.php -->
            <a href="<?php echo $_SERVER['PHP_SELF']?>" class="btn btn-default delete_message" disabled>删除</a>
            <p>共有<strong><?php echo $total?></strong>条消息</p>
          </div> 
          <?php endif?>
          <table class="table table-hover table-striped table_message">
            <thead>
              <tr>
                <th class="check"><input type="checkbox" class="check_total" /></th>
                <th class="message">主题</th>
                <th class="time">时间</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($total)):?>
              <?php if(!empty($result)):?>
              <?php foreach($result as $key => $item):?>
              <tr <?php echo $item['read_status'] == 1 ? '' : 'class="read"' ?> id="<?php echo $item['id']?>">
                <td><input type="checkbox" class="check_item" /></td>
                <!-- 显示出来的消息应该是恭喜：您发表的评论：xxxxx,已通过管理员审核 -->
                <td class="message ellipsis">
                  <a href="javascript:;" class="read_message">
                    <span class="fa fa-envelope email"></span>
                    <?php echo $item['message']?>
                  </a>
                </td>
                <!-- 这里的时间应该是通过审核的时间 -->
                <td class="time ellipsis"><?php echo $item['send_time']?></td>
              </tr>
              <?php endforeach?>
              <?php endif?>
              <?php else:?>
              <tr class="no_message">
                <td colspan="3">您当前还没有消息喔！</td>  
              </tr>
              <?php endif?>
                <!-- 显示出来的消息应该是通知：冷冷赞了你的评论:xxx -->



                
                <!-- 评论审核消息，评论被回复消息，评论被点赞消息 -->
                <!-- 这里就需要重新修改以前评论的管理 -->
                <!-- 评论审核消息： 在后台审核通过、或者删除消息的时候将在message插入数据 -->
                <!-- 评论被回复消息: 1.审核通过该评论以后，看有没有父parent_id，有则需要message插入数据 -->
                <!-- 评论被点赞消息：1.当点赞一发生，就应该给message插入数据 -->


                <!-- 数据库表设计：id,send(发送消息的人，评论审核通过
                均为管理员，点赞和回复评论的人为发送消息的人),receive（接收消息的人）,
                comment,read（阅读状态）,message（内容），time(发送消息的时间) -->
                <!-- 直接删除了用户的评论，就找不到评论id呀， -->
                <!-- 1 1 1  -->
                <!-- 消息系统数据库设计 -->
                <!-- 站内信的数据库设计 -->
                <!-- 通知消息提醒的数据库设计 -->

            </tbody>
          </table>
      </div>
      <?php include './person_message_page.php'?>
    </section>
  </main>
  <?php include 'footer.php'?>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="/blog/lib/artDialog-master/dialog.js"></script>
  <script src="/blog/lib/art-template/template-web.js"></script>
  <script src="/blog/js/person_message.js"></script>
  <script>
  $(function(){
    var warn_message = <?php echo !empty($warn_message) ? 1 : 2 ?>;
    var is_delete_success = <?php echo !empty($warn_message) ? 1 : 2 ?>;
    if(warn_message == 1)  {
      // 删除成功
      if(is_delete_success == 1){
        title = '抱歉';
        content = '消息删除失败,请稍后重试!';
      }
      warn(title,content);
    }
    function warn(title, content) {
    var d = dialog({
      title: title,
      content: content,
      cancel: false,
      ok: function() {},
      quickClose: true
    });
    d.show(document.getElementById('option-quickClose'));
    setTimeout(function() {
      d.close().remove();
    }, 30000);
  };
  })
  </script>
  
</body>

</html>