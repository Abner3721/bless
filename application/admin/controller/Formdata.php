<?php
namespace app\admin\controller;
use app\common\model\Formdata as FormdataModel;
use think\Request;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 16:48
 */
/*菜单展示*/
class Formdata extends Base{
    public function index(){
        $par_nav=FormdataModel::all();
        return $this->fetch('',['par_nav'=>$par_nav]);
    }
    /*菜单删除*/
    public function del($id){
           $del= FormdataModel::destroy($id);
         $this->redirect('Formdata/index');

    }
}