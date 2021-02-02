<?php

/**
 * Explanation:祝福语数据库操作类
 * Author: Abner
 * Email:372195546@qq.com
 * Date: 2021/1/19 11:32
 **/

namespace app\common\model;
use think\Model;
use think\Request;

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
            $rows[] = Request::instance()->domain().$v;
        }
        return $rows;
    }

    /**
     * Explanation:
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/29 19:14
     * @param $size;显示条数
     * @param $where;条件
     * @param $order;排序规则
     * @return \think\Paginator
     */
    public function getLists($size,$where,$order){
        $result = $this->where($where)->order($order)->paginate($size);
        return $result;
    }

    public function getMyLists($uid){
        $sql = "SELECT b.id,b.uid,b.nickname,b.like,b.head,b.img,b.content,b.status, b.ranking FROM (SELECT t.*, @ranking := @ranking + 1 AS ranking FROM (SELECT @ranking := 0) r,
                    (SELECT id,nickname,uid,`like`, head,img,content, status FROM tp_blessing WHERE status=1 ORDER BY `like` DESC) AS t) AS b WHERE  b.status=1 AND b.uid={$uid} ";
        $lists = $this->query($sql);
        return $lists;
    }

    public function getIndexLists($page,$noId){
        $order = [
            'like'=>'desc',
        ];
        if(!empty($noId)){
            $where = [
                'id'        => ['<>',$noId],
            ];
        }
        $where = [
            'status'    => 1,
        ];
        $res = $this->where($where)->order($order)->paginate($page);
        return $res;
    }

    /**
     * Explanation:后台更新like数据量
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/26 20:40
     * @param $id
     * @param $like
     * @return int|string
     */
    public function updateByIdLikeAdmin($id,$like){
        $res = $this->where('id', $id)->setField('like', $like);
        return $res;
    }

}