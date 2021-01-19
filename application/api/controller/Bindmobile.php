<?php
namespace  app\api\controller;
use app\common\model\Webuser;
use think\Request;


class Bindmobile extends BaseController
{
	
 
	
	//从微信获取手机号然后做绑定操作
	function bindmobile(Request $request){

		$uid = $this->uid;
		$params = $request->param();

		


		
		
		$res = Webuser::where('phone', $data['phone'])->find();
		if(!empty($res->phone)){
			$msg_error['error_code'] =201;
			$msg_error['msg'] ='手机号存在，请换个手机号';
			return json($msg_error);
		}
		
		
		$reslut = $this->newMobile($data, $uid);
		if(!$request ){ 
			$msg_error['error_code'] =201;
			$msg_error['msg'] ='手机号绑定失败';
			return json($msg_error);
		}
		
		return json($msg_error);
		
		
		
		
	}
	
	
	
	// 绑定手机号
	private function newMobile($data,$uid)
	{ 
		$user = Webuser::update(
				[
						'id' 	=> $uid,
						'phone'	=> $data['phone']
				]); 
		return $user->id;
	}
	





}