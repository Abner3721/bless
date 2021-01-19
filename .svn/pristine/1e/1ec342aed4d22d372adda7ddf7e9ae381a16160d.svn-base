<?php
namespace app\admin\controller;
use app\common\model\Webuser as WebuserModel;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/17
 * Time: 14:08
 */
class Webuser extends Base{
    public function index(){
        $result=WebuserModel::all();
        return $this->fetch('',['list'=>$result]);
    }
    /*修改状态*/
    public function getstatus()
    {
        if (Request::instance()->isPost()) {
            $data = input('post.');
            if($data['status']==1){
                $status['status']=0;
            }else{
                $status['status']=1;
            }
            unset($data['status']);
            $bool = WebuserModel::update($status, $data);
            if (!$bool) {
                return json(['code' => 400, 'data' => '', 'message' => '修改失败'],200);
            }
            return json(['code' => 200, 'data' => '', 'message' => '修改成功'],200);
        }
    }

    public function edit($id){
        $result=WebuserModel::get($id);
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(empty($data['password'])||empty($data['repassword'])){
                unset($data['password'],$data['repassword']);
            }else{
                if($data['password'] == $data['repassword']){
                    $data['salt']=rand('100000','999999');
                    $data['password']=  MD5(trim($data['password'],'').$data['salt']);
                    unset($data['repassword']);
                }else{
                    return json(['code'=>400,'msg'=>'密码与确认密码不一致!'],200);
                }

            }
            $bool=WebuserModel::update($data,['id'=>$id]);
            if($bool){
               return json(['result'=>$bool,'code'=>200,'msg'=>'修改成功'],200);
            }else{
               return json(['result'=>$bool,'code'=>400,'msg'=>'修改失败'],200);
            }
        }
        return $this->fetch('',['info'=>$result]);
    }
    public function del($id){
            $del=WebuserModel::destroy($id);
            $this->redirect('Webuser/index');


    }
}