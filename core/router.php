<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 13:13
 */
class router{
    public static function route(){
        $controller = "app\\controllers\\" . CON.'Controller';;
        $controller = new $controller;
        $act = ACT.'Action';
        $controller->$act();
    }
}