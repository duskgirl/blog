<?PHP
require_once './config.php';
require_once './functions.php';
blog_get_admin_user();
// 获取文章分类
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  getCategory();
}
function getCategory(){
  $sql = 'select id,name from category';
  blog_select_all($sql);
}



// 处理直接添加文章的页面
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  // var_dump($_POST);
  // var_dump($_POST['content']);
  // date_default_timezone_set('PRC');
  // var_dump(Date('Y-m-d H:i:s'));
  // $time = time();
  // var_dump(Date('Y-m-d H:i:s',$time));
  // $url =  __FILE__;
  // echo $_SERVER['HTTP_HOST'];
  // 将文件的header和keywords和content(就是文件的地址)保存到数据库中
  // 根据首页需要文章的标题,发表时间,作者名称，分类名称,缩略图,简介
  // 文章页面需求：标题,发表时间,作者名称，分类名称，关键词
  // 文章页头需求：页头的title,页头的关键词(就直接利用文章本身的标题和文章本身的关键词)
  // 接收数据并校验、持久化、响应
  // var_dump($data);
  // 生成html文件
  // file_put_contents($path,$data);
  getArticle();
 
}
function getArticle(){
  if(is_admin()){
    if(!$_POST['header']) {
      $GLOBALS['err_message'] = '请输入文章标题';
      return;
    }
    if(!$_POST['indroduction']) {
      $GLOBALS['err_message'] = '请输入文章简介';
      return;
    }
    if(!$_POST['keywords']) {
      $GLOBALS['err_message'] = '请输入文章关键词';
      return;
    }
    if(!$_POST['category']) {
      $GLOBALS['err_message'] = '请选择文章分类';
      return;
    }
    if(!$_POST['thumbnail']) {
      $GLOBALS['err_message'] = '请输入文章缩略图';
      return;
    }
    if(!$_POST['content']) {
      $GLOBALS['err_message'] = '请输入文章内容';
      return;
    }
    // 接收并校验到了数据
  $header = $_POST['header'];
  $introduction = $_POST['indroduction'];
  $keywords = $_POST['keywords'];
  $category = (int)$_POST['category'];
  $thumbnail = $_POST['thumbnail'];
  $content = $_POST['content'];

  // 持久化数据
  // 获取当前时间戳为文件名
  date_default_timezone_set('PRC');
  $time = time();
  $path = $_SERVER['DOCUMENT_ROOT'].'/blog/article/';
  $path = $path.$time.'.php';
  $top = file_get_contents('article-top.php');
  $bottom = file_get_contents('article-bottom.php');
  $data = $top.$content.$bottom;
  file_put_contents($path,$data);
  // 数据库保存的路径是网址的根路径下的地址
  $content_path = '/blog/article/'.$time.'.php';
  // 根据首页需要文章的标题($header),发表时间,作者名称，分类名称,缩略图,简介
  // 文章页面需求：标题,发表时间,作者名称，分类名称，关键词
  // 文章页头需求：页头的title,页头的关键词(就直接利用文章本身的标题和文章本身的关键词)

  // 连接数据库
  $sql = "insert into article (header,thumbnail,introduction,keywords,content,category_id) values ('{$header}','{$thumbnail}','{$introduction}','{$keywords}','{$content_path}',{$category})";
  $result = blog_update($sql);
  if(!$result){
    $GLOBALS['err_message'] = '保存到数据库失败';
    return;
  }
  $GLOBALS['success_message'] = '文章添加成功';
  // 获取数据执行结果 
  // 响应跳转
  header('location:/blog/admin/article.mana.php');
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./lib/simplemde/simplemde.min.css">
  <link rel="stylesheet" href="./lib/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/article.css">


</head>

<body>
  <div class="container-fluid blog_article_add">
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
    <h1>添加文章</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
      <h3>标题</h3>
      <input type="text" class="form-control" maxlength="30" placeholder="请输入文章标题" name="header">
      <h3>简介</h3>
      <input type="text" class="form-control" maxlength="90" placeholder="请输入文章简介" name="indroduction">
      <h3>关键词</h3>
      <input type="text" class="form-control" maxlength="50" placeholder="请输入文章关键词" name="keywords">

      <h3>请选择文章所属分类</h3>
      
      <select class="form-control" name="category">
        <?php if(isset($array)):?>
        <?php foreach($array as $key => $item):?>
        <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
        <?php endforeach?>
        <?php endif?>
      <select>


      <h3>首页文章缩略图</h3>
      <input type="text" class="form-control" maxlength="50" placeholder="请输入文章缩略图" name="thumbnail">
      <textarea id="simplemde" name="content" >
        '<p class="text">In vehicula urna </p>
         <img src="./images/banner_1.jpg" alt="">
         <p class="text">天生的美女，从小到大就</p>
         <p class="text">天生的美女，从小到大就</p>
         <img src="./images/banner_2.jpg" alt="">
         <p class="text">In vehicula urna</p>'
      </textarea>
      <input type="submit" value="提交" class="btn" id="btn">
    </form>

  </div>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>