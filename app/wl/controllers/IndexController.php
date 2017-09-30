<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/9/20 10:30
 * 微联宝快捷支付
 */
namespace app\wl\controllers;

use component\BaseController;
use component\Common;
use register;

class IndexController extends BaseController
{
    public function indexAction()
    {
//        $config = register::_get('config')['wlConfig'];
//        $data = array();
//        $data['trxType'] = 'OPEN_CARD';
//        $data['signKey'] = 'rwC0ChjtMKyucu62sDWddP9K2NtJUEeW';
////        $data['desKey'] = 'dW9gGocHziv0xjtn28JcnUws';
////        $data['queryKey'] = 'FBYGXdCbHHuTZGzf2kb4Hne7ifD8YFYZ';
//        $data['trxTime'] = date('YmdHis', time());
//        $data['orderNum'] = "qft".substr($data['trxTime'],-4);
//        $data['callbackUrl'] = "http://www.baidu.com";
//		$data['serverCallbackUrl'] = "http://www.baidu.com";
//        $data['merchantNo'] = 'B103244533';
//        $source = "#" . $data['trxType'] . "#" . $data['merchantNo'] . "#" . $data['orderNum'] . "#" . $data['trxTime'] . "#" . $data['callbackUrl'] . "#"
//        . $data['serverCallbackUrl'] . "#" . $data['signKey'];
//        unset($data['signKey']);
//        $data['sign'] = md5($source);
//        $res = Common::http_request($config['url'],$data);
//        print_r($res);


        $data['openid'] = 'oO-mG0W7isAZ2V1ph6eK2g-Lxkuc';
        $data['type'] = 8;
        $data['user_name'] = "tom";
        $data['order_name'] = "111";
        $data['create_time'] = "222";
        $url = "http://dev.wx.78dk.com/v4/templates";
        $res = Common::http_request($url,$data);
        print_r($res);
    }
    public function payAction(){
        echo 'test'."";
    }
}