<?php

/**
 * Explanation:二维码生成控制器
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2020/12/19 19:17
 **/

namespace app\api\controller;
use app\api\validate\Blessing as BlessingValidate;
use app\api\service\Blessing as BlessingService;
use app\common\fun\WxHelper;
use think\Cache;

class Qrcode
{
    public function getQrcode(){
        header("content-type: image/jpeg");
        $id = input('param.id', 0, 'intval');
        $validate = new BlessingValidate();
        if(!$validate->scene('show')->check(['id'=>$id])){
            return showError(201,$validate->getError());
        }
        $info = (new BlessingService())->showBless($id);
        if(empty($info)){
            return showError(201,'该条祝福不存在！！');
        }
        $showBlessId = 'showBlessId_'.$id;
        if(!Cache::has($showBlessId)) {
            $qrcode = WxHelper::getQrCode('pages/blessingDetail/index?id='.$id, ['id' => $id]);
            Cache::set($showBlessId,$qrcode);
        }else{
            $qrcode = Cache::get($showBlessId);
        }
        $qrcodeInfo = json_decode($qrcode);
        if(isset($qrcodeInfo->errcode)){
            if($qrcodeInfo->errcode == 40001 ) {
                $wxHelper = new WxHelper();
                $wxHelper->getClearAccessToken();
                Cache::set($showBlessId,null);
            }
            $qrcode = WxHelper::getQrCode('pages/blessingDetail/index?id='.$id, ['id' => $id]);
            halt('actton_token');
        }
        $img = imagecreatefromstring($qrcode);
        imagejpeg($img);
        $content = ob_get_clean();
        return \response($content, 200, ['Content-Length' => strlen($content)])
            ->contentType('image/jpeg');

    }


}