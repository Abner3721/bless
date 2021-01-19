<?php
namespace app\admin\controller;
use think\File;
use think\Request;
use app\common\model\MetadataGroups as MetadataGroupsModel;
use app\common\model\Metadatas as MetadatasModel;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 16:48
 */
/*菜单展示*/
class Metadatas extends Base {
    public function index(){
        $par_nav=MetadataGroupsModel::all();
        return $this->fetch('',['par_nav'=>$par_nav]);
    }
    /*菜单添加*/
    public function groupadd(){
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(isset($data['properties'])){
            $properties = array();
            if (!empty($data['properties'])) {
                foreach ($data['properties'] as $code => $array) {
                        if(empty($array['code'])){
                                unset($array);
                            } else {
                            if(strstr($array['input_values'],',') !== FALSE){
                                $data['properties'][$code]['input_values'] = str_replace(',', "\n", $array['input_values']);
                            }}}}
            $data['properties']=serialize($data['properties']);
            }
            $bool=MetadataGroupsModel::create($data);
            if(!$bool){
                return json(['code'=>400,'data'=>'','message'=>'提交失败']);
            }else{
                return json(['code'=>200,'data'=>'','message'=>'提交成功']);
            }
        }
        return $this->fetch('',['cate'=>get_parent_son_all('input_types')]);
    }
    /*菜单修改*/
    public function groupedit($id){
        $info=MetadataGroupsModel::get($id)->toArray();
        if(Request::instance()->isPost()){
            $data=input('post.');
            if(isset($data['properties'])) {
                $properties = array();
                if (!empty($data['properties'])) {
                    foreach ($data['properties'] as $code => $array) {
                        if (empty($array['code'])) {
                            unset($array);
                        } else {
                            if (strstr($array['input_values'], ',') != FALSE) {
                                $data['properties'][$code]['input_values'] = str_replace(',', "\n", $array['input_values']);
                            }
                        }
                    }
                }
                $data['properties'] = serialize($data['properties']);
            }
           $bool= MetadataGroupsModel::update($data,['id'=>$id]);
           if(!$bool){
               return json(['code'=>400,'data'=>'','message'=>'修改失败']);
           }
            return json(['code'=>200,'data'=>'','message'=>'修改成功']);
        }
        return $this->fetch('',['info'=>get_unserialize_on($info,'properties'),'cate'=>get_parent_son_all('input_types')]);
    }
    /*菜单删除*/
    public function groupdel($id){
           $del= MetadataGroupsModel::destroy($id);
            $this->redirect('Metadatas/index');
    }



    public function del($id){
        $del= MetadatasModel::destroy($id);
        $this->redirect('Metadatas/sonindex');
    }
    public function sonindex(){
        $group_id=input('param.group_id',0);
        $parent_id=input('param.parent_id',0);
        $par_nav= MetadatasModel::all(array('group_id'=>$group_id,'parent_id'=>$parent_id));
        return $this->fetch('',['par_nav'=>$par_nav,'group_id'=>$group_id,'parent_id'=>$parent_id]);
    }
    public function add($id){
        $par_nav = MetadatasModel::all(array('group_id' =>$id,'status'=>1,'parent_id'=>0));
        $tuoz=MetadataGroupsModel::get($id)->toArray();
        $tuoz=html_input_array($tuoz);
        if(Request::instance()->isPost()){
       $data=input('post.');
       if(!empty($tuoz['properties'] )) {
           foreach ($tuoz['properties'] as $v) {
               if ($v['input_type'] == 'file') {
                   foreach ($data['extra_info'] as $k => $val) {
                       if ($v['code'] == $k) {
                           if ($_FILES['extra_info']['error'][$k] == 0) {
                               $ear_img[$k]['tmp_name'] = $_FILES['extra_info']['tmp_name'][$k];
                               $ear_img[$k]['type'] = $_FILES['extra_info']['type'][$k];
                               $ear_img[$k]['name'] = $_FILES['extra_info']['name'][$k];
                               $ear_img[$k]['error'] = $_FILES['extra_info']['error'][$k];
                               $ear_img[$k]['size'] = $_FILES['extra_info']['size'][$k];
                               $data['extra_info'][$k] = $this->upload_imgs($k, $ear_img);
                           }
                       }
                   }
               }
           }

           $data['extra_info'] = serialize($data['extra_info']);
       }
           $data['group_id']=$id;
            $bool=MetadatasModel::create($data);
            if(!$bool){
               $this->error('提交失败',url('Metadatas/sonindex',array('group_id'=>$id)));
            }else{
                $this->success('提交成功',url('Metadatas/sonindex',array('group_id'=>$id,'parent_id'=>$bool['parent_id'])));
            }
        }
        return $this->fetch('',['par_nav'=>$par_nav,'group_id'=>$id,'tuoz'=>$tuoz]);

    }
    public function edit($id)
    {
        $son = MetadatasModel::get($id)->toArray();
        $par_nav = MetadatasModel::all(array('group_id' =>$son['group_id'],'status'=>1,'parent_id'=>0));
        $son['extra_info']=unserialize($son['extra_info']);
        $parents = MetadataGroupsModel::get($son['group_id'])->toArray();
        $tuoz = html_input_array($parents);
        if (Request::instance()->isPost()) {
            $data = input('post.');
            if(!empty($tuoz['properties'] )) {
            foreach ($tuoz['properties'] as $v) {
                if ($v['input_type'] == 'file') {
                    foreach ($data['extra_info'] as $k => $val) {
                        if ($v['code'] == $k) {
                            if ($_FILES['extra_info']['error'][$k] == 0) {
                                $ear_img[$k]['tmp_name'] = $_FILES['extra_info']['tmp_name'][$k];
                                $ear_img[$k]['type'] = $_FILES['extra_info']['type'][$k];
                                $ear_img[$k]['name'] = $_FILES['extra_info']['name'][$k];
                                $ear_img[$k]['error'] = $_FILES['extra_info']['error'][$k];
                                $ear_img[$k]['size'] = $_FILES['extra_info']['size'][$k];
                                $data['extra_info'][$k] = $this->upload_imgs($k, $ear_img);
                            }
                        }
                    }
                }
            }

            $data['extra_info'] = serialize($data['extra_info']);
            }
            $bool = MetadatasModel::update($data,array('id'=>$id));
            if (!$bool) {
                $this->error('修改失败', url('Metadatas/sonindex', array('group_id' =>$son['group_id'])));
            } else {
                $this->success('修改成功', url('Metadatas/sonindex', array('group_id' =>$son['group_id'],'parent_id'=>$son['parent_id'])));
            }
        }
        return $this->fetch('', ['info' => $son, 'parent_id' => $id, 'tuoz' => $tuoz,'par_nav'=>$par_nav,'group_id'=>$son['group_id']]);
    }
    public function getparnav()
    {
        if (Request::instance()->isPost()) {
            $gid =input('post.gid');
            $pid =input('post.pid');
            $par_nav = MetadatasModel::all(array('group_id' =>$gid,'status'=>1,'parent_id'=>$pid));
            return json(['data'=>$par_nav,'code'=>200]);
        }
    }


}