<?php
/**
 * Explanation:
 * Author: Abner
 * Email: 372195546@qq.com
 * Date: 2021/1/26 17:30
 */

namespace app\admin\controller;
use app\api\service\Blessing as BlessingModel;
use app\api\validate\Blessing as BlessingValidata;
use think\Request;

class Blessing extends Base
{
    public $server = null;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->server = new BlessingModel();
    }

    public function index(){
        $page = input('page', 1, 'intval');
        $size = 20;
        $where = [
            'status' => ['<>', 99],
        ];
        $order = [
            'like'  => 'desc',
        ];

        $lists =  $this->server->getLists($page,$size,$where,$order);
        return $this->fetch('', ['lists'=>$lists]);
    }

    public function likes(){
        $id     = input('param.id', 0, 'intval');
        $like   = input('param.likes', 0, 'intval');
        $data = [
            'id'    => $id,
            'like'  => $like
        ];
        $validate = new BlessingValidata();
        if(!$validate->scene('adminLike')->check($data)){
            return showError(201,$validate->getError());
        }
        $res = $this->server->updateByIdLikeAdmin($id,$like);
        if($res){
            return success(200, '更新成功');
        }else{
            return showError(201,'更新失败！');
        }
    }

    /**
     * Explanation: 更新祝福书范围显示
     * Author: Abner
     * Email: 372195546@qq.com
     * Date: 2021/1/27 11:52
     * @return mixed|\think\response\Json
     */
    public function config(){
        $data = input('param.');
        if($this->request->isPost()){
            $validate = new BlessingValidata();
            if(!$validate->scene('config')->check($data)){
                return showError(201,$validate->getError());
            }
            $str = "<?php  \r\n return  ".var_export($data,true)."; \r\n ?>";
            $path = APP_PATH.'extra/blessing.php';
            $path = str_replace('\\','/',$path);
            $result = file_put_contents($path,$str);
            if($result){
                return success(200,'更新成功');
            }else{
                return showError(201,'更新失败');
            }

        }
        return $this->fetch('');
    }

    /*修改状态*/
    public function status()
    {
        if (Request::instance()->isPost()) {
            $id = input('param.id','', 'intval');
            $status['status']=99;
            $where = [
                'id' => $id,
                'status'=>1,
            ];
            $bool = $this->server->updateByIdStatus($where, $status);
            if (!$bool) {
                return showError(201,'删除失败');
            }
            return success(200, '删除成功');
        }
    }




}