<?php
namespace app\api\controller;
use app\api\service\Wxdecode as ServiceWxdecode;
use think\Request;
use app\api\validate\TokenValidate;
 
class Wxdecode extends BaseController
{
	
	
	function getPhone(){
		 $data['wxcode'] 	 		= Request::instance()->param('wxcode');
		 $data['encryptedData'] = Request::instance()->param('encryptedData');
		 $data['iv'] 			= Request::instance()->param('iv');
		 $validata = new TokenValidate();
		 if(!$validata->scene('getPhone')->check($data)){
		     return showError(201,$validata->getError());
         }
		 $wx = new ServiceWxdecode($data);
		 $res = $wx->getwxdecode();
	}
	

	
}