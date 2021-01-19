<?php
namespace app\admin\controller;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/22
 * Time: 16:03
 */
use app\common\model\Articles as ArticlesModel;
use app\common\model\Categories as CategoriesModel;
use think\Request;

class Articles extends Base{
    public function index(){
        $data=ArticlesModel::paginate(config('adminpage'));
        return $this->fetch('',['data'=>$data]);
    }
    /*添加*/
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $data['created_at']=$data['updated_at']=time();
            $data['content']=json_encode($data['content']);
            $data['extra_info']= serialize($data['extra_info']);
            if($data['imgurl']!=''){
                $data['logo']=$data['imgurl'];
            }
            unset($data['imgurl']);
            $bool=ArticlesModel::create($data);
            if($bool){
                return json(['code'=>200,'data'=>'','message'=>'添加成功']);
            }else{
                return json(['code'=>400,'data'=>'','message'=>'添加失败']);
            }
        }
        $res=CategoriesModel::all(array('parent_id'=>0,'status'=>1));
        foreach($res as $k=>$v){
            $res[$k]['vson']=CategoriesModel::all(array('parent_id'=>$v['id'],'status'=>1));
        }
        return $this->fetch('',['categories'=>$res]);
    }
    /*修改*/
    public function edit($id){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $data['content']=json_encode($data['content']);
            $data['extra_info']=serialize( $data['extra_info']);
            $data['updated_at']=time();
            if($data['logo']==''){
                $data['logo']=$data['imgurl'];
            }
            unset($data['imgurl']);
            $bool=ArticlesModel::update($data,['id'=>$id]);
            if($bool){
                return json(['code'=>200,'data'=>'','message'=>'修改成功']);
            }else{
                return json(['code'=>400,'data'=>'','message'=>'修改失败']);
            }
        }
        $res=ArticlesModel::get($id);
        $res['extra_info']=unserialize($res['extra_info']);
        $res['content']=json_decode($res['content'],true);
        $categories=CategoriesModel::all(array('parent_id'=>0,'status'=>1));
        foreach($categories as $k=>$v){
            $categories[$k]['vson']=CategoriesModel::all(array('parent_id'=>$v['id'],'status'=>1));
        }
        return $this->fetch('',['info'=>$res,'categories'=> $categories]);
    }

    /*删除*/

    public function del($id){
        $bool=ArticlesModel::destroy($id);
        $this->redirect('Articles/index');
    }

}