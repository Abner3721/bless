<?php
namespace app\admin\controller;
use app\common\model\Transaction as TransactionModel;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/6/19
 * Time: 17:17
 */
class Transaction extends Base{
    public function index(){
        $result=TransactionModel::all();
        return $this->fetch('',['list'=>$result]);
    }
}