<?php

/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 16:57
 */
namespace component;
class Log
{
    public static function write($type,$data){
        if(!in_array($type,['e','n','w','i'])){
            return false;
        }
        switch($type){
            case 'e':
                $type = 'error';
                break;
            case 'n':
                $type = 'notice';
                break;
            case 'w':
                $type = 'warning';
                break;
            default:
                $type = 'info';
        }
        if(!is_dir(LOG)){
            mkdir(LOG);
        }
        $fileName = LOG.DS."$type".date('Ymd',time()).".php";
        if(!file_exists($fileName)){
            touch($fileName);
        }
        $time = ' [ ' . date('Y-m-d H:i:s',time()). ' ] ';
        $res = $time.' [ '.ucfirst($type) . ' ] '.' [ '.$data.' ] '.' [ '.json_encode($_REQUEST).' ] ';
        file_put_contents($fileName,$res);
        return true;
    }
}