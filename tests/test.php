<?php

use SzcDownLoader\DownLoader;

require_once __DIR__ . "/../vendor/autoload.php";

$client = new DownLoader();
$data = $client->download("http://1251022884.vod2.myqcloud.com/d074dd6bvodtranscq1251022884/be644a625285890810122780344/snapshotByTimeOffset/snapshotByTimeOffset_10_0.jpg");
// var_dump($data['result']);
file_put_contents('test.jpg', $data['data']);