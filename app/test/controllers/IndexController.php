<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 13:34
 */
namespace app\agent\controllers;

use app\agent\models\UserModel;
use component\Request;

class IndexController extends Controller
{
//    //拦截器
//    public function before(){
//        echo 444555;
//    }

    public function indexAction(){
        $model = new UserModel();
        echo $model->test();
    }

}