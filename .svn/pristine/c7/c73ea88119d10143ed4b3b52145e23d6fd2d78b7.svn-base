<?php
namespace app\admin\controller;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/22
 * Time: 16:03
 */
use \app\common\model\Joins as JoinsModel;
use think\Request;

class Joins extends Base{
    public function index(){
        $data=JoinsModel::paginate(config('adminpage'));
        return $this->fetch('',['data'=>$data]);
    }


    /*修改*/
    public function edit($id){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $data['content']=json_encode($data['content']);
            if($data['imgurl']!=''){
                $data['logo']=$data['imgurl'];
            }
            unset($data['imgurl']);
            $bool=JoinsModel::create($data);
            if($bool){
                return json(['code'=>200,'data'=>'','message'=>'添加成功']);
            }else{
                return json(['code'=>400,'data'=>'','message'=>'添加失败']);
            }
        }
        $res=JoinsModel::get($id);
        return $this->fetch('',['info'=>$res]);
    }

    /*删除*/

    public function del($id){
        $bool=JoinsModel::destroy($id);
        $this->redirect('Joins/index');
    }

}