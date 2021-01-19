<?php
namespace app\admin\controller;
use app\common\model\SysNavs;
use think\Controller;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 16:48
 */
/*菜单展示*/
class Navs extends Base {
    public function index(){
        $par_nav=SysNavs::all(['parent_id'=>0]);
        foreach($par_nav as $k=> $v){
            $par_nav[$k]['son_nav']=SysNavs::all(['parent_id'=>$v['id']]);
            foreach($par_nav[$k]['son_nav'] as $key =>$val){
                $data=SysNavs::all(['parent_id'=>$val['id']]);
                $val['son']=$data;
            }

        }
        return $this->fetch('',['par_nav'=>$par_nav]);
    }
    /*菜单添加*/
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            if($data['imgurl']==''){
                $data['imgurl']=$data['iurl'];
            }
            unset($data['iurl']);
            $bool=SysNavs::create($data);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }else{
                return json(['code'=>200,'data'=>'','message'=>'提交成功']);
            }

        }
        $par_nav=SysNavs::all(['parent_id'=>0]);
        foreach($par_nav as $k=>$v){
            $par_nav[$k]['son']=SysNavs::all(['status'=>1,'parent_id'=>$v['id']]);

        }
        return $this->fetch('',['par_nav'=>$par_nav]);
    }
    /*菜单修改*/
    public function edit($id){
        $info=SysNavs::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            if($data['imgurl']==''){
                $data['imgurl']=$data['iurl'];
            }
            unset($data['iurl']);
            $bool= SysNavs::update($data,['id'=>$id]);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }
            return json(['code'=>200,'data'=>'','message'=>'提交成功']);
        }
        $par_nav=SysNavs::all(['parent_id'=>0]);
        foreach($par_nav as $k=>$v){
            $par_nav[$k]['son']=SysNavs::all(['status'=>1,'parent_id'=>$v['id']]);

        }
        return $this->fetch('',['info'=>$info,'par_nav'=>$par_nav]);
    }
    /*菜单删除*/
    public function del($id){
        $del= SysNavs::destroy($id);
        $this->redirect('Navs/index');


    }
}