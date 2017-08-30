<?php

/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 12:55
 */
class autoLoad
{
    public function myLoad()
    {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    public function load($class)
    {
        if (substr($class, -10) == 'Controller') {
            //加载控制器
            require_once $class . ".php";
        } elseif (substr($class, -5) == 'Model') {
            //加载模型
            require_once $class . ".php";
        } else {
            //加载组件
            require_once $class . ".php";
        }
    }
}