<?php
namespace app\admin\controller;
use app\common\model\Orders as OrdersModel;
use app\common\model\Products as ProductsModel;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/17
 * Time: 16:33
 */
class Orders extends Base{
    public function index(){
        $result = OrdersModel::all(['order_del'=>0]);
        return $this->fetch('',['list'=>$result]);
    }
    public function edit($id){
        $result = OrdersModel::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=OrdersModel::update($data,['id'=>$id]);
            if($bool){
                return json(['result'=>$bool,'code'=>200,'msg'=>'修改成功'],200);
            }else{
                return json(['result'=>$bool,'code'=>400,'msg'=>'修改失败'],200);
            }
        }
        return $this->fetch('',['info'=>$result]);
    }
    /*修改信息*/
    public function logistics($id){
        if(Request::instance()->isPost()){
            $data=input('post.');
            if($data['status'] == 1){
                $data['status'] =2;
            }else if($data['status'] == 2){
                $data['status'] =3;
            }
            $bool=OrdersModel::update($data,['id'=>$id]);
            if($bool){
                return json(['result'=>$bool,'code'=>200,'msg'=>'修改成功'],200);
            }else{
                return json(['result'=>$bool,'code'=>400,'msg'=>'修改失败'],200);
            }
        }
        exit;
    }
    public function del($id){
        OrdersModel::destroy($id);
        $this->redirect('Orders/index');
    }


}