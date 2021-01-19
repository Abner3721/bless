<?php
namespace app\admin\controller;
/**
 * Created by PhpStorm.
 * User: 81985
 * Date: 2019/3/22
 * Time: 16:03
 */
use app\common\model\Articles as ArticlesModel;
use app\common\model\Categories as CategoriesModel;
use think\Request;

class Caches extends Base{
    public function index(){
        if(Request::instance()->isPost()){
                $data=input('post.type');
            $data= trim($data,',');

            if (!empty( $data)) {
                $data=explode(',',$data);
                foreach ($data as $vo) {
                    $this->__rmcache($vo);
                }
            }
            return json('true');
            die;
        }
        return $this->fetch();
        }
    private function __rmcache($type)
    {
        switch ($type) {
            case 'cache':
                $files= str_replace('\\','/',RUNTIME_PATH.'cache');
                $allfilelog=$this->my_scandir( $files);
                foreach($allfilelog as $k=>$v){
                    foreach($v as $son){
                        @unlink( $files.'/'.$k.'/'.$son);
                    }
                    $dir=$this->is_empty_dir($files.'/'.$k);
                    if($dir==true){
                        rmdir($files.'/'.$k);
                    }
                }
                break;
            case 'temp':
                $files= str_replace('\\','/', RUNTIME_PATH.'temp');
                $allfilelog=$this->my_scandir( $files);
                foreach($allfilelog as $v){
                    @unlink( $files.'/'.$v);
                }
                break;
            case 'log':
                $files= str_replace('\\','/',RUNTIME_PATH.'log');
                $allfilelog=$this->my_scandir( $files);
                foreach($allfilelog as $k=>$v){
                  foreach($v as $son){
                      @unlink( $files.'/'.$k.'/'.$son);
                  }
                  $dir=$this->is_empty_dir($files.'/'.$k);
                  if($dir==true){
                      rmdir($files.'/'.$k);
                  }
            }
                break;
        }
        }

        /*判断目录为空*/
    public function is_empty_dir($pathdir){
        $d=opendir($pathdir);
        $i=0;
        while($a=readdir($d))
        {$i++;};closedir($d);
        if($i>2){return false;};return true;
    }

     /*获取所有文件*/
    public function my_scandir($dir){
        $files = array();
        $dir_list = scandir($dir);
        foreach($dir_list as $file) {
            if ( $file != ".." && $file != "." ) {
                if ( is_dir($dir . "/" . $file) ) {
                    $files[$file] = self::my_scandir($dir . "/" . $file);} else {
                    $files[] = $file;}}}
        return $files;
    }
}