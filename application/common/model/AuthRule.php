<?php
namespace app\common\model;
use think\Model;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/29
 * Time: 15:32
 */
class AuthRule extends Model{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = true;
    public function rule_where($where){
        return $this->where($where)->find();
    }
}