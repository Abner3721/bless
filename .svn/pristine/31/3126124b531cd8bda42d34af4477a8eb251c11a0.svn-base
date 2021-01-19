<?php
namespace app\admin\controller;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/22
 * Time: 16:03
 */
use \app\common\model\Categories as CategoriesModel;
use think\Request;

class Categories extends Base{
    public function index(){
        $data=CategoriesModel::paginate(config('adminpage'));
        return $this->fetch('',['data'=>$data]);
    }
    /*添加*/
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $bool=CategoriesModel::create($data);
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
        $res=CategoriesModel::get($id);
            if(Request::instance()->isPost()){
                $data=input('post.');
                $bool= CategoriesModel::update($data,['id'=>$id]);
                if(!$bool){
                    return json(['code'=>400,'data'=>'','message'=>'修改失败']);
                }
                return json(['code'=>200,'data'=>'','message'=>'修改成功']);
            }
        $par_name=CategoriesModel::get($res['parent_id']);
        return $this->fetch('',['info'=>$res,'infoson'=>$par_name]);
    }

    /*删除*/

    public function del($id){
        $bool=CategoriesModel::destroy($id);
        $this->redirect('Categories/index');
    }
    public function getType()
    {
        if(Request::instance()->isAjax()){
            $type=input('post.type');
            $data=CategoriesModel::all(array('type'=>$type));
            return json($data,'200');
        }
        exit;
    }

}