<?php
$root_path = $_SERVER['DOCUMENT_ROOT'];
require_once($root_path.'/admin/functions.php');
blog_get_admin_user();
// 页面搜索功能实现
// 渲染页面查询操作(有/无id)
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  $search = '';
  $search_value = '';
  // $search => &search='';
  if(!empty($_GET['search'])){
    $search .= '&search='.$_GET['search'];
    $search_value = $_GET['search'];
    $search_value = trim($search_value);
    $search_value_num = mb_strlen($search_value);
    $search_result = '';
    for($i=0;$i<$search_value_num;$i++){
      $search_result .= mb_substr($search_value,$i,1) . '%';
    }
    $search_value = $search_result;
  }
  if(!empty($_GET['articleId'])){
    deleteArticle();
  }
  $total_sql = "select 
  count('total') as totalRow 
  from article as a 
  inner join category as c 
  on a.category_id = c.id 
  where a.header like '%{$search_value}%'";
  blog_get_page($total_sql);
  getArticleMana();
}
function getArticleMana(){
  global $search_value;
  // 获取总页
  if($GLOBALS['total']>0){
    $skip = $GLOBALS['skip'];
    $per_list =  $GLOBALS['$per_list'];
    $sql = "select
    a.header,
    a.author,
    a.pubtime,
    a.id,
    a.content,
    a.category_id,
    c.id as categoryid,
    c.name as categoryname 
    from article as a 
    inner join category as c on a.category_id = c.id 
    where a.header like '%{$search_value}%' 
    order by a.id desc 
    limit {$skip},{$per_list}";
    // var_dump($sql);
    $result = blog_select_all($sql);
  }
}

// 删除指定
function deleteArticle(){
  if(is_admin()){
    if(empty($_GET['id']) && empty($_GET['articleId'])){
      exit('请传入必要参数');
    }
    $articleId = $_GET['articleId'];
    $connect = blog_connect();
    mysqli_query($connect,"SET foreign_key_checks = 0");
    $sql = "delete from article where id={$articleId}";
    var_dump($sql);
    $result = blog_update($sql);
    if(!$result){
      $GLOBALS['err_message'] = '数据删除失败';
    };
    $GLOBALS['success_message'] = '数据删除成功';
    mysqli_query($connect,"SET foreign_key_checks = 1");
    header('Location:'.$_SERVER['HTTP_REFERER']);
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
  <title>大思考-后台文章管理</title>
  <meta name="keywords" content="大思考,大思考博客,前端开发,前端开发博客" />
  <meta name="description" content="大思考博客是一个分享前端开发相关知识的博客网站" />
  <link rel="stylesheet" href="/admin/lib/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/admin/lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/admin/css/article_mana.css">
  <link rel="stylesheet" href="/admin/css/topbar.css">
  <link rel="stylesheet" href="/admin/css/sidebar.css">
  <link rel="stylesheet" href="/admin/css/pagination.css">
  <link rel="stylesheet" href="/admin/css/public.css">
  
</head>

<body>
  <!-- 顶部通栏 bolg的logo+后台管理系统左侧 右侧搜索框倒三角符号显示登陆者账户名以及退出 -->
  <div class="container-fluid">
  <?php include $root_path.'/admin/static/topbar.php'?>
    <div class="blog_admin_main">
    <?php $current_nav='article';?>
    <?php include $root_path.'/admin/static/sidebar.php'?>
    <section class="blog_admin_center">
      <ol class="breadcrumb">
        <li><a href="/admin/index.php">首页</a></li>
        <li class="active"><a href="/admin/article_mana.php">文章管理</a></li>
      </ol>

      <?php if(isset($err_message)): ?>
      <div class="alert alert-danger prompt_message  alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>错误!</strong><?php echo $err_message?>
      </div>
      <?php endif ?>
      <?php if(isset($success_message)): ?>
    <div class="alert alert-success prompt_message  alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>成功!</strong><?php echo $success_message?>
    </div>
    <?php endif ?>

      <a class="btn" href="/admin/article.php">添加文章</a>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>分类</th>
            <th>标题</th>
            <th>作者</th>
            <th>日期</th>
            <th>操作</th>
          </tr>
          <tbody>
            <?php if($total>0):?>
            <?php if(isset($array)):?>
            <?php foreach($array as $key => $item): ?>
            <tr>
              <td><?php echo $item['categoryname']?></td>
              <td class="ellipsis"><a href="<?php echo $item['content']?>?id=<?php echo $item['id']?>"><?php echo $item['header']?></a></td>
              <td><?php echo $item['author']?></td>
              <td><?php echo $item['pubtime']?></td>
              <td><a class="btn" href="?id=<?php echo $item['categoryid']?>&articleId=<?php echo $item['id']?>">删除</a>
             </td>
            </tr>
            <?php endforeach?>
            <?php endif?>
            <?php elseif($total == 0):?>
            <tr class="nofound">
              <td colspan="5">抱歉！没有找到相关文章!</td>
            </tr>
            <?php endif?>
          </tbody>
        </thead>
      </table>
      <?php include $root_path.'/admin/static/pagination.php'?>
    </section>
    </div>
  </div>

  <script src="/admin/lib/jquery/jquery.min.js"></script>
  <script src="/admin/lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>