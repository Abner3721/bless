<?php
namespace app\admin\controller;
use app\common\model\Shipping as ShippingModel;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/18
 * Time: 14:20
 */
class Shipping extends Base{
    public function index(){
       $result= ShippingModel::all();
    return $this->fetch('',['list'=>$result]);
    }
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=  ShippingModel::create( $data);
            if($bool){
                return json(['result'=>$bool,'code'=>200,'msg'=>'添加成功'],200);
            }else{
                return json(['result'=>$bool,'code'=>400,'msg'=>'添加失败'],200);
            }
        }
        return $this->fetch();
    }
    public function edit($id){
        $info=ShippingModel::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=  ShippingModel::update($data,['id'=>$id]);
            if($bool){
                return json(['result'=>$bool,'code'=>200,'msg'=>'修改成功'],200);
            }else{
                return json(['result'=>$bool,'code'=>400,'msg'=>'修改失败'],200);
            }
        }
        return $this->fetch('',['info'=>$info]);
    }
    public function del($id){
            $del=ShippingModel::destroy($id);
            $this->redirect('Shipping/index');
    }
}