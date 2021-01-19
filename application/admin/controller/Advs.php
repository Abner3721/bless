<?php
namespace app\admin\controller;
use think\Controller;
use app\common\model\AdvPositions as Bannerlist;
use app\common\model\Advs as Banner;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/21
 * Time: 10:18
 */
/*
 * 广告位展示
 * */
class Advs extends Base {
    public function index(){
        $banner=Bannerlist::all(['status'=>1]);
        return $this->fetch('',['banner'=>$banner]);
    }
    /*广告广告位添加*/
    public function adv_add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=Bannerlist::create($data);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }else{
                return json(['code'=>200,'data'=>'','message'=>'提交成功']);
            }

        }
        return $this->fetch();
    }
    /*广告广告位修改*/
    public function advs_p($id){
        $info=Bannerlist::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool= Bannerlist::update($data,['id'=>$id]);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }
            return json(['code'=>200,'data'=>$id,'message'=>'提交成功']);
        }
        return $this->fetch('',['info'=>$info]);
    }
    /*广告广告位删除*/
    public function del($id){
        $del= Bannerlist::destroy($id);
        $this->redirect('Advs/index');
    }
    /*广告展示*/
    public function banner($id){
        $img = Banner::all(array('position_id'=>$id));
        return $this->fetch('',['img'=>$img,'id'=>$id]);
    }

    /*广告添加*/
    public function banner_add($id){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $data['position_id']=$id;
            $data['start_at']=strtotime($data['start_at']);
            $data['end_at']=strtotime($data['end_at']);
            if($data['media_type']=='image'){
                if(empty($data['imgurl'])){
                    $data['ad_code']=$data['ad_image_url'];
                }else{
                    $data['ad_code']=$data['imgurl'];
                }
            }else if($data['media_type']=='language'){
                $data['ad_code']=$data['ad_text'];
            }
            unset($data['imgurl'],$data['ad_image_url'],$data['ad_text']);
            ;
            $bool=Banner::create($data);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }else{
                return json(['code'=>200,'data'=>'','message'=>'提交成功']);
            }
        }
        $this->assign('adv_type',config('adv_type'));
        $this->assign('id',$id);
        /*时间参数*/
        $time=['start_time'=>'start_time','end_time'=>'end_time','start'=>'','end'=>'','nowtime'=>date('Y-m-d')];
        return $this->fetch('',$time);
    }
    /*广告修改*/
    public function banner_edit($id){
        $img = Banner::get($id);
        if(!empty($img['start_at'])){
            $img['start_at']=date('Y-m-d',$img['start_at']);
        }
        if(!empty($img['end_at'])) {
            $img['end_at'] = date('Y-m-d', $img['end_at']);
        }
        /*时间参数*/
        $time=['start_time'=>'start_time','end_time'=>'end_time','start'=>$img['start_at'],'end'=>$img['end_at'],'nowtime'=>date('Y-m-d')];

        if(Request::instance()->isPost()) {
            $data = input('post.');
            $data['start_at'] = strtotime($data['start_at']);
            $data['end_at'] = strtotime($data['end_at']);
            if ($data['media_type'] == 'image') {
                if (empty($data['imgurl'])) {
                    $data['ad_code'] = $data['ad_image_url'];
                } else {
                    $data['ad_code'] = $data['imgurl'];
                }
            } else if ($data['media_type'] == 'language') {
                $data['ad_code'] = $data['ad_text'];
            }
            unset($data['imgurl'], $data['ad_image_url'], $data['ad_text']);
            $bool = Banner::update($data, array('id' => $id));
            if (!$bool) {
                return json(['code' => 400, 'data' => '', 'message' => '修改失败']);
            } else {
                return json(['code' => 200, 'data' => '', 'message' => '修改成功']);
            }

        }


        $this->assign('adv_type',config('adv_type'));
        $this->assign('info',$img);
        return $this->fetch('',$time);
    }
    public function banner_del($id,$pid){
        $del= Banner::destroy($id);
        $this->redirect('Advs/banner',['id'=>$pid]);
    }

    /*
     * 广告添加*/
    public function add_bimg(){

        if(Request::instance()->isPost()){

        }
        return $this->fetch();
    }
    /*图片添加*/
    public function img(){
        return $this->upload_img();
    }
}