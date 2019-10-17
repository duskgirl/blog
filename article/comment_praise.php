<?php
$root_path = $_SERVER['DOCUMENT_ROOT'];
require_once($root_path.'/functions.php');
header('Content-Type: application/json;charset=utf-8');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  praise();
}
function praise(){
  if(empty($_POST['user_id'])){
    $result = result('success','请先注册登陆',false);
    echo $result;
    return;
  }
  $post_id = $_POST['user_id'];
  if(empty($_POST['comment_id'])){
    $result = result('success','请正常操作',false);
    echo $result;
    return;
  }
  $comment_id = $_POST['comment_id'];
  // // 这里不应该传点赞的数量,应该以数据库点赞的数量为准传给客户端
  // if(!isset($_POST['love_num'])){
  //   $result = result('success','请正常操作',false);
  //   echo $result;
  //   return;
  // }
  // $love_num = $_POST['love_num'];

  // 在这之前应该判断用户是点赞还是取消点赞
  // 根据传递过来的值在评论表找是否有这个用户向这个评论点赞的记录，如果有
  // 则取消点赞
  // 如果没有则是点赞行为

  // 先查询评论表


  // 这里看要不要考虑不要点赞表，直接插入信息表？
  // 看有没有这个同样的记录有就取消点赞
  // 没有就增加点赞
  // 如何保证当该用户给谁点赞了以后页面持续保证是有标记状态
  // 这里就联合评论表做同样的处理，查询评论的同时查询该用户点赞
  // 这里还要修改一下是那种缓存处理来增加点赞数量，而不是直接数据库交互那种
  // 该评论id找到发评论的人，该用户id看是否点赞
  // 根据
  

  $is_love_sql = "select post_id,comment_id from praise where post_id={$post_id} and comment_id={$comment_id}";
  $is_love_row = blog_select_one($is_love_sql);
  // 有该条记录，则表示用户是取消点赞
  if($is_love_row){
    // 得先删除表中记录，并且love的数量也发生变化
    // 取消点赞
    $cancel_love_sql = "delete from praise where post_id={$post_id} and comment_id={$comment_id}";
    $cancel_love_row = blog_update($cancel_love_sql);
    // 取消点赞失败
    if(!$cancel_love_row){
      $result = result('cancel','取消点赞失败,请稍后重试',false);
      echo $result;
      return;
    }
    // 取消点赞成功第一步
    // 这里继续取消点赞第二步
    // 评论表love数量减一
    // 
    $cancel_num_sql = "update comment set love=love-1 where id={$comment_id}";
    $cancel_num_row = blog_update($cancel_num_sql);
    // 取消点赞数量减少失败
    if(!$cancel_num_row){
      $result = result('cancel','取消点赞失败，请稍后重试',false);
      echo $result;
      return;
    }
    // 取消点赞数量减少成功
    $result = result('cancel',null,true);
    echo $result;
    return;
  }


  // 当前用户未向该评论点赞
  // 根据评论id找到接收用户的id
  $receive_id_sql = "select user_id from comment where id={$comment_id}";
  $receive_id_row = blog_select_one($receive_id_sql);
  if(!$receive_id_row){
    $result = result('success','点赞失败，请稍后重试',false);
    echo $result;
    return;
  }
  $receive_id = $receive_id_row['user_id'];
  // 还要更新评论表赞的数量
  $praise_sql = "insert into praise (post_id,comment_id,receive_id) values ({$post_id},{$comment_id},$receive_id)";
  $result = blog_update($praise_sql);
  if(!$result){
    $result = result('success','点赞失败，请稍后重试',false);
    echo $result;
    return;
  } else {
    // 点赞成功第一步
    // 点赞成功第二步还需增加点赞数量
    $praise_num_sql = "update comment set love=love+1 where id={$comment_id}";
    $praise_num_row = blog_update($praise_num_sql);
    if(!$praise_num_row){
      // 点赞成功第二步失败
      $result = result('success','点赞失败，请稍后重试',false);
      echo $result;
      return;
    }
    $result = result('success',null,true);
    echo $result;
  }
}
function result($title,$message,$value){
  if(empty($message)){
    $result = array(
      $title => $value
    );
  } else {
      $result = array(
        $title => $value,
        'message' => $message
      );
    }
  $result = json_encode($result);
  return $result;
}