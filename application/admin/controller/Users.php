<?php
namespace app\admin\controller;
use app\common\model\AuthGroup;
use app\common\model\AuthGroupAccess;
use app\common\model\AuthRule;
use  app\common\model\Users as UsersModel;
use app\common\model\UserType;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/29
 * Time: 11:03
 */
class Users extends Base{
    public function index(){
       $data=UsersModel::paginate(config('adminpage'));
        return $this->fetch('',['data'=>$data]);
    }
    public function add(){
        $result=AuthGroup::all();
        if(Request::instance()->isPost()){
            $data=input('post.');
            $data['salt']=mt_rand(10000,99999);
            $data['hashed_password']=md5($data['password'].$data['salt']);
            $data['created_at']=time();
            $bool=UsersModel::create($data);
            $rdata['uid']=$bool['id'];
            $rdata['group_id']=$data['groupid'];
            $bol=AuthGroupAccess::create($rdata);
            if($bool&&$bol){
                return json(['code'=>200,'data'=>'','message'=>'添加成功']);
            }
            return json(['code'=>400,'data'=>'','message'=>'添加失败']);
        }
         return $this->fetch('',['result'=>$result]);


    }
    public function edit($id){
       $result= UsersModel::get($id);
        $res=AuthGroup::all();
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(trim($data['password'],' ')!=''||trim($data['repwd'],' ')!=''){
                if($data['password']!=$data['repwd']){
                    return json(['code'=>300,'data'=>'','message'=>'密码和确认密码不一致']);
                }
                unset($data['repwd']);
                $data['salt']=mt_rand(10000,99999);
                $data['hashed_password']=md5($data['password'].$data['salt']);
            }else{
                unset($data['repwd']);
                unset($data['password']);
            }
            $bool=UsersModel::update($data,['id'=>$id]);
            $bol=AuthGroupAccess::update(array('group_id'=>$data['groupid']),['uid'=>$id]);
            if($bool&& $bol){
                return json(['code'=>200,'data'=>'','message'=>'修改成功']);
            }
            return json(['code'=>400,'data'=>'','message'=>'修改失败']);
        }
        return $this->fetch('',['result'=>$res,'info'=> $result]);


    }
    public function del($id){
            $del=UsersModel::destroy($id);
            $this->redirect('Users/index');
    }
    /*用户组管理*/
    public function group(){
        $data=AuthGroup::all();
        return $this->fetch('',['data'=>$data]);
    }
    /*用户组管理*/
    public function group_add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=AuthGroup::create($data);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'添加失败']);
            }
            return json(['code'=>200,'data'=>'','message'=>'添加成功']);
        }
        return $this->fetch();

    }
    /*用户组管理*/
    public function group_edit($id){
        $info=AuthGroup::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=AuthGroup::update($data,array('id'=>$id));
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'修改失败']);
            }
            return json(['code'=>200,'data'=>'','message'=>'修改成功']);
        }
        return $this->fetch('',['info'=>$info]);

    }
    public function group_del($id){
          $del=AuthGroup::destroy($id);
        $this->redirect('Users/group_del');

    }

    /*修改状态*/
    public function group_status()
    {
        if (Request::instance()->isPost()) {
            $data = input('post.');
            if($data['status']==1){
                $status['status']=0;
            }else{
                $status['status']=1;
            }
            unset($data['status']);
            $bool = AuthGroup::update($status, $data);
            if (!$bool) {
                return json(['code' => 400, 'data' => '', 'message' => '修改失败']);
            }
            return json(['code' => 200, 'data' => '', 'message' => '修改成功']);
        }
    }
    /*三级分类*/
    public function getRules(){
        /*三级分类*/
        $data=AuthRule::all(['pid'=>0]);
        foreach($data as $k=> $v){
            $data[$k]['son_nav']=AuthRule::all(['pid'=>$v['id']]);
            foreach($data[$k]['son_nav'] as $key=>$val){
                $cc=AuthRule::all(['pid'=>$val['id']]);
                $val['son']=  $cc;
            }
        }
       // print_r($data);exit;
        return $data;
    }

    /*权限规则rule*/
    public function rule(){
        $data = $this->getRules();
        return $this->fetch('',['data'=>$data]);
    }
    /*用户组管理*/
    public function rule_add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=AuthRule::create($data);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'添加失败']);
            }
            return json(['code'=>200,'data'=>'','message'=>'添加成功']);
        }
       $select= AuthRule::all(['pid'=>0]);
        foreach($select as $k=>$v){
            $select[$k]['chaird']= AuthRule::all(['pid'=> $v['id']]);
        }
        return $this->fetch('',['nav'=>$select]);

    }
    /*修改状态*/
    public function rule_status()
    {
        if (Request::instance()->isPost()) {
            $data = input('post.');
            if($data['status']==1){
                $status['status']=0;
            }else{
                $status['status']=1;
            }
            unset($data['status']);
            $bool = AuthRule::update($status, $data);
            if (!$bool) {
                return json(['code' => 400, 'data' => '', 'message' => '修改失败']);
            }
            return json(['code' => 200, 'data' => '', 'message' => '修改成功']);
        }
    }
    /*用户组管理*/
    public function rule_edit($id){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=AuthRule::update($data,array('id'=>$id));
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'修改失败']);
            }
            return json(['code'=>200,'data'=>'','message'=>'修改成功']);
        }
        $info=AuthRule::get($id);
        $select= AuthRule::all(['pid'=>0]);
        foreach($select as $k=>$v){
            $select[$k]['chaird']= AuthRule::all(['pid'=> $v['id']]);
        }
        return $this->fetch('',['nav'=>$select,'info'=>$info]);
    }
    /*权限删除*/
    public function rule_del($id){
            $del= AuthRule::destroy($id);
            $this->redirect('Users/rule');

    }
    /*权限分配*/
    public function menu_rule($id){
        $data = $this->getRules();
        $gdata=UserType::get($id);
        if(Request::instance()->isPost()) {
            $data=input('post.');

            $bool = UserType::update($data,['id'=>$id]);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'添加失败']);
            }
            return json(['code'=>200,'data'=>'','message'=>'添加成功']);
        }
        return $this->fetch('',['list'=>$data,'gdata'=>$gdata]);
    }

}