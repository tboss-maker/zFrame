<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 16:07
 */
//redis组件
class zRedis
{
    private static $instance;
    private $zRedis;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        if (!$this->zRedis) {
            $config = register::_get('config')['redis'];
            $this->zRedis = new Redis();
            $this->zRedis->pconnect($config['host'], $config['port']);
        }
    }

    public function set($name, $value)
    {
        if (empty($name) || empty($value)) {
            return false;
        }
        return $this->zRedis->set($name, $value);
    }

    public function get($name)
    {
        if(empty($name)){
            return false;
        }
        return $this->zRedis->get($name);
    }
}