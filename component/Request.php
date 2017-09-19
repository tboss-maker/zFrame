<?php

/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 18:13
 */
namespace component;
class Request
{
    public static function getParams($name='')
    {
        if (!isset($name)) {
            return $_GET;
        }
        return $_GET[$name];
    }

    public static function postParams($name)
    {
        return isset($_POST[$name]) ? $_POST[$name] : '';
    }
}