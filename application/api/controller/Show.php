<?php
/**
 * Explanation:祝福语详情，不用登录
 * Author: Abner
 * Email: 372195546@qq.com
 * Date: 2021/1/26 13:52
 */

namespace app\api\controller;


use think\Controller;
use app\api\validate\Blessing as BlessingValidate;
use app\api\service\Blessing as BlessingService;
use think\Request;


class Show extends Controller
{
    /**
     * Explanation:获取祝福语详情
     * Author: Abner
     * Email:372195546@qq.com
     * Date: 2021/1/19 17:09
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function showBless(){
        $id = input('param.id');
        $data['id'] = $id;
        $validate = new BlessingValidate();
        if(!$validate->scene('show')->check($data)){
            return showError(201,$validate->getError());
        }

        $info = (new BlessingService() )->showBless($id);
        if($info){
            $info['qrcode'] = Request::instance()->domain().'/api/qrcode/getqrcode/id/'.$id;
            return success(200, 'OK', $info);
        }
        return showError(201,'该条记录不存在！', $info);
    }
}