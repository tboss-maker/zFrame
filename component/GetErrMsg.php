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
    protected $_msgArr = [
        10000 => ['操作成功','操作成功']
    ];

    public function __construct(){}


    /**
     * 获得提示信息
     * @param $errno
     * @param int $isShowMsg
     * @return string
     */
    public function getErrMsg($errno, $errMsg='')
    {
        if( $errMsg === ''){
            //开启调试模试后显示真实的错误信息,未开启调试模试显示优化后（对用户友好的）的错误信息
            $errMsg = (MODE === 'dev') ? $this->_msgArr[$errno][0] : $this->_msgArr[$errno][1];
        }

        $msg = ['status'=>0,'errno'=>$errno,'errmsg'=>$errMsg];
        return $msg;
    }
}

