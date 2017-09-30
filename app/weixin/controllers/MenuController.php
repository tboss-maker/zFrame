<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/9/19 13:59
 * 微信菜单类
 */
namespace app\weixin\controllers;

use component\BaseController;
use component\Common;
use component\Request;
use component\weixin;

class MenuController extends BaseController
{
    
    //创建菜单
    public function createAction(){
        echo 333;exit;
        return Common::_outError('10000');
        $weixin = new Weixin();
        $data = Request::postParams('data','');
        $weixin->createMenu($data);
    }
}
