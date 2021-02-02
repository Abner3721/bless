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
use think\Request;

class Blessing
{

    public $model = null;
    public function __construct()
    {
        $this->model = new \app\common\model\Blessing();
    }

    /**
     * Explanation:全部排名业务操作
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/29 19:14
     * @param $page;当前页数
     * @param $size; 显示条数
     * @param $where;条件
     * @param $order;排序规则
     * @return mixed
     */
    public function getLists($page,$size,$where,$order){
        $start = ($page-1)*$size;
        $ranking = $start;
        $list = $this->model->getLists($size,$where,$order);
        if($list->isEmpty()){
            $rows['total'] = 0;
            $rows['render'] = '';
            $rows['data'] = [];
            return $rows;

        }
        $rows['total']= $list->total();
        $rows['render'] = $list->render();
        foreach($list as $k=>$v){
            $ranking++;
            $v['ranking'] = $ranking;
            $v['nickname'] = json_decode($v['nickname']);
            $v['content'] = json_decode($v['content']);
            $rows['data'][] = $v;
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
                    $val =  Request::instance()->domain().$val;
                }
            }

            $v['nickname'] = json_decode($v['nickname']);
            $v['content'] = json_decode($v['content']);

            $rows[] =$v;
        }
        return $rows;

    }

    public function getIndexLists($page,$noId){
        $res = $this->model ->getIndexLists($page,$noId);
        if(!$res) {
            return [];
        }
        $list = $res->toArray();
        $rows = [];
        foreach($list['data'] as $k=>$v){

            $v['nickname'] = json_decode($v['nickname']);
            $v['content'] = json_decode($v['content']);
            $rows[] = $v;
        }
        return $rows;
    }
    public function count(){
        $res = $this->model->where('status',1)->count();
        return $res;
    }





    public function add($data){
        $where = [
            'uid'       => $data['uid'],
            'status'    => 1
        ];

        $res = $this->model->where($where)->count('*');
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

    /**
     * Explanation:前台点赞业务操作
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/26 20:03
     * @param $id
     * @param $uid
     * @return bool|int|true
     * @throws Exception
     * @throws \think\exception\PDOException
     */
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
        $info['nickname'] = json_decode($info['nickname']);
        $info['content']  = json_decode($info['content']);

        return $info;
    }

    /**
     * Explanation:后台更新点赞数据业务处理
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/26 20:40
     * @param $id
     * @param $like
     * @return bool
     * @throws Exception
     */
    public function updateByIdLikeAdmin($id,$like){
        $res = $this->model->find($id);
        if(!$res){
            throw new Exception('该条祝福已经不存在！');
        }
        try {
            $result = $this->model->updateByIdLikeAdmin($id,$like);
        } catch (\Exception $e){
            return false;
            Log::error($e->getMessage());
        }

        if($result){
            return true;
        }

        return false;
    }
    function updateByIdStatus($where,$data){
        $res = $this->model->where($where)->find();
        if(!$res){
            throw new Exception('该条祝福不存在');
        }
        return $this->model->update($data,$where);
    }

}