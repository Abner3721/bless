<?php

/**
 * Explanation:上传类
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2021/1/19 11:54
 **/

namespace app\api\controller;
class Image extends BaseController
{

    /**
     * Explanation: 上传图片
     * Author: Abner
     * Email:372195546@qq.com
     * Date: 2021/1/19 11:56
     * @return \think\response\Json
     */
    public function upload(){
        if(!$this->request->isPost()){
            return showError(201, '请求不合法');
        }
        $file = $this->request->file('file');

        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

        if($info){
            $filename = $info->getSaveName();
            $filename = str_replace('\\','/',$filename);
            $filename = '/uploads/'.$filename;
            return success(200, 'OK', ['filename'=> $filename ]);
        }
        return showError(201,$info->getError());
    }

}