<?php

namespace app\api\controller;
use app\api\validate\WebuserValidate;
use app\api\service\Webuser as WebuserService;


class Webuser extends BaseController
{
    /**
     * Explanation:绑定手机号
     * Author: Abner
     * Date: 2021/1/18 19:36
     * @return \think\response\Json
     */
    function bindPhone(){ 
        $phone = input('param.phone','', 'trim');
        $data['phone'] = $phone;
        $validate = new WebuserValidate();
        if(!$validate->scene('bindPhone')->check($data)) {
            return showError(201, $validate->getError());
        }
        try {
            $res = (new WebuserService())->updateByPhone($this->uid, $data);
        }catch (\Exception $e) {
            return showError(400,$e->getMessage());
        }
        if($res){
            return success(200, '绑定成功');
        }else{
            return showError(201,'绑定失败');
        }

    }


}

?>