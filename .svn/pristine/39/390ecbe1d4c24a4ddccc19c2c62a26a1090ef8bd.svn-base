<?php
namespace app\admin\controller;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/22
 * Time: 16:03
 */
use \app\common\model\News as NewsModel;
use think\Request;

class News extends Base{
    public function index(){
        $data=NewsModel::paginate(config('adminpage'));
        return $this->fetch('',['data'=>$data]);
    }
    /*添加*/
    public function add(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            $data['content']=json_encode($data['content']);
            $data['creared_at']=$data['updated_at']=strtotime($data['creared_at']);
            $bool=NewsModel::create($data);
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
            if(strstr($data['created_at'], '-') != FALSE){
                $data['updated_at']=strtotime($data['created_at']);
                unset($data['created_at']);
            }
            if($data['logo']==''){
               unset($data['logo']);
            }
            $bool=NewsModel::update($data,['id'=>$id]);
            if($bool){
                return json(['code'=>200,'data'=>'','message'=>'修改成功']);
            }else{
                return json(['code'=>400,'data'=>'','message'=>'修改失败']);
            }
        }
        $res=NewsModel::get($id);
        $res['content']=json_decode($res['content'],true);
        return $this->fetch('',['info'=>$res]);
    }

    /*删除*/

    public function del($id){
        $bool=NewsModel::destroy($id);
         $this->redirect('News/index');
    }

}