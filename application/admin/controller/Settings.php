<?php
namespace app\admin\controller;
use app\common\model\Configs;
use think\Controller;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 16:39
 */
class Settings extends Base {
    public function index(){
        $info=array();
         $result=Configs::all();
         if(Request::instance()->isPost()){
            $data=input('post.');
           foreach($data['config'] as $k => $v){
              $bool=Configs::update(['conf_value'=>$v],['id'=>$k]);
              if(!$bool){
                  $this->error('修改失败!');
              }
           }
               $this->success('修改成功!');
         }
         foreach($result as $val){
             $info[$val['id']]=$val;
         }
        return $this->fetch('',['info'=>$info]);
    }
}