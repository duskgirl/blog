<?php
require_once './config.php';
require_once './functions.php';
blog_get_current_user();
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
  // $test = '我喜欢你';
  // $test = trim($test);
  // $num = mb_strlen($test);
  // $result = '';
  // for($i=0;$i<$num;$i++){
  //   $result .= mb_substr($test,$i,1).'%';
  // }
  // var_dump($result);
  // $test = explode(' ',$test);
  // $test = implode('a',$test);
  // var_dump($test);
  // 如果两种情况都有了的话 $search => &search=3&page=2
  // var_dump($search);
  require_once './getarticlepage.php';
  if(!empty($_GET['articleId'])){
    deleteArticle();
  }
  getArticleMana();
}
function getArticleMana(){
  global $per_list,$skip,$search_value;
  $sql = "select a.header,a.author,a.pubtime,a.id,a.content,a.category_id,c.id as categoryid,c.name as categoryname from article as a inner join category as c on a.category_id = c.id where a.header like '%{$search_value}%' order by a.id desc limit {$skip},{$per_list}";
  $result = blog_select_all($sql);
  if(!$result) {
    $GLOBALS['err_message'] = '查询数据失败';
  }
}

// 删除指定
function deleteArticle(){
  if(is_admin()){
    if(empty($_GET['id']) && empty($_GET['articleId'])){
      exit('请传入必要参数');
    }
    $articleId = $_GET['articleId'];
    $sql = "delete from article where id={$articleId}";
    $result = blog_update($sql);
    if(!$result){
      $GLOBALS['err_message'] = '数据删除失败';
    };
    $GLOBALS['success_message'] = '数据删除成功';
    header('Location:'.$_SERVER['HTTP_REFERER']);
  }
}

?>


<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>后台管理系统-文章管理</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/article-mana.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/sidebar.css">
  <link rel="stylesheet" href="./css/pagination.css">
  
</head>

<body>
  <!-- 顶部通栏 bolg的logo+后台管理系统左侧 右侧搜索框倒三角符号显示登陆者账户名以及退出 -->
  <div class="container-fluid">
    <?php include './topbar.php'?>
    <div class="blog_admin_main">
      <?php include './sidebar.php'?>
    <section class="blog_admin_center">
      <ol class="breadcrumb">
        <li><a href="/blog/admin/index.php">首页</a></li>
        <li><a href="/blog/admin/category.php">分类管理</a></li>
        <li class="active"><a href="/blog/admin/article.mana.php">文章管理</a></li>
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

      <a class="btn" href="/blog/admin/article.php">添加文章</a>
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
            <?php if(isset($array)):?>
            <?php foreach($array as $key => $item): ?>
            <tr>
              <td><?php echo $item['categoryname']?></td>
              <td class="ellipsis"><a href="<?php echo $item['content']?>?id=<?php echo $item['id']?>"><?php echo $item['header']?></a></td>
              <td><?php echo $item['author']?></td>
              <td><?php echo $item['pubtime']?></td>
              <td><a class="btn" href="/blog/admin/article.mana.php?id=<?php echo $item['categoryid']?>&articleId=<?php echo $item['id']?>">删除</a>
             </td>
            </tr>
            <?php endforeach?>
            <?php endif?>
            <?php if($total === 0):?>
            <tr class="nofound">
              <td colspan="5">抱歉！没有找到相关文章!</td>
            </tr>
            <?php endif?>
          </tbody>
        </thead>
      </table>
      <?php include './pagination.php'?>
    </section>
    </div>
  </div>

  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>