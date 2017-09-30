<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 13:00
 */
$db = require_once CONFIG . DS . 'db.php';
$redis = require_once CONFIG . DS . 'redis.php';
$params = require_once CONFIG. DS. 'params.php';
$wlConfig = require_once  "wl.php";
$config = [
    'mysql' => $db,
    'redis' => $redis,
    //设置模块
    'modules' => 'weixin,test,wl',
    //默认路由
//    'defaultRoute' => 'wl/Index/index',
    'defaultRoute' => 'weixin/menu/create',
    //微信设置
    'appid' => 'wx4312b6653b58b512',
    'appsecret' => '3a438566d22b7b20a7d6d1f527a84dc2',
    'token' => '',
    'wlConfig' => $wlConfig
];

return $config;