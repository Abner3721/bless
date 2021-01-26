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
        Cache::set($cacheKey, $access_token, 3000);
        return $access_token;
    }


    public static function getQrCode($pageUrl, $param,$width=430)
    {
        $wxHelper = new WxHelper();
        $access_token = $wxHelper->getAccessToken();

        $scene = http_build_query($param);
        $param = [
            'page' => $pageUrl,
            'width' => $width,
            'scene' => $scene,
        ];
        
        return HttpClient::http_post(
            'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $access_token,
            json_encode($param)
        );
    }
    
}