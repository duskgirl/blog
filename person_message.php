<?php
 $root_path = $_SERVER['DOCUMENT_ROOT'];
 require_once($root_path.'/functions.php');
$user = blog_get_current_user();
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  // 必须先注册登陆才能进去
  if($user == null){
    $_SESSION['url'] = '/person_message.php';
    header('Location: /user/login.php');
  }
  // 设置搜索功能
  $user_id = $user['id'];
  $where = "receive_id={$user_id}";
  $search = '';
  if(!empty($_GET['id'])){
    delete_message();
  }
  $total_sql = "select 
  count('id') as totalRow 
  from message as m 
  inner join user as u on m.send_id = u.id
  where {$where}";
  blog_get_page($total_sql);
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
  global $where;
  if($GLOBALS['total']>0){
    // 默认显示六条数据
    $skip = $GLOBALS['skip'];
    $per_list =  $GLOBALS['$per_list'];
    $sql = "select id,
    message,
    send_time,
    read_status 
    from message 
    where $where order by id desc limit {$skip},{$per_list}";
    $GLOBALS['result'] = blog_select_all($sql);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="renderer" content="webkit" />
  <meta name="force-renderer" content="webkit" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge chrome=1" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0, shrink-to-fit=no" />
  <meta name="apple-mobile-web-app-title" content="大思考博客" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <meta name="referrer" content="always">
  <meta name="format-detection" content="telephone=no,email=no,adress=no">
  <title>大思考-个人中心</title>
  <meta name="keywords" content="大思考,大思考博客,前端开发,前端开发博客" />
  <meta name="description" content="大思考博客是一个分享前端开发相关知识的博客网站" />
  <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/css/topbar.css">
  <link rel="stylesheet" href="/css/sidebar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/person_nav.css">
  <link rel="stylesheet" href="/css/person_message.css">
  <link rel="stylesheet" href="/css/public.css">
  <link rel="stylesheet" href="/css/pagination.css">
</head>

<body>
<?php include $root_path.'/static/topbar.php'?>
  <main class="blog_main container">
    <section class="mainbar">
    <?php $current_nav = 'person_message'?>
    <?php include $root_path.'/static/person_nav.php'?>
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

                <!-- 这个还未处理 -->
                <!-- 评论被点赞消息：1.当点赞一发生，就应该给message插入数据 -->
                <!-- 解决一下require_once 或者require里面的绝对路径问题 -->
                <!-- 每个页面都加上url session以保证用户登录后还能再返回页面去 -->
                <!-- 为了保证一直数字的一致性，还是得将message表添加一个comment_id,
                同时后台审核的时候不能直接删除评论？可以直接删除,删除的comment_id在message表中为null,
                其它就有comment_id -->
                <!-- 审核处理的时候还需要将评论id插入 -->




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
      <?php include $root_path.'/static/pagination.php'?>
    </section>
  </main>
  <?php include $root_path.'/static/footer.php'?>
  <script src="/lib/jquery/jquery.min.js"></script>
  <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="/lib/artDialog-master/dialog.js"></script>
  <script src="/lib/art-template/template-web.js"></script>
  <script src="/js/person_message.js"></script>
  <script src="/js/topbar.js"></script>
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