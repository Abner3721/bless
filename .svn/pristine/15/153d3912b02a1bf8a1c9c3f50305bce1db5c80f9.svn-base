<?php
namespace app\admin\controller;
use app\common\model\Evaluate as EvaluateModel;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/18
 * Time: 14:20
 */
class Evaluate extends Base{
    public function index(){
       $result= EvaluateModel::all();
    return $this->fetch('',['list'=>$result]);
    }
    public function edit($id){
        $info=EvaluateModel::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=  EvaluateModel::update($data,['id'=>$id]);
            if($bool){
                return json(['result'=>$bool,'code'=>200,'msg'=>'修改成功'],200);
            }else{
                return json(['result'=>$bool,'code'=>400,'msg'=>'修改失败'],200);
            }
        }
        return $this->fetch('',['info'=>$info]);
    }
    public function del($id){
            $del=EvaluateModel::destroy($id);
            $this->redirect('Evaluate/index');
    }
}