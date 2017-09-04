<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 13:00
 */
$db = require_once CONFIG . DS . 'db.php';
$redis = require_once CONFIG . DS . 'redis.php';

$config = [
    'mysql' => $db,
    'redis' => $redis,
    'modules' => 'agent,truck,user',
    //默认路由
    'defaultRoute' => 'agent/Index/index'
];

return $config;