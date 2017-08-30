<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 14:09
 */
namespace app\controllers;

class Controller{
    public function __call($name, $arguments)
    {
//        return array(
//            'code' => '404',
//            'msg' => '您查询的方法不存在...'
//        );
        echo '您查询的方法不存在...';
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }
}