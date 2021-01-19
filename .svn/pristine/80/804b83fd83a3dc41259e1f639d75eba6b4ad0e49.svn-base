<?php
namespace app\api\service;


use app\lib\exception\ErrorException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;
class Token
{
	// 生成令牌
	public static function generateToken()
	{
		$randChar = getRandChar(32);
		$timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
		$tokenSalt = config('setting.token_salt');
		return md5($randChar . $timestamp . $tokenSalt);
	}
	
	
	/**
	 * 当需要获取全局UID时，应当调用此方法
	 *而不应当自己解析UID
	 *
	 */
	
	public static function getCurrentUid()
	{
		$uid = self::getCurrentTokenVar('uid'); 
		return $uid;
	}
	
	public static function getCurrentTokenVar($key)
	{
		$token = Request::instance()
		->header('token');

		$vars = Cache::get($token); 
		if (!$vars)
		{
			throw new ErrorException(['code'=>201,'msg'=>'Token已过期或无效Token']);
		}
		else {
			if(!is_array($vars))
			{
				$vars = json_decode($vars, true);
			}
			if (array_key_exists($key, $vars)) {
				return $vars[$key];
			}
			else{
				throw new Exception('尝试获取的Token变量并不存在');
			}
		}
	}
	
	
	
	
	
}