<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 16:56
 */
namespace app\models;


use component\MyDataBase;

class Model
{
    protected $mysql;
    public function __construct()
    {
        $this->mysql = MyDatabase::getInstance();
    }
}