<?php

$url = 'http://tool.mkblog.cn/weibovideo/s.php?u=https://weibo.com/tv/v/IujEq5Ven?fid=1034:4471896956141571';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);

curl_close($ch);

echo $response;

?>