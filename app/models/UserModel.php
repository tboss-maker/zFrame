<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 13:58
 */
namespace app\models;

class UserModel extends Model
{
    public function test()
    {
        $data = $this->mysql->query('select * from USER ');
        var_dump($data);
    }
}