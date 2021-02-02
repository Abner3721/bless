<?php
namespace  app\api\controller;

use think\Request;
use app\api\service\UserToken;
use app\api\validate\TokenValidate;
/* 
 * 获取令牌 
 */
class Token 
{
	
	public function getToken(Request $request){
		$params = $request->param();


		if(!$request->isPost()){
		    return showError(201,'请用get请求');
		}
		$data = [
		    'nickname'  => $request->param('nickname', '','trim'),
            'imgurl'    => $request->param('imgurl', '','trim'),
            'sex'       => $request->param('sex', 0, 'int'),
            'code'      => $request->param('code', '','trim'),
        ];
		$validate = new TokenValidate();
		if(!$validate->scene('token')->check($data)) {
            return showError(201,$validate->getError());
        }

        $wx = new UserToken($data);
		$token = $wx->get();

		return success(200,'ok', ['token'=>$token]);
		
	}
	


	
}