<?php
namespace app\admin\controller;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/22
 * Time: 16:03
 */
use app\common\model\Products as ProductsModel;
use think\Request;

class Products extends Base{
    public function index(){
        $data=ProductsModel::paginate(config('adminpage'));
        return $this->fetch('',['data'=>$data]);
    }
    /*添加*/
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $data['content']=json_encode($data['content']);
            if($data['imgurl']!=''){
                $data['logo']=$data['imgurl'];
            }
            unset($data['imgurl']);
            $bool=ProductsModel::create($data);
            if($bool){
                return json(['code'=>200,'data'=>'','message'=>'添加成功']);
            }else{
                return json(['code'=>400,'data'=>'','message'=>'添加失败']);
            }
        }
        return $this->fetch();
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
            $bool=ProductsModel::create($data);
            if($bool){
                return json(['code'=>200,'data'=>'','message'=>'添加成功']);
            }else{
                return json(['code'=>400,'data'=>'','message'=>'添加失败']);
            }
        }
        $res=ProductsModel::get($id);
        return $this->fetch('',['info'=>$res]);
    }

    /*删除*/

    public function del($id){
        $bool=ProductsModel::destroy($id);
        $this->redirect('Products/index');
    }

    public function img(){
       return $this->upload_img();
    }
}