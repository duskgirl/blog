<?php
require_once './config.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  // 设置搜索功能
  $where = '1=1';
  $search = '';
  if(!empty($_GET['search'])){
    // 
    $search .= '&search='.$_GET['search'];
    $search_value = $_GET['search'];
    $search_value = trim($search_value);
    $search_value_num = mb_strlen($search_value);
    $search_result = '';
    for($i=0;$i<$search_value_num;$i++){
      $search_result .= mb_substr($search_value,$i,1) . '%'; 
    }
    $search_value = $search_result;
    $where .= " and header like '%{$search_value}%'";
  }
  require_once './getindexpage.php';
  getIndex();
}
function getIndex(){
  // 连接数据库；
  // 查询数据；
  // 响应
  global $skip,$every,$where;
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  mysqli_set_charset($connect,'utf8');
  if(!$connect) {
    exit('连接数据库失败');
  }
  $sql = "select a.id,header,pubtime,author,thumbnail,introduction,content,viewnumber from article as a inner join category as c on a.category_id = c.id where {$where} order by id desc limit {$skip},{$every}";
 
  $query = mysqli_query($connect,$sql);
  if(!$query) {
    exit('数据查询失败111');
  }
  while($row = mysqli_fetch_array($query)){
    $GLOBALS['result'][] = $row; 
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>大思考博客首页</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/topbar.css">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/pagination.css">
</head>

<body>
  <?php include 'topbar.php'?>
  <div id="carousel-example-generic" class="carousel slide banner" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="./images/banner_1.jpg">
      </div>
      <div class="item">
        <img src="./images/banner_2.jpg">
      </div>
      <div class="item">
        <img src="./images/banner_3.jpg">
      </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>


  <!-- 网站主体内容 -->
  <!-- 左侧：博客标题、博客发表时间、作者、所属分类，文章主图 -->
  <main class="blog_main container">
    <section class="mainbar">
      <?php if(!empty($result)): ?>
      <?php foreach($result as $key => $item):?>
      <div>
        <h3><?php echo $item['header']?></h3>
        <p>
          <span class="fa fa-calendar-check-o"></span><span> <?php echo $item['pubtime']?> </span>
          <span class="fa fa-user-o"></span><span> <?php echo $item['author']?> </span>
          <span class="fa fa-folder-open-o"></span><span> 前端开发 </span>
          <span class="fa fa-eye"></span><span> <?php echo $item['viewnumber']?> </span>
        </p>
        <div>
          <div style="background-image:url(<?php echo $item['thumbnail']?>)"></div>
          <div>
            <p><?php echo $item['introduction']?>
            </p>
            <a href="<?php echo $item['content']?>?id=<?php echo $item['id']?>" class="btn btn-default">查看更多 <span class="fa fa-angle-double-right"></span></a>
          </div>
        </div>
      </div>
      <?php endforeach ?>

      <?php else:?>
      <div>
      <h4 class="nofound">抱歉！没有找到相关文章！</h4>
      </div>
      <?php endif?>

      <?php include './pagination.php'?>
    </section>
    <!-- 右侧：搜索框 最近发表  -->
    <?php include 'sidebar.php'?>
  </main>
  <?php include 'footer.php'?>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>