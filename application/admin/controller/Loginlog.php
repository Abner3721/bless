<?php
namespace app\admin\controller;
use app\common\model\Loginlog as LoginlogModel;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/17
 * Time: 12:10
 */
class Loginlog extends Base{
    public function index(){
       $result= LoginlogModel::order('id','desc')->select();
        return $this->fetch('',['list'=>$result]);
    }

}