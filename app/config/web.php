<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 13:00
 */
$db = require_once CONFIG . DS . 'db.php';
$redis = require_once CONFIG . DS . 'redis.php';
$params = require_once CONFIG. DS. 'params.php';
$config = [
    'mysql' => $db,
    'redis' => $redis,
    //设置模块
    'modules' => 'weixin,test',
    //默认路由
    'defaultRoute' => 'weixin/Menu/create',
    //微信设置
    'appid' => '',
    'appsecret' => '',
    'token' => ''
];

return $config;