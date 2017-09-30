<?php

/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/31 9:37
 */
//url编辑
class urlManage
{
    //模块
    public static function make(){
        $baseUrl = isset($_REQUEST['_url']) ? $_REQUEST['_url'] : '';
        $config = register::_get('config');
        if(empty($baseUrl)){
            $baseUrl = $config['defaultRoute'];
        }
            $urlStr = explode('?',$baseUrl);
            $urlArr = explode('/',trim($urlStr[0],'/'));
            $modules = $config['modules'];
            $allowModules = explode(',',$modules);
            $moduleName = $urlArr[0];
            $paramsNum = count($urlArr);
            if(!in_array($moduleName,$allowModules) || $paramsNum>3){
                die(REQUEST_ERROR);
            }
            switch($paramsNum){
                case 1:
                    $controllerName = "IndexController";
                    $actionName = "indexAction";
                    break;
                case 2:
                    $controllerName = ucfirst($urlArr[1])."Controller";
                    $actionName = 'indexAction';
                    break;
                default:
                    $controllerName = ucfirst($urlArr[1]).'Controller';
                    $actionName = lcfirst($urlArr[2]).'Action';
                    break;
            }

        $fileName = APP.DS.$moduleName.DS.'controllers'.DS.$controllerName.'.php';
        if(!file_exists($fileName)){
            die(REQUEST_ERROR);
        }
        $controllerName = 'app'.'\\'.$moduleName.'\\'.'controllers'.'\\'.$controllerName;
        define('CON',$controllerName);
        define('ACT',$actionName);
        }

}