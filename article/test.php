<?php
require_once '../config.php';
require_once '../functions.php';
$is_love_sql = "select post_id,comment_id from praise where post_id=1 and comment_id=1";
var_dump($is_love_sql);
$is_love_row = blog_select_one($is_love_sql);
var_dump($is_love_row);