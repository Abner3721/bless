<?php
namespace app\api\validate;

class TokenValidate extends BaseValidate
{
	protected $rule = [
			'code' 		    => 'require|isNotEmpty',
			'nickname'      => 'require|isNotEmpty',
			'imgurl'        => 'require|isNotEmpty',
            'sex'           => 'require|isNotEmpty',
            'wxcode'        => 'require|isNotEmpty',
            'encryptedData' => 'require|isNotEmpty',
            'iv'            => 'require|isNotEmpty',
				
	];

	protected $message=[
			'code'              => '参数错误，没有code码，请带上code码再试一次！',
			'nickname'          => '有获得到昵称',
			'imgurl'            => '没有获得到头像',
            'sex'               => '没有获得到性别',
            'wxcode'            => 'wxcode不能为空',
            'encryptedData'     => '加密数据不能为空',
            'iv'                => 'vi不能为空',
	];

	protected  $scene = [
	    'token'     => ['code','nickname','imgurl','sex'],
        'getPhone'  => ['wxcode', 'encryptedData', 'vi']
    ];
}