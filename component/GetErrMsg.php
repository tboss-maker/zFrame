<?php
/**
 * 错误信息定义和获取类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/5
 * Time: 15:49
 */
namespace component;
class GetErrMsg
{
    protected static $_msgArr;

    /**
     * 获得提示信息
     * @param $errno
     * @param int $isShowMsg
     * @return string
     */
    public static function getErrMsg($errno, $errMsg='')
    {
        self::$_msgArr = require_once CONFIG.DS."error_msg.php";
        if( $errMsg === ''){
            //开启调试模试后显示真实的错误信息,未开启调试模试显示优化后（对用户友好的）的错误信息
            $errMsg = (MODE === 'dev') ? self::$_msgArr[$errno][0] : self::$_msgArr[$errno][1];
        }

        $msg = ['status'=>0,'errno'=>$errno,'errmsg'=>$errMsg];
        return $msg;
    }
}

