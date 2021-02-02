<?php

namespace app\api\controller;

use app\lib\exception\ErrorException;
use think\Controller;
use app\api\service\Token;
use app\common\model\Webuser;
use app\lib\exception\UserException;
use think\Db;

class BaseController extends Controller
{
    protected $uid = '';
    protected $userinfo = '';
    protected $request  = '';

    function _initialize()
    {
        $uid = Token::getCurrentUid();
        $userinfo = Webuser::field('id,nickname,username,imgurl')->find($uid);

        //判断用户是否登陆
        if(!$userinfo){
            throw new ErrorException(['code'=>401,'status'=>10000,'msg'=>'请先授权登录']);
        }
        $this->uid = $uid;
        $this->userinfo = $userinfo;
        $this->userinfo['nickname'] = json_decode($userinfo->username);
        $this->accessLog();


    }
    
    
    /**
     * 接口访问记录
     *  */
    public function accessLog(){ 
    	$params = request()->param();
    	$header = request()->header(); 
    	$server = request()->server(); 
    	$ip = request()->ip();
    	
    	$params = json_encode($params);
    	$header = json_encode($header); 
    	$api = $server['REQUEST_URI'];
    	$prevApi = isset($server['HTTP_REFERER'])? $server['HTTP_REFERER'] : '';
    	Db::table('tp_access_log')->insert([
    			'params' 		=>$params,
    			'api'			=>$api,
    			'prevApi'		=>$prevApi,
    			'ip'			=> $ip,
    			'create_time' 	=> time(),
    			'header'		=> $header,
    			'uid'			=> isset($this->uid) ? $this->uid : ''
    	]);
    	 
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8|9|6)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}

 