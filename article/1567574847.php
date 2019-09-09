<?php
require_once '../config.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  getviewnumber();
}
function getArticle(){
  if(empty($_GET['id'])){
    exit('缺少必要参数');
  }
  $id = $_GET['id'];
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  mysqli_set_charset($connect,'utf8');
  if(!$connect) {
    exit('连接数据库失败');
  }
  // 获取当前页面数据
  $current_sql = "select a.id,a.header,a.author,a.keywords,a.pubtime,a.content,a.viewnumber,c.name from article as a inner join category as c on a.category_id = c.id where a.id={$id} limit 1";
  $current_query = mysqli_query($connect,$current_sql);
  if(!$current_query) {
    exit('数据查询失败');
  }
  $GLOBALS['current_row'] = mysqli_fetch_array($current_query);

  // 获取当前页面的上一条数据
  $prev_sql = "select id,header,content from article where id=(select min(id) from article where id>{$id})";
  $prev_query = mysqli_query($connect,$prev_sql);
  if(!$prev_query) {
    exit('数据查询失败');
  }
  $GLOBALS['prev_row'] = mysqli_fetch_array($prev_query);
  // 获取当前页面的下一条数据
  $next_sql = "select id,header,content from article where id=(select max(id) from article where id<{$id})";
  $next_query = mysqli_query($connect,$next_sql);
  if(!$next_query) {
    exit('数据查询失败');
  }
  $GLOBALS['next_row'] = mysqli_fetch_array($next_query);
}
function getviewnumber(){
    if(empty($_GET['id'])){
      exit('缺少必要参数');
    }
    $id = $_GET['id'];
    // 获取最初被查看的次数
    $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if(!$connect) {
      exit('数据库连接失败');
    }
    mysqli_set_charset($connect,'utf8');
    $sql = "select viewnumber from article where id={$id}";
    $query = mysqli_query($connect,$sql);
    if(!$query) {
      exit('获取查看次数数据失败');
    }
    $viewnumber = mysqli_fetch_array($query)['viewnumber'];
    getArticle();
    $viewnumber += 1;
    $sql_add = "update article set viewnumber = {$viewnumber} where id={$id}";
    $query = mysqli_query($connect,$sql_add);
    if(!$query) {
      exit('更新数据失败');
    }
    if(mysqli_affected_rows($connect)<=0){
      $GLOBALS['err_message'] = '更新查看次数数据失败';
    } else {
      $GLOBALS['err_message'] = '更新查看次数成功';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="keywords" content="<?php echo $current_row['keywords']?>">
  <title><?php echo $current_row['header'] ?></title>
  <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/topbar.css">
  <link rel="stylesheet" href="../css/sidebar.css">
  <link rel="stylesheet" href="../css/footer.css">
  <link rel="stylesheet" href="./css/article.css">
</head>

<body>

  <?php include '../topbar.php'?>

  <!-- 网站主体内容 -->
  <!-- 左侧：博客标题、博客发表时间、作者、所属分类，文章主图 -->
  <main class="blog_main container">
    <section class="mainbar">
      <div class="content">
      <h3><?php echo $current_row['header']?></h3>
      <p class="time_author">
        <span class="fa fa-calendar-check-o"></span><span> <?php echo $current_row['pubtime']?> </span>
        <span class="fa fa-user-o"></span><span> <?php echo $current_row['author']?> </span>
        <span class="fa fa-folder-open-o"></span><span> <?php echo $current_row['name']?> </span>
        <span class="fa fa-eye"></span><span> <?php echo $current_row['viewnumber']?> </span>
     </p>
      <p class="text">In vehicula urna </p>
      <img src="./images/banner_1.jpg" alt="">
      <p class="text">天生的美女，从小到大就</p>
      <p class="text">天生的美女，从小到大就</p>
      <img src="./images/banner_2.jpg" alt="">
      <p class="text">In vehicula urna</p>
     
      </div>
      <div class="point">
        <?php if(isset($prev_row)):?>
        <a class="arrow_left" href="<?php echo $prev_row['content']?>?id=<?php echo $prev_row['id']?>">
          <span class="fa fa-long-arrow-left arrow"></span>
          <span class="text"><?php echo $prev_row['header']?></span>
        </a>
        <?php else:?>
        <a class="arrow_left" href="<?php echo $current_row['content']?>?id=<?php echo $current_row['id']?>">
          <span class="fa fa-long-arrow-left arrow"></span>
          <span class="text"><?php echo $current_row['header']?></span>
        </a>
        <?php endif?>
        <?php if(isset($next_row)):?>
        <a class="arrow_right" href="<?php echo $next_row['content']?>?id=<?php echo $next_row['id']?>">
          <span class="text"><?php echo $next_row['header']?></span>
          <span class="fa fa-long-arrow-right arrow"></span>
        </a>
        <?php else: ?>
        <a class="arrow_right" href="<?php echo $current_row['content']?>?id=<?php echo $current_row['id']?>">
          <span class="text"><?php echo $current_row['header']?></span>
          <span class="fa fa-long-arrow-right arrow"></span>
        </a>
        <?php endif?>
      </div>
    </section>
    <?php include '../sidebar.php'?>
  </main>

  <!-- 脚本： -->
  <?php include '../footer.php'?>
  <script src="../lib/jquery/jquery.min.js"></script>
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>