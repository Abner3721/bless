<?php
namespace app\common\model;
use think\Model;

/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/20
 * Time: 15:41
 */
class Webuser extends Model
{
    /*自动添加当前时间挫*/
    protected $autoWriteTimestamp =true;
    // 数据表名称
    protected $table='tp_webuser';

    public  function getByOpenID($openid){
        $where = [
            'status' => 1,
            'openid' => $openid,
        ];
        $result = self::where($where)->find();
        if(!$result){
            return [];
        }
        return $result->toArray();

    }

    public function updateByPhone($id,$data){
        $result = $this->save($data,['id'=>$id]);
        return $result;
    }

}