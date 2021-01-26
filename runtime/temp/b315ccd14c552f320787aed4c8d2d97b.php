<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"E:\wwwroot\www.bless.com\public/../application/admin\view\index\info.html";i:1603163038;}*/ ?>
<link rel="stylesheet" href="/static/admin/css/infostyle.css">
<div class="wrapper wrapper-content animated fadeInRight">
    <style>
        .list.first{ border-right:1px solid #e5e5e5; box-sizing:border-box; margin-right:4%;}
        .list.first>ul{padding-left: 0}
        .list{ width:48%; float:left;}
        .spans{  width:340px;display: inline-block; }
        .newbox{width:30%;float: left;}
        .contents{height: auto;padding-top: 2.5rem;padding-bottom: 2.5rem;font-size: 5rem;text-align: center}
        .ibox-content ul{padding-left: 0}
        em{font-style: normal;}
    </style>

    <div id="rightside">

        <div class="part">

            <div class="welcome or">
                <h1>欢迎登录后台管理系统</h1>
                <p>欢迎访问我们的网站 <a href=" http://www.niceui.cn" target="_blank" style="color: #38c31b;"> http://www.niceui.cn</a></p>
            </div>
            <!--welcome-->

            <div class="ibox float-e-margins newbox">
                <div class="ibox-title">
                    <h5>注册用户数</h5>
                </div>
                <div class="ibox-content contents">
                    0
                </div>
            </div>

            <div class="ibox float-e-margins newbox" style="margin-left: 3%">
                <div class="ibox-title">
                    <h5>商品数量</h5>
                </div>
                <div class="ibox-content contents">
                    0
                </div>
            </div>

            <div class="ibox float-e-margins newbox"  style="margin-left: 3%">
                <div class="ibox-title">
                    <h5>订单数量</h5>
                </div>
                <div class="ibox-content contents">
                    0
                </div>
            </div>

            <div style="clear: both"></div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>系统信息</h5>
                </div>
                <div class="ibox-content">
                    <div class="list first"  >
                        <ul>
                            <?php if(is_array($serverInfo) || $serverInfo instanceof \think\Collection || $serverInfo instanceof \think\Paginator): $_600f8287dd2b8 = is_array($serverInfo) ? array_slice($serverInfo,0,5, true) : $serverInfo->slice(0,5, true); if( count($_600f8287dd2b8)==0 ) : echo "" ;else: foreach($_600f8287dd2b8 as $k=>$vo): ?>
                            <li style="list-style: none"><span class="spans"><?php echo $k; ?></span><em><?php echo $vo; ?></em></li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <div class="list"  >
                        <ul>
                            <?php if(is_array($serverInfo) || $serverInfo instanceof \think\Collection || $serverInfo instanceof \think\Paginator): $_600f8287dd269 = is_array($serverInfo) ? array_slice($serverInfo,6,11, true) : $serverInfo->slice(6,11, true); if( count($_600f8287dd269)==0 ) : echo "" ;else: foreach($_600f8287dd269 as $k=>$vo): ?>
                            <li style="list-style: none"><span class="spans"><?php echo $k; ?></span><em><?php echo $vo; ?></em></li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>开发和测试</h5>
                </div>
                <div class="ibox-content">
                    <ul>
                        <?php if(is_array($productInfo) || $productInfo instanceof \think\Collection || $productInfo instanceof \think\Paginator): if( count($productInfo)==0 ) : echo "" ;else: foreach($productInfo as $k=>$vo): ?>
                        <li style="list-style: none"><span class="ems"><?php echo $k; ?></span><em><?php echo $vo; ?></em></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>

        </div>
        <!--part-->

    </div>
</div>