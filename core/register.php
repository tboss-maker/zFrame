<?php

/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 13:45
 */
class register
{
    private static $app;

    public static function _set($name, $obj)
    {
        self::$app[$name] = $obj;
    }

    public static function _get($name)
    {
        if (!self::$app[$name]) {
            return false;
        };
        return self::$app[$name];
    }

    public static function _unset($name)
    {
        if (!self::$app[$name]) {
            return false;
        };
        unset(self::$app[$name]);
        return true;
    }
}

$config = require_once CONFIG . DS . 'web.php';
//注册全局数据
register::_set('config', $config);