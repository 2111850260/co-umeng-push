<?php
//require_once(dirname(__FILE__) . '/src/AndroidPush.php');
//require_once(dirname(__FILE__) . '/src/IosPush.php');


use UmengPush\AndroidPush;
use UmengPush\IosPush;

$andriodConfig = [
    "APPKEY"        =>"",
    "MESSAGE_DEBUG" =>"false", //正式/测试模式。默认为true
    "APP_MASTER_SECRET" =>""
];
$andriod = new AndroidPush($andriodConfig);
$token = '';
$andriod->pushMsg($token, json_encode([
    'ticker' => '',
    'title' => 'test',
    'text' => 'this is a test',
]));

$iosConfig = [
    "APPKEY"        =>"",
    "MESSAGE_DEBUG" =>"false", //正式/测试模式。默认为true
    "APP_MASTER_SECRET" =>""
];
$ios = new IosPush($andriodConfig);
$token = '';
$ios->pushMsg($token, [
    'subtitle' => '',
    'title' => 'test',
    'body' => 'this is a test',
]);
