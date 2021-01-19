<?php
namespace app\admin\controller;

use app\common\model\Loginlog;
use app\common\model\Users as UsersModel;
use app\common\model\AdminConfig;
use app\common\model\UserType;
use think\Controller;
use think\Session;
use think\Request;

class Login extends Controller
{
    public function index()
    {
        if(session('?uid')||session('?username')){
            $this->redirect(url('admin/index/index'));
        }
        $adminpage= AdminConfig::where(['code'=>'adminconfig','status'=>1])->find();

        return $this->fetch('',['adminpage'=>$adminpage]);
    }
    /*
     * 登录验证
     * */
    public function postData(){
        $data=input('post.');

        if(!$data['username']||!$data['password']){
            return json(['code'=>400,'data'=>'','message'=>'用户名或者密码不能为空!']);
        }
        $shlt=UsersModel::get($data);
        if(!$shlt){
            return json(['code'=>400,'data'=>'','message'=>'用户名或者密码不正确!']);
        }
        $data['hashed_password']=md5($data['password'].$shlt->salt);
        $res=UsersModel::get($data);
        if(!$res){
            return json(['code'=>400,'data'=>'','message'=>'用户名或者密码不正确!']);
        }
        /*记录登陆时间用户ip等*/
        $login['ip']=Request::instance()->ip();
        $login['uid']=$res['id'];
        $login['username']=$res['username'];
                Loginlog::create($login);
        //获取该管理员的角色信息
        $user = new UserType();
        $info = $user->getRoleInfo($res['groupid']);
        session('uid', $res['id']);             //用户ID
        session('username', $res['username']);  //用户名
        session('avatar', $res['avatar']);  //用户头像
        session('mobile', $res['mobile']);        //手机号
        session('agid', $res['groupid']);          //角色id
        session('rolename', $info['title']);        //角色名
        session('describe', $info['describe']);     //角色描述
        session('rule', $info['rules']);            //角色节点
        session('name', $info['name']);             //角色权限
        session('last_time',time());                //角色登录时间点
        return json(['code'=>200,'data'=>'','message'=>'登陆成功']);
    }
    public function loginout(){

        Session::clear();
        $this->redirect('Login/index');
    }
}
