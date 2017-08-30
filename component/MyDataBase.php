<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 13:18
 */
namespace component;

use PDO;
use register;

class MyDataBase
{
    private static $instance;
    private $mysql;
    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        if(!$this->mysql){
            $config = register::_get('config')['mysql'];
            $options = array(
                PDO::ATTR_PERSISTENT => true,//设置长链接
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,//设置错误处理方式
                PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8',//设置字符集
                PDO::ATTR_CASE => PDO::CASE_LOWER//指定列小写
            );
            $this->mysql = new PDO("mysql:host:{$config['host']};port={$config['port']};dbname={$config['database']}","{$config['username']}","{$config['password']}",$options);
        }
    }

    public function query($sql){
        return $this->mysql->query($sql)->fetchAll(2);
    }

    private function __clone(){}
}