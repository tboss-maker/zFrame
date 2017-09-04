<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/30 16:07
 */
//redis组件
class zRedis
{
    protected static $instance = null;
    protected $zRedis = null;

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
//            $config = register::_get('config')['redis'];
            $this->zRedis = new Redis();
//            $this->zRedis->pconnect($config['host'], $config['port']);
            $this->zRedis->pconnect('127.0.0.1', '3306');
        }
        return $this->zRedis;
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
        if (empty($name)) {
            return false;
        }
        return $this->zRedis->get($name);
    }

    public function flashAll()
    {
        $ret = $this->zRedis->flushAll();
        return $ret;
    }

    private function __clone()
    {
    }
}