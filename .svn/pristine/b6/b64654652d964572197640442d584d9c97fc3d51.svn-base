<?php
namespace app\admin\controller;
use app\common\model\Forum as ForumModel;
use think\Request;
use app\common\model\Judge as JudgeModel;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/19
 * Time: 17:51
 */
class Forum extends Base{
    public function index(){
        $result= ForumModel::all();
        return $this->fetch('',['list'=>$result]);
    }
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(empty($data['imgurl'])) {
                $data['imgurl'] = $data['url'];
            }
            unset($data['url']);
            $data['uid']=session('uid');
            $data['content']=json_encode($data['content']);
            $bool = ForumModel::create($data);
            if($bool){
                return json(['code'=>200,'data'=>'','msg'=>'添加成功']);
            }else{
                return json(['code'=>400,'data'=>'','msg'=>'添加失败']);
            }}
        return $this->fetch();
    }
    public function edit($id){
        $info=ForumModel::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(empty($data['imgurl'])) {
                $data['imgurl'] = $data['url'];
            }
            unset($data['url']);
            $data['uid']=session('uid');
            $data['content']=json_encode($data['content']);
            $bool = ForumModel::update($data,['id'=>$id]);
            if($bool){
                return json(['code'=>200,'data'=>'','msg'=>'修改成功']);
            }else{
                return json(['code'=>400,'data'=>'','msg'=>'修改失败']);
            }
        }
        $info['content']=json_decode($info['content'],true);
        return $this->fetch('',['info'=>$info]);
    }

    public function del($id){
        $bool=ForumModel::destroy($id);
        $this->redirect('Forum/index');
    }
    public function judge(){
        $result= JudgeModel::all();
        return $this->fetch('',['list'=>$result]);
    }
    public function judge_del($id){
        $bool=JudgeModel::destroy($id);
        $this->redirect('Forum/judge');
    }
}