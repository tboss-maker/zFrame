<?php

/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 18:13
 */
namespace component;
class Request
{
    public static function getParams($name)
    {
        return isset($_GET['name']) ? $_GET[$name] : '';
    }

    public static function postParams($name)
    {
        return isset($_POST[$name]) ? $_POST[$name] : '';
    }
}