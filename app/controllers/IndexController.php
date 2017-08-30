<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/8/29 13:34
 */
namespace app\controllers;

use app\models\UserModel;
use component\Request;

class IndexController extends Controller
{
//    //拦截器
//    public function before(){
//        echo 444555;
//    }

    public function indexAction(){
        $name = Request::getParams('name');
        echo $name;exit;
        $model = new UserModel();
        echo $model->test();
    }

}