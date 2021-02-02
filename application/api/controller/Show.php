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
     * Explanation:首页祝福树里的数据
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/26 15:12
     * @return \think\response\Json
     */
    public function index(){
        $count = (new BlessingService())->count();
        $page = 5;
        $one    = config('blessing.one');
        $two    = config('blessing.two');
        $three  = config('blessing.three');
        $four   = config('blessing.four');
        $treeStatus = 0;
        if($count <= $one && $count > 1 ) {
            $treeStatus = 1;
            $page = 5;
        }else if($count <= $two && $count > $one ){
            $treeStatus = 2;
            $page = 10;
        }else if($count <= $three && $count > $two ){
            $treeStatus = 3;
            $page = 15;
        }else if($count <= $four && $count > $three ){
            $treeStatus = 4;
            $page = 20;
        } else if($count > $four ) {
            $treeStatus = 4;
            $page = 20;
        }
        $noId = 0;
        $lists = (new BlessingService())->getIndexLists($page,$noId);
        $data['lists'] = $lists;
        $data['total'] = $count;
        $data['treeStatus'] = $treeStatus;
        if(!empty($data)){
            return success(200,'OK',$data);
        }else {
            return showError(201,'暂时没有数据');
        }
    }

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

    /**
     * Explanation:最新五条信息
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/29 19:13
     */
    public function newFive(){
        $size = 5;
        $page = 1;
        $where['status'] =1;
        $order['id'] = 'desc';
        $lists = (new BlessingService() )-> getLists($page,$size,$where,$order);
        if($lists){
            return success(200,'OK',$lists);
        }else{
            return showError(201,'暂无数据');
        }
    }
}