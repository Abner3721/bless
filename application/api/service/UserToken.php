<?php

namespace app\api\service;


use app\lib\exception\ErrorException;

use app\common\model\Webuser;

/**
 * 微信登录
 * 如果担心频繁被恶意调用，请限制ip
 * 以及访问频率
 */
class UserToken extends Token
{
    protected $code;
    protected $wxLoginUrl;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $data;

    function __construct($data)
    {
        $this->code = $data['code'];
        $this->data = $data;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(
            config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    
    /**
     * 登陆
     * 思路1：每次调用登录接口都去微信刷新一次session_key，生成新的Token，不删除久的Token
     * 思路2：检查Token有没有过期，没有过期则直接返回当前Token
     * 思路3：重新去微信刷新session_key并删除当前Token，返回新的Token
     */
    public function get()
    { 
//       $result = curl_get($this->wxLoginUrl);
//       halt($result);
       $result = '{"session_key":"jqcbdVq5xDwoPUfW8qLP4Q==","openid":"oSQ3-4lpAr4VHZpM2WuU-g5rOpN8"}';
 
 
        // 注意json_decode的第一个参数true
        // 这将使字符串被转化为数组而非对象
        $wxResult = json_decode($result, true);  
        
        if (empty($wxResult)) {
            // 为什么以empty判断是否错误，这是根据微信返回 
            // 这种情况通常是由于传入不合法的code
            throw new ErrorException([
            		'code'=>500,
            		'msg' => '获取session_key及openID时异常，微信内部错误',
            		'errorCode'=>999
            ]);
        }
        else {
            // 建议用明确的变量来表示是否成功
            // 微信服务器并不会将错误标记为400，无论成功还是失败都标记成200
            // 这样非常不好判断，只能使用errcode是否存在来判断
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            }
            else {
                return $this->grantToken($wxResult);
            }
        }
    }



    // 处理微信登陆异常
    // 那些异常应该返回客户端，那些异常不应该返回客户端
    // 需要认真思考
    private function processLoginError($wxResult)
    {
        throw new ErrorException(
            [
                'msg' => $wxResult['errmsg'],
                'errorCode' => $wxResult['errcode']
            ]);
    }

    //  入库
    private function saveToCache($wxResult)
    { 
        $key = self::generateToken();
        $value = json_encode($wxResult);
        $expire_in = config('setting.token_expire_in');
        
        $result = cache($key, $value, $expire_in);
		
 		
        if (!$result){
            throw new ErrorException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    // 颁发令牌
    private function grantToken($wxResult)
    { 
        
        $openid = $wxResult['openid'];
        $user = Webuser::getByOpenID($openid);
        // 借助微信的openid作为用户标识
        // 但在系统中的相关查询还是使用自己的uid
        if (!$user)  
        {
            $uid = $this->newUser($openid);
        }
        else {
            $uid = $user['id'];

        } 
        
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    protected  function editNickname($user){ 
    	if($user->nickname == ''){ 
    		$data = json_encode($this->data); 
    		 
    		Webuser::where('id',$user->id)->update(['data_json'=>$data]);
    	}
    }
    

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid; 
        return $cachedValue;
    }

    // 创建新用户
    private function newUser($openid)
    {

        $user = Webuser::create(
            [
                'openid' 	=> $openid, 
            	'nickname'	=> $this->data['nickname'],
            	'imgurl' 	=> $this->data['imgurl'],
            	'sex'		=> $this->data['sex'],
            ]);
        
        return $user->id;
    }



}
