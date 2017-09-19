<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/9/19 14:54
 */
namespace component;

class BaseController
{
    public function __construct()
    {
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
        
    }
}