<?php
/**
 * User: suji.zhao
 * Email: zhaosuji@foxmail.com
 * Date: 2017/9/19 15:30
 */
namespace component;

use register;

class weixin
{
    private $access_token;
    public function __construct()
    {
        $this->appid = register::_get('config')['appid'];
        $this->appsecret = register::_get('config')['secrete'];
        $this->getToken();
    }

    public function getToken(){
        $getTokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecret";
        $token_output = $this->https_request($getTokenUrl);
        $token_info = json_decode($token_output, true);
        if (!empty($token_info['errcode'])) {
            Log::write('e',json_encode($token_info));
            die("access_token获取失败...");
        }
        $this->access_token = $token_info['access_token'];
        return true;
    }

    public function createMenu($data){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$this->access_token";

    }

    private function https_request($url, $data = '')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        //忽略证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR ' . curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }
}