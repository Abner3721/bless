<?php

/**
 * Explanation:祝福语数据处理类
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2021/1/19 11:31
 **/

namespace app\api\service;
use think\Db;
use think\Exception;
use think\Log;
use app\common\model\Like as LikeModel;

class Blessing
{

    public $model = null;
    public function __construct()
    {
        $this->model = new \app\common\model\Blessing();
    }


    public function getLists($page,$size){
        $start = ($page-1)*$size;
        $ranking = $start;
        $list = $this->model->getLists($start,$size);
        if(!$list){
            return [];
        }
        $rows = [];
        foreach($list as $k=>$v){
            $ranking++;
            $v['ranking'] = $ranking;
            $rows[] = $v; 
        }
        return $rows;
    }

    public function getMyLists($uid){
        $list = $this->model->getMyLists($uid);
        if(!$list){
            return [];
        }
        $rows = [];
        foreach ($list as $v) {
            if(empty($v['img']))
            {
                $v['img'] = [];
            }else{
                $v['img'] = json_decode($v['img']);
                foreach ($v['img'] as &$val ){
                    $val =  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$val;
                }
            }

            $rows[] =$v;
        }
        return $rows;

    }

    public function getIndexLists($page){
        $res = $this->model ->getIndexLists($page);
        if(!$res) {
            return [];
        }
        $list = $res->toArray();
        return $list;
    }
    public function count(){
        $res = $this->model->where('status',1)->count();
        return $res;
    }





    public function add($data){
        $res = $this->model->where('uid',$data['uid'])->count('*');
        if($res >= 3 ){
            throw new Exception('只能发布三条祝福语');
        }
        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('数据库异常');
        }
        return $this->model->id;
    }

    public function updateByIdLike($id,$uid){
        $data = [
            'bless_id'  => $id,
            'uid'       => $uid,
        ];
        $res = $this->model->where('status', 1)->find($id);
        if(!$res){
            throw new Exception('该条祝福不存在');
        }

        Db::startTrans();
        try {
            $result  = $this->model->updateByIdLike($id);
            $resLike = (new LikeModel())->save($data);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            Log::error($e->getMessage());
            return false;
        }
        return $result;

    }


    /**
     * Explanation:根据id获取祝福语的数据
     * Author: Abner
     * Email:372195546@qq.com
     * Date: 2021/1/19 17:08
     * @param $id
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function showBless($id){
        $info = $this->model->where('status',1)->find($id);
        if(!$info) {
            return [];
        }
        $info = $info->toArray();
        return $info;
    }

}