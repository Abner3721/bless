<?php

/**
 * Explanation:点赞数据处理层
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2021/1/19 14:47
 **/

namespace app\api\service;
use think\Exception;
use think\Log;

class Like
{
    public $model = '';
    public function  __construct(){
        $this->model = new \app\common\model\Like();
    }

    public function getLikeNum($uid){
        $res = $this->model->whereTime('create_time', 'today')->where('uid',$uid)->count();
        if($res >= 5 ){
            return false;
        }else{
            return  true;
        }
    }

    public function add($id,$uid) {
        $data = [
            'bless_id'  => $id,
            'uid'       => $uid,
        ];
        try{
            $this->model->save($data);
        } catch (\Exception $e ){
            Log::error($e->getMessage());
            throw new Exception('数据库异常');
        }
        return $this->model->id;
    }

    public function isLike($id,$uid){
        $where = [
            'bless_id'      => $id,
            'uid'           => $uid,

        ];
        $res = $this->model->where($where)->whereTime('create_time', 'today')->find();
        if($res){
            return true;
        }
        return false;
    }

}