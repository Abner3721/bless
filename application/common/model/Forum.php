<?php
namespace app\common\model;
use think\Model;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 15:41
 */
class Forum extends Model{
    protected $autoWriteTimestamp=true;
    // 数据表名称
    protected $table='tp_forum';
}