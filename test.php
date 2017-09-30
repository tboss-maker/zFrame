<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/9/8 14:03
 */
//$redis = new Redis();
//$redis->pconnect('127.0.0.1',6379);
////$redis->set('a','111');
//echo $redis->get('a');
//header("location: weixin://wxpay/bizpayurl?pr=y5e9yJ0");
//header('Location: weixin://wxpay/bizpayurl?pr=y5e9yJ0');
//$a = "http:\/\/pay.cardinfo.com.cn\/middlepaytrx\/wx\/authRedirect\/ZHONGXIN\/ZX20170911172708330dk1s";
//echo urldecode($a);

$redis = new Redis();
$redis->pconnect('192.168.15.248','6381');
$redis->auth('78dk.com');
$redis->select(1);
$redis->flushDB();