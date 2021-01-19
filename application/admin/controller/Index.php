<?php
namespace app\admin\controller;
use app\common\model\SysNavs;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }
    public function info(){
        $infos = array();
        $infos['服务器操作系统'] = PHP_OS;
        $infos['服务器IP地址'] = $_SERVER['SERVER_ADDR'];
        $infos['Web服务器'] = $_SERVER['SERVER_SOFTWARE'];
        $infos['PHP版本'] = PHP_VERSION;
        $infos['数据库版本'] = '5.5.14';
        $infos['Zlib支持'] = 'yes';
        $infos['安全模式'] = 'no';
        $infos['安全模式gid'] = 'no';
        $infos['时区设置'] = 'Etc/GMT-8';
        $infos['Socket支持'] = 'yes';
        $gd=gd_info();
        $infos['GD版本'] = $gd["GD Version"];
        $infos['文件上传的最大大小'] = '64M';
        $this->assign('serverInfo',$infos);

        $res = array();
        $res['产品设计'] = 'nicedesign';
        $res['项目管理'] = 'nicedesign';
        $res['美术UI设计'] = 'nicedesign';
        $res['开发团队'] = 'nicedesign';
        $res['技术支持'] = '北京奈思科技有限公司';
        $res['产品网站'] = '欢迎访问我们的网站'."<a href='http://www.niceui.cn' style='color: #38c31b;'>http://www.niceui.cn</a>";

        return $this->fetch('',['serverInfo'=>$infos,'productInfo'=>$res]);
    }
}
