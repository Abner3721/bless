<?php
namespace app\admin\controller;
use app\common\model\Wximage;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/17
 * Time: 10:14
 */
class Wxobject extends Base{
    public function index(){
        $resurl=Wximage::all();
        return $this->fetch('',['list'=>$resurl]);
    }
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(empty($data['imgurl'])){
                $data['imgurl']=$data['url'];
            }
            unset($data['url']);

            $bool=Wximage::create($data);
            if($bool){
                return json(['result'=>$bool,'code'=>200,'msg'=>'提交成功'],200);
            }else{
                return json(['result'=>$bool,'code'=>400,'msg'=>'提交失败'],200);
            }
        }
        return $this->fetch();
    }
    public function edit($id){
        $info=Wximage::get($id)->toArray();
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(empty($data['imgurl'])){
                $data['imgurl']=$data['url'];
            }
            unset($data['url']);

            $bool=Wximage::update($data,['id'=>$id]);
            if($bool){
                return json(['result'=>$bool,'code'=>200,'msg'=>'修改成功'],200);
            }else{
                return json(['result'=>$bool,'code'=>400,'msg'=>'修改失败'],200);
            }
        }
        return $this->fetch('',['info'=>$info]);
    }
    public function del($id){
            $del=Wximage::destroy($id);
            $this->redirect('Wxobject/index');
    }
}