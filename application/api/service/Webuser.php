<?php
/**
 * Explanation:用户操作的service层
 * Author: Abner
 * Date: 2021/1/18 18:06
 */

namespace app\api\service;
use app\common\model\Webuser as WebuserModel;
use think\Exception;
use think\Log;

class Webuser
{
    public $model = null;
    public function __construct(){
        $this->model = new WebuserModel();
    }

    public function updateByPhone($id,$data){
        $result = $this->model->where(['phone'=>$data['phone'],'status'=>1])->find();

        if($result){
            throw new Exception('手机号已经被绑定了');
        }
        try {
            $res = $this->model->updateByPhone($id, $data);

        } catch (\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        return $res;

    }


}