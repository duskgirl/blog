
<?php
// <!-- 按照你上面的意思，好像是不通过ajax请求后台。只是前端 mock 一大堆数据，一次性把这个数据全部请求回来，然后通过事件分批展示（比如总共有50条，每次点击按钮展示新的10条）。

// var data = list, // list 为返回的数据列表
//     dataSize = data.length,
//     showNum = 10,
//     page = 0,
//     loadData = [];

// for (var i = 0; i < dataSize; i += showNum) {
//     loadData.push(data.slice(i, i + showNum));
// }
// loadData 是一个二维数组，它的每项是一个长度为 showNum 的数组。

// 最后，通过事件触发数据按批渲染：

// btn.addEventListener('click', function() {
//     page += 1;
//     render(loadData[page]);
// }, false); -->
// 测试页面
header('Content-Type: application/json');
require_once '../config.php';
require_once '../functions.php';
if((empty($_GET['id'])||empty($_GET['page']))&&(empty($_GET['comment_id'])||empty($_GET['page']))){
  exit('缺少必要的参数!');
}
if($_SERVER['REQUEST_METHOD'] === 'GET'){
  get_page();
}
// 
function get_page(){

  if(!empty($_GET['id'])&&!empty($_GET['page'])){
    $aid = $_GET['id'];
    $page = $_GET['page'];
    if($page>=2){
      $size = 10;
      $skip = 2+$size*($page-2);
    } else {
      $size = 2;
      $skip = $size*($page-1);
    }
  // 点击查看更多评论的时候我就只是知道跳过多少行显示多少条数据即可
  // 我这里也应该是查询到所有的数据然后根据情况返回数据
  // 其实不可能单独请求父元素评论，父评论和子评论是要同时返回数据的
  // 这里size不对哈，这样我总共只能请求到两条数据，不分父评论还是子评论
  // 这里我应该怎么想办法查询到两个父评论下面的前两条评论,怎么能再这个sql语句中返回数据呢
  // 这里查询到的是这两条的主评论
  $parent_sql = "select
  a.id as aid,
  u.avatar,
	u.name,
  c.id,
  c.comment_time,
  c.content,
  c.parent_id,
  c.love,
  c.children_num
  from comment as c
  inner join user as u on c.user_id = u.id
  inner join article as a on c.article_id = a.id
  where c.audit_status = 1 and a.id = {$aid} and c.parent_id is null
  order by c.love desc
  limit $skip,$size";

  $parent = blog_select_all($parent_sql);
  // 这里应该是查询完毕了
  if(!$parent) {
    $parent = null;
    $children = null;
    $num = null;
    $result = array(
      "parent" => $parent,
      "children" => $children,
      "num" => null
    );
    $result = json_encode($result);
    echo $result;
    return;
  }
  // 查询父评论总数量
  $parent_num_sql = "select 
  count(c.id) as parent_num
  from comment as c
  inner join article as a on c.article_id = a.id
  where c.audit_status = 1 and a.id = {$aid} and c.parent_id is null";
  $parent_num = blog_select_all($parent_num_sql);
  if(!$parent_num){
    $parent = null;
    $children = null;
    $num = null;
    $result = array(
      "parent" => $parent,
      "children" => $children,
      "num" => $num
    );
    $result = json_encode($result);
    echo $result;
    return;
  }
  foreach($parent_num as $key => $item){
    if(isset($item['parent_num']) && !empty($item['parent_num'])) {
      $num = $item['parent_num'];
    }
  }
  // $result是前两条父评论
  $children = array();
  foreach($parent as $key => $item){
    //前面获取到了前两条父评论，这里我根据父评论的id查找comment表有没有parent_id为父评论id的
    // 这里查询子评论
    $children_sql = "select
	    u.name,
      c.id,
      c.comment_time,
      c.content,
      c.parent_id,
      c.love,
      c.children_num
      from comment as c
      inner join user as u on c.user_id = u.id
      where c.audit_status = 1 and c.parent_id = {$item['id']}
      order by c.love desc
      limit $skip,$size";
    // 获取查找到的子评论
    // 子评论将父评论也包含在里面了
    // 这里我应该多套一层加上parent_id或者？用来区分子评论是谁的子评论?也可能不需要区分,前端页面区分即可
    $child = blog_select_all($children_sql);
    if(!$child){
      $children = null;
      $result = array(
        "parent" => $parent,
        "children" => $children,
        "num" => $num
      );
      $result = json_encode($result);
      echo $result;
      return;
    }
    foreach($child as $key => $item){
      if(!empty($item['parent_id'])){
        if(!in_array($item,$children)){
          $children[] = $item;
        }
      }
    }
  }
  $result = array(
    "parent" => $parent,
    "children" => $children,
    "num" => $num
  );
  $result = json_encode($result);
  echo $result;
}
  

  if(!empty($_GET['comment_id'])&&!empty($_GET['page'])){
    $comment_id = $_GET['comment_id'];
    $page = $_GET['page'];
    if($page>=2){
      $size = 10;
      $skip = 2+$size*($page-2);
    } else {
      $size = 2;
      $skip = $size*($page-1);
    }
    // 获取到对应父id下的子评论
    $child_sql = "select 
      u.name,
      c.id,
      c.comment_time,
      c.content,
      c.parent_id,
      c.love,
      c.children_num
      from comment as c
      inner join user as u on c.user_id = u.id
      where c.audit_status = 1 and c.parent_id = {$comment_id}
      order by c.love desc
      limit $skip,$size";
    $children = blog_select_all($child_sql);
    if(!$children) {
      $children = null;
    } else {
      $children = $children;
    }
    $result = array(
      "children" => $children
    );
    $result = json_encode($result);
    echo $result;
  }  
  
  
  //   // 获取子评论
  //   if($item['parent_id']){
  //     $GLOBALS['children_comment'][] = $item;
  //   }
}