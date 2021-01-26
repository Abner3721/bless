<?php

/**
 * Explanation: 祝福语操作控制器
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2021/1/19 11:29
 **/

namespace app\api\controller;
use app\api\service\Like;
use app\api\validate\Blessing as BlessingValidate;
use app\api\service\Blessing as BlessingService;
use app\api\service\Like as LikeService;


class Blessing extends BaseController
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
        if($count <=100 ) {
            $page = 5;
        }else if($count <= 200 && $count > 100){
            $page = 10;
        }else if($count <= 300 && $count > 200){
            $page = 10;
        }else if($count <= 400 && $count > 300){
            $page = 10;
        }else if($count <= 500 && $count > 400){
            $page = 10;
        }
        $getMyLists  = (new BlessingService()) -> getMyLists($this->uid);
        $myLists = [];
        if(isset($getMyLists[0])){
            $page = $page - 1;
            $myLists[0] = $getMyLists[0];
        }
        $lists = (new BlessingService()) ->getIndexLists($page);
        if(isset($myLists)){
            $data['lists'] = array_merge($myLists, $lists['data']);

        }
        $data['total'] = $count;
        if(!empty($data)){
            return success(200,'OK',$data);
        }else {
            return showError(201,'暂时没有数据');
        }
    }


    /**
     * Explanation:我的排名
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/26 15:17
     * @return \think\response\Json
     */
    public function getMyLists(){
        $userinfo = $this->userinfo;
        $myLists  = (new BlessingService()) -> getMyLists($this->uid);
        $data['userinfo'] = $userinfo->toArray();
        $data['lists'] = $myLists;
        return success(200,'OK', $data);
    }
    /**
     * Explanation:
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/25 19:20
     * @return \think\response\Json
     */
    public function getLists(){

        $page  = input('page', 1, 'intval');
        $page  = empty($page) ? 1 : $page;
        $size  = input('size', 10, 'intval');
        $list = (new BlessingService()) -> getLists($page,$size);
        if($list){
            return success(200,'OK',$list);
        }else{
            return showError(201,'没有数据！');
        }


    }

    /**
     * Explanation: 发布祝福语
     * Author: Abner
     * Email:372195546@qq.com
     * Date: 2021/1/19 14:36
     * @return \think\response\Json
     */
    public function add(){
        $params = input('param.','', 'trim');
        $data['content']    = $params['content'];
        $data['uid']        = $this->uid;
        $data['head']       = $this->userinfo->imgurl;
        $data['nickname']   = $this->userinfo->nickname;
        if(isset($params['img']))
            $data['img'] = json_encode($params['img']);
        $validate = new BlessingValidate();
        if(!$validate->scene('add')->check($data)){
            return showError(201,$validate->getError());
        }
        try {
            $res = (new BlessingService())->add($data);
        }catch (\Exception $e){
            return showError(400, $e->getMessage());
        }
        if(!$res) {
            return showError(201,'发布祝福语失败!');
        }else{
            return success(200, '发布成功',['id'=>$res]);
        }
    }

    /**
     * Explanation:点赞业务逻辑处理
     * Author: Abner
     * Email:372195546@qq.com
     * Date: 2021/1/19 15:02
     * @return \think\response\Json
     */
    public function like(){
        $id = input('param.id', 0,'intval');
        $data['id'] = $id;
        $uid = $this->uid;
        $validate = new BlessingValidate();
        if(!$validate->scene('like')->check($data)) {
            return showError(201,$validate->getError());
        }
        $likeNum = (new LikeService())->getLikeNum($uid);
        if(!$likeNum){
            return showError(201,'每天最多点赞5次');
        }
        $isLike = (new LikeService())->isLike($id,$uid);
        if($isLike){
            return showError(201, '该条祝福已经点过赞！');
        }

        try {
            $res = (new BlessingService())->updateByIdLike($id,$uid);
        } catch (\Exception $e){
            return showError(201, $e->getMessage());
        }

        if($res){
            return success(200,'点赞成功');
        }else{
            return showError(201,'点赞失败');
        }
    }




     

}