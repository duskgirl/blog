<?PHP
require_once './config.php';
require_once './functions.php';
blog_get_current_user();
// 获取文章分类数据
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  getCategory();
}
function getCategory(){
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('数据库连接失败');
  }
  mysqli_set_charset($connect,'utf8');
  $sql = 'select id,name from category';
  $query = mysqli_query($connect,$sql);
  if(!$query) {
    exit('查询分类数据失败');
  }
  while($row = mysqli_fetch_array($query)){
    $GLOBALS['category_array'][] = $row;
  }
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
  $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  // 设置字符集
  mysqli_set_charset($connect, 'utf8');
  if(!$connect){
    $GLOBALS['err_message'] = '连接数据库失败';
    return;
  }
  // 数据查询
  $sql = "insert into article (header,thumbnail,introduction,keywords,content,category_id) values ('{$header}','{$thumbnail}','{$introduction}','{$keywords}','{$content_path}',{$category})";
  $query = mysqli_query($connect,$sql);
  if(!$query){
    $GLOBALS['err_message'] = '保存到数据库失败';
    return;
  }
  $row = mysqli_affected_rows($connect);
  if($row<=0){
    $GLOBALS['err_message'] = '保存到数据库失败';
    return;
  }
  $GLOBALS['success_message'] = '文章添加成功';
  // 获取数据执行结果 
  // 响应跳转
  header('location:/blog/admin/article.mana.php');
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
  <script src="./lib/simplemde/simplemde.min.js"></script>

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
        <?php foreach($category_array as $key => $item):?>
        <option value="<?php echo $item['id']?>"><?php echo $item['name']?></option>
        <?php endforeach?>
      <select>


      <h3>首页文章缩略图</h3>
      <input type="text" class="form-control" maxlength="50" placeholder="请输入文章缩略图" name="thumbnail">
      <textarea id="simplemde" name="content"></textarea>
      <input type="submit" value="提交" class="btn" id="btn">
    </form>

  </div>
  <script src="./lib/jquery/jquery.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
  <script>
    var simplemde = new SimpleMDE({
      element: document.getElementById("simplemde"),
      spellChecker: false,
      autofocus: true,
      autoDownloadFontAwesome: false,
      placeholder: "",
      autosave: {
        enabled: true,
        uniqueId: "simplemde",
        delay: 1000,
      },
      tabSize: 4,
      status: false,
      lineWrapping: false,
      renderingConfig: {
        codeSyntaxHighlighting: true
      },
      // 工具栏设置
      toolbar: [{
        name: "bold",
        action: SimpleMDE.toggleBold,
        className: "fa fa-bold",
        title: "Bold",
      }, {
        name: "italic",
        action: SimpleMDE.toggleItalic,
        className: "fa fa-italic",
        title: "Italic",
      }, {
        name: "strikethrough",
        action: SimpleMDE.toggleStrikethrough,
        className: "fa fa-strikethrough",
        title: "Strikethrough",
      }, {
        name: "heading",
        action: SimpleMDE.toggleHeadingSmaller,
        className: "fa fa-header",
        title: "Heading",
      }, {
        name: "heading-smaller",
        action: SimpleMDE.toggleHeadingSmaller,
        className: "fa fa-header",
        title: "Smaller Heading",
      }, {
        name: "heading-bigger",
        action: SimpleMDE.toggleHeadingBigger,
        className: "fa fa-lg fa-header",
        title: "Bigger Heading",
      }, {
        name: "heading-1",
        action: SimpleMDE.toggleHeading1,
        className: "fa fa-header fa-header-x fa-header-1",
        title: "Big Heading",
      }, {
        name: "heading-2",
        action: SimpleMDE.toggleHeading2,
        className: "fa fa-header fa-header-x fa-header-2",
        title: "Medium Heading",
      }, {
        name: "heading-3",
        action: SimpleMDE.toggleHeading3,
        className: "fa fa-header fa-header-x fa-header-3",
        title: "Small Heading",
      }, {
        name: "code",
        action: SimpleMDE.toggleCodeBlock,
        className: "fa fa-code",
        title: "Code",
      }, {
        name: "quote",
        action: SimpleMDE.toggleBlockquote,
        className: "fa fa-quote-left",
        title: "Quote",
      }, {
        name: "unordered-list",
        action: SimpleMDE.toggleUnorderedList,
        className: "fa fa-list-ul",
        title: "Generic List",
      }, {
        name: "ordered-list",
        action: SimpleMDE.toggleOrderedList,
        className: "fa fa-list-ol",
        title: "Numbered List",
      }, {
        name: "clean-block",
        action: SimpleMDE.cleanBlock,
        className: "fa fa-eraser fa-clean-block",
        title: "Clean block",
      }, {
        name: "link",
        action: SimpleMDE.drawLink,
        className: "fa fa-link",
        title: "Create Link",
      }, {
        name: "image",
        action: SimpleMDE.drawImage,
        className: "fa fa-picture-o",
        title: "Insert Image",
      }, {
        name: "horizontal-rule",
        action: SimpleMDE.drawHorizontalRule,
        className: "fa fa-minus",
        title: "Insert Horizontal Line",
      }, {
        name: "table",
        action: SimpleMDE.drawTable,
        className: "fa fa-table",
        title: "Insert Table",
      }, {
        name: "preview",
        action: SimpleMDE.togglePreview,
        className: "fa fa-eye no-disable",
        title: "Toggle Preview",
      }, {
        name: "side-by-side",
        action: SimpleMDE.toggleSideBySide,
        className: "fa fa-columns no-disable no-mobile",
        title: "Toggle Side by Side",
      }, {
        name: "fullscreen",
        action: SimpleMDE.toggleFullScreen,
        className: "fa fa-arrows-alt no-disable no-mobile",
        title: "Toggle Fullscreen",
      }]
    });
    // 文本框模板字符
    var template = `
      <p class="text">In vehicula urna </p>
      <img src="./images/banner_1.jpg" alt="">
      <p class="text">天生的美女，从小到大就</p>
      <p class="text">天生的美女，从小到大就</p>
      <img src="./images/banner_2.jpg" alt="">
      <p class="text">In vehicula urna</p>
    `
    simplemde.value(template);
    // 思路：看一下发送ajax数据是否有什么突破；
    // php是怎么将获取到的文字动态生成一个静态页面，然后将静态页面的地址保存到数据库中；
    // php能将数据保存到一个页面文本，不知是否能将这些数据先保存到服务器内，然后再将服务器的地址保存到数据库
    // file_put_contents;
    
  </script>
</body>

</html>