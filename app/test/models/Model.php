<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 16:56
 */
namespace app\agent\models;


use component\MyDataBase;

class Model
{
    protected $mysql;
    protected $tableName;
    public function __construct()
    {
        $this->mysql = MyDatabase::getInstance();
    }


}