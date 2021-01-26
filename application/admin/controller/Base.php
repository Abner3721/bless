<?php
namespace app\admin\controller;
use app\common\model\AuthRule;
use app\common\model\AdminConfig;
use app\common\model\Node;
use auth\Auth;
use think\Controller;
use think\Db;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/22
 * Time: 13:46
 */
class Base extends Controller{
    public function _initialize()
    {

        if(!session('?uid')||!session('?username')){
            $this->redirect(url('admin/login/index'));
        }
            $adminSta = Db::name ('users')->where ('id' , session ('uid'))->field ('status,username,groupid')->find ();
            $roleSta = Db::name ('users')->alias ('a')->join ('auth_group g' , 'a.groupid=g.id' , 'left')->where ('a.id' , session ('uid'))->field ('g.status,g.title')->find ();
            if ( is_null ($adminSta[ 'usupload_imgername' ]) ) {
                writelog (session ('username') . '账号不存在,强制下线！' , 200);
                $this->error ('抱歉，账号不存在,强制下线' , 'admin/login/loginout');
            }
            if ( is_null ($roleSta[ 'title' ]) ) {
                writelog (session ('rolename') . '身份不存在,强制下线！' , 200);
                $this->error ('抱歉，身份不存在,强制下线' , 'admin/login/loginout');
            }
            if ( $adminSta[ 'status' ] == 2 ) {
                writelog ($adminSta[ 'username' ] . '账号被禁用,强制下线！' , 200);
                $this->error ('抱歉，该账号被禁用，强制下线' , 'admin/login/loginout');
            }
            if ( $roleSta[ 'status' ] == 2 ) {
                writelog ($roleSta[ 'title' ] . '角色被禁用,强制下线！' , 200);
                $this->error ('抱歉，该账号角色被禁用，强制下线' , 'admin/login/loginout');
            }

        $auth = new Auth();
        $module     = strtolower(request()->module());
        $controller = request()->controller();
        $action     = strtolower(request()->action());
        $url        = $module."/".cc_format($controller)."/".$action;
        //跳过检测以及主页权限
        if(session('uid')!=1){
          /*  $rules = Db::name ('auth_group')->where ('id' , $adminSta['groupid'])>field('rules')->find();
            $pass = Db::name ('auth_rule')->field('name')->all($rules['rules']);
            var_dump();*/
            foreach(config('auth_pass') as $vo){
                $pass[] = strtolower($vo);
            }
            if(!in_array($url,$pass)){
                if(!$auth->check($url,session('uid'))){
                        $this->error('抱歉，您没有操作权限',url('admin/index/info'));
                }
            }
        }
        $controllers = request()->controller();
        $urlss = $module."/".cc_format($controllers)."/".$action;
        $title= AuthRule::where(['name'=>$urlss])->field('title')->find();
        $adminpage= AdminConfig::where(['code'=>'adminconfig','status'=>1])->find();
        //首页展示用户&菜单信息
        $node = new Node();
        $this->assign([
            'username' => session('username'),
            'avatar' => session('avatar'),
            'portrait' => session('portrait'),
            'rolename' => session('rolename'),
            'menu' => $node->getMenu(session('rule')),
            'alltitle'=>$title['title'],
            'adminpage'=>$adminpage,
        ]);
    }


    /*单图上传*/
    public function upload_img(){
        $file = request()->file('file');
            $info = $file->move(ROOT_PATH . 'public' .config('upload'));
            if($info){
                $filepath= str_replace('\\','/',(config('upload').$info->getSaveName()));
              return json($filepath,'200');
            }else{
                return json('','400');
            }

}

    /*单图上传*/
    public function upload_imgs(){
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' .config('upload'));
        if($info){
            $filepath= str_replace('\\','/',(config('upload').$info->getSaveName()));
            return json(array('imgs'=>$filepath),'200');
        }else{
            return json('','400');
        }
    }
}