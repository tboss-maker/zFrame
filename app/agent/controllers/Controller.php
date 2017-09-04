<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 14:09
 */
namespace app\agent\controllers;

class Controller{
    public function __construct()
    {
        //添加拦截器
        if(method_exists($this,'before')){
            static::before();
        }
    }

    public function __call($name, $arguments)
    {
        die(REQUEST_ERROR);
    }

    public static function __callStatic($name, $arguments)
    {
        die(REQUEST_ERROR);
    }

    public function __destruct()
    {
        if(method_exists($this,'after')){
            static::after();
        }
    }
}