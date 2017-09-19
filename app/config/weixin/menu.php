<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/9/19 15:45
 */
return [
    'button' => [
        [
        'name' => '我要收款',
        'type' => 'view',
        'url'=> 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4312b6653b58b512&redirect_uri=http://dev.wx.78dk.com/index.php/v4/weixincallbacks&response_type=code&scope=snsapi_base&state=1#wechat_redirect',
    ],
    [
        'name' => '联系客服',
        'type' => 'click',
        'key' => 'rm001'
    ],
    ]
];