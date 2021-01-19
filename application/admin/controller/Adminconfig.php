<?php
namespace app\admin\controller;
use app\common\model\AdminConfig as AdminConfigModel;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 16:39
 */
class Adminconfig extends Base{
    public function index(){
        $res=AdminConfigModel::get(array('code'=>'adminconfig'));
        if(Request::instance()->isPost()){
            $data=input('post.');
            if($res){
                $bool= AdminConfigModel::update($data,array('code'=>'adminconfig'));
            }else{
                $data['code']='adminconfig';
                $bool= AdminConfigModel::create($data);
            }
            if($bool){
                return json(['code'=>200,'data'=>'','message'=>'提交成功']);
            }else{
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }
        }
        return $this->fetch('',array('res'=>$res));
    }
}