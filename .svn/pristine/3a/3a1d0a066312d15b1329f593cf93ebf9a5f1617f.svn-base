<?php
namespace app\admin\controller;
use think\Request;
use app\common\model\SysModules as SysModulesModel;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 16:48
 */
/*菜单展示*/
class Sysmodules extends Base {
    public function index(){
        $par_nav=SysModulesModel::all(['parent_id'=>0]);
        foreach($par_nav as $k=> $v){
            $par_nav[$k]['son_nav']=SysModulesModel::all(['parent_id'=>$v['id']]);
        }
        return $this->fetch('',['par_nav'=>$par_nav]);
    }
    /*菜单添加*/
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=SysModulesModel::create($data);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }else{
                return json(['code'=>200,'data'=>'','message'=>'提交成功']);
            }

        }
        $par_nav=SysModulesModel::all(['status'=>1,'parent_id'=>0]);
        return $this->fetch('',['par_nav'=>$par_nav]);
    }
    /*菜单修改*/
    public function edit($id){
        $info=SysModulesModel::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool= SysModulesModel::update($data,['id'=>$id]);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }
            return json(['code'=>200,'data'=>'','message'=>'提交成功']);
        }
        $par_nav=SysModulesModel::all(['status'=>1,'parent_id'=>0]);
        return $this->fetch('',['info'=>$info,'par_nav'=>$par_nav]);
    }
    /*菜单删除*/
    public function del($id){
            $del= SysModulesModel::destroy($id);
            $this->redirect('Sysmodules/index');
    }
}