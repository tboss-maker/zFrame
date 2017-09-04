<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 13:58
 */
namespace app\agent\models;

class UserModel extends Model
{
    protected $tableName = 'user';
    public function test()
    {
        $sql = 'select * from USER';
        $data = $this->mysql->query($sql);
        var_dump($data);
    }
}