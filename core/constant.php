<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 12:41
 */
defined('MODE') or define('MODE', 'prod');
define('ROOT', realpath('./'));
define('APP', ROOT . DS . 'app');
define('CONFIG', APP . DS . 'config');
define('CONTROLLERS', APP . DS . 'controllers');
define('COMPNENT', ROOT . DS . 'component');
define('MODELS', APP . DS . 'models');
define('CORE', APP . DS . 'core');
//define('ACT', isset($_REQUEST['a']) ? ucfirst($_REQUEST['a']) : 'index');
//define('CON', isset($_REQUEST['c']) ? ucfirst($_REQUEST['c']) : 'Index');

//模块定义
define('MODULES','agent,truck');
define('REQUEST_ERROR','梦想能达到的地方，脚步一定能到达');

if (MODE == 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} elseif (MODE == 'prod') {
    error_reporting(0);
    ini_set('display_errors', 0);
}