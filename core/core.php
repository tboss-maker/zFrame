<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 12:35
 */
define('DS',DIRECTORY_SEPARATOR);
require_once 'constant.php';
require_once 'autoLoad.php';
require_once 'router.php';

class Core{
    public static function run(){
        $auto = new autoload();
        $auto->myLoad();
        router::route();
    }
}