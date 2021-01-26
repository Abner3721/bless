<?php

/**
 * Explanation:祝福语数据库操作类
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2021/1/19 11:32
 **/

namespace app\common\model;
use think\Model;

class Blessing extends Model
{
    protected $autoWriteTimestamp = true;

    public function updateByIdLike($id){
        $res = $this->where('id',$id)->setInc('like');
        return $res;
    }
    public function getImgAttr($imgs){
        if(!$imgs){
            return [];
        }
        $imgs = json_decode($imgs);
        $rows = [];
        foreach ($imgs as $v ){
            $rows[] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$v;
        }
        return $rows;
    }

    public function getLists($page,$size){
        $order = [
            'like'  => 'desc',
        ];
        $where = [
            'status' => 1,
        ];

        $result = $this->where($where)->order($order)->limit($page,$size) ->select();
        return $result;
    }

    public function getMyLists($uid){
        $sql = "SELECT b.id,b.uid,b.nickname,b.like,b.head,b.img,b.content,b.ranking FROM (SELECT t.*, @ranking := @ranking + 1 AS ranking FROM (SELECT @ranking := 0) r,
                    (SELECT id,nickname,uid,`like`, head,img,content FROM tp_blessing ORDER BY `like` DESC) AS t) AS b WHERE b.uid={$uid}";
        $lists = $this->query($sql);
        return $lists;
    }

    public function getIndexLists($page){
        $order = [
            'like'=>'desc',
        ];
        $res = $this->where('status', 1)->order($order)->paginate($page);
        return $res;
    }

}