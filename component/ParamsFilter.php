<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/9/18 11:38
 */
namespace component;

class ParamsFilter
{
    private $params;
    private static $obj;
    public static function filter(){
//        if(!self::$obj){
//            self::$obj = new self();
//        }
        print_r(get_called_class());
    }

    public function __construct()
    {
        $this->params = require_once CONFIG.DS.'params.php';
    }

    //必填项检查
    public function _isNeed()
    {
        $params = $this->params;
        foreach($params as $key => $value){
            $className = get_class($this);
        }
    }

    public function _noEmpty()
    {

    }

    //范围检查
    public function _range()
    {

    }
}



