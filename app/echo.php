<?php

require 'init.php';
require 'post.php';

$postData = GetPostData();
CheckPostData($postData);

$length = unpack('Vlen', $postData)['len'];
$str = unpack('Vlen/a' . $length . 'str', $postData)['str'];

echo $str.' strlen'.strlen($str).' mb_strlen'.mb_strlen($str);
