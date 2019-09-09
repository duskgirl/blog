<?php
  // 这里不导入配置文件，因为每个页面都加载了配置文件
  // require_once './config.php';
  // 连接数据库
  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect) {
    exit('查询热门和最新文章失败');
  }
  mysqli_set_charset($connect,'utf8');
  // 获取热门文章,按照被查看的次数排序,限制三条,需要数据header,id,content ,也要求查询的文章有分类存在
  $hot_sql = 'select a.id,header,content from article as a inner join category as c on a.category_id = c.id order by viewnumber desc limit 3';
  $hot_query = mysqli_query($connect,$hot_sql);
  if(!$hot_query){
    exit('查询热门文章失败');
  }
  while($row = mysqli_fetch_array($hot_query)){
    $GLOBALS['hot_result'][] = $row;
  }

  // 获取最新发布文章,按照文章id从大到小排序,限制三条,需要数据header,id,content ,也要求查询的文章有分类存在
  $new_sql = 'select a.id,header,content from article as a inner join category as c on a.category_id = c.id order by a.id desc limit 3';
  $new_query = mysqli_query($connect,$new_sql);
  if(!$new_query){
    exit('查询最新发布文章失败');
  }
  while($row = mysqli_fetch_array($new_query)){
    $GLOBALS['new_result'][] = $row;
  }
?>
<!-- 右侧：搜索框 最近发表  -->
  <section class="sidebar hidden-xs">
    <form action="/blog/index.php" method="get">
      <input type="search" class="form-control" placeholder="键入关键字搜索" name="search" />
      <input type="submit" value="搜索" class="btn btn-default" />
    </form>
    <div class="hot">
      <h3>热门文章</h3>
      <ul>
        <?php if(!empty($hot_result)):?>
        <?php foreach($hot_result as $key => $item):?>
        <li><a href="<?php echo $item['content']?>?id=<?php echo $item['id']?>"><?php echo $item['header']?></a></li>
        <?php endforeach?>
        <?php endif?>
      </ul>
    </div>
    <div class="new">
      <h3>最新发布</h3>
      <ul>
        <?php if(!empty($new_result)):?>
        <?php foreach($new_result as $key => $item):?>
        <li><a href="<?php echo $item['content']?>?id=<?php echo $item['id']?>"><?php echo $item['header']?></a></li>
        <?php endforeach?>
        <?php endif?>
      </ul>
    </div>
  </section>