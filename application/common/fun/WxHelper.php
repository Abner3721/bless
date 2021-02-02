<?php


namespace app\common\fun;


use think\Cache;

class WxHelper
{
    private $appId;
    private $secret;

    public function __construct()
    {
        $this->appId = config('wx.app_id');
        $this->secret = config('wx.app_secret');
    }

    public function getAccessToken()
    {
        $cacheKey = 'access_token_' . $this->appId;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' .
            $this->appId . '&secret=' . $this->secret;
        $res = json_decode(file_get_contents($url));
         
        $access_token = $res->access_token;
        Cache::set($cacheKey, $access_token, 7200);
        return $access_token;
    }

    public function getClearAccessToken(){
        $cacheKey = 'access_token_'.$this->appId;
        return Cache::set($cacheKey,null);
    }


    public static function getQrCode($pageUrl,$param,$width=430)
    {
        $wxHelper = new WxHelper();
        $access_token = $wxHelper->getAccessToken();
        $query = http_build_query($param);
        $param = [
            'path'  => $pageUrl,
            'width' => $width,
        ];

        return HttpClient::http_post(
            'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=' . $access_token,
            json_encode($param)
        );
    }

    /**
     * Explanation：检测发表内容是否违规
     * Author: Abner
     * Time: 2021/1/31 11:37
     * @param $content
     * @return false|string
     */
     public function msgChcek($content){
         $wxHelper = new WxHelper();
         $access_token = $wxHelper->getAccessToken();
         $param = [
             'content' =>$content,
         ];
         return HttpClient::http_post(
             'https://api.weixin.qq.com/wxa/msg_sec_check?access_token=' . $access_token,
             json_encode($param,JSON_UNESCAPED_UNICODE)
         );

     }
    
}