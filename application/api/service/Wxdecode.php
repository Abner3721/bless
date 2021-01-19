<?php
namespace app\api\service;

use app\lib\exception\ErrorException;
use app\lib\wx\WXBizDataCrypt;


class Wxdecode 
{
	protected $code; 
    protected $encryptedData;
    protected $iv;  
    protected $wxLoginUrl;
    protected $wxAppID;
    protected $wxAppSecret;
    
    protected $data;
    
    function __construct($data){
    	$this->code 			= $data['wxcode'];
    	$this->encryptedData 	= $data['encryptedData'];
    	$this->iv 				= $data['iv'];
    	$this->wxAppID 			= config('wx.app_id');
    	$this->wxAppSecret 		= config('wx.app_secret');
    	$this->wxLoginUrl = sprintf(
    			config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    	
    }
    
    function getwxdecode(){ 
    	$result = curl_get($this->wxLoginUrl);
//    	$result = '{"session_key":"a8nIowFViZrMLSwz51+RWw==","openid":"oSQ3-4lpAr4VHZpM2WuU-g5rOpN8"}';
    	$wxResult = json_decode($result, true);

    	if (empty($wxResult)) {
    		// 为什么以empty判断是否错误，这是根据微信返回
    		// 这种情况通常是由于传入不合法的code
    		throw new ErrorException([
    				'code'=>500,
    				'msg' => '获取session_key及openID时异常，微信内部错误',
    				'status'=>999
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
    			$pc = new WXBizDataCrypt($this->wxAppID, $wxResult['session_key']);
    			$row= '';
    			$errCode = $pc->decryptData($this->encryptedData, $this->iv, $row); 
    			
    			if ($errCode == 0) {
    				exit($row);
    			} else { 
    				exit(json_encode($errCode));
    			}
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
    					'status' => $wxResult['errcode']
    			]);
    }
     
	
}