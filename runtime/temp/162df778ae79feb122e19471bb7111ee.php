<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"E:\wwwroot\www.bless.com\public/../application/admin\view\index\index.html";i:1603163038;s:66:"E:\wwwroot\www.bless.com\application\admin\view\public\header.html";i:1603163038;s:66:"E:\wwwroot\www.bless.com\application\admin\view\public\footer.html";i:1603163038;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>奈思科技</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/admin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <link href="/static/admin/css/style.css?v=4.1.0" rel="stylesheet">
    <script src="/static/admin/js/jquery.min.js?v=2.1.4"></script>
    <style type="text/css">
        .headerimg{
            display: block;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border:6px solid #C0C0C0;
            transition:all 500ms;
        }
        .headerimg:hover{
            transform:rotate(320deg);
        }
        .nav-second-level li a.on{
                color: white;
        }
    </style>
    <style type="text/css">
        .btn-info ,.btn-info:hover,.btn-info:focus,.btn-info:active:hover{
            background-color:<?php echo $adminpage['admincolor']; ?>;
            border-color:<?php echo $adminpage['admincolor']; ?>;
        }
        .form-group h3 a{
            color: <?php echo $adminpage['admincolor']; ?>;
        }
        .nav > li.active{
            border-left: 4px solid <?php echo $adminpage['admincolor']; ?>;
        }
        body.mini-navbar .nav-header{
        background-color:<?php echo $adminpage['admincolor']; ?>;
        }
    </style>



</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;"><strong class="font-bold"><?php echo $adminpage['title']; ?></strong>
                                    </span>
                                </span></a></div>
                    <div class="logo-element"><?php echo $adminpage['title_mall']; ?></div>
                </li>
                <?php foreach($menu as $vo): ?>
                <li>
                    <a href="javascript:;">
                        <span class="nav-label" style="font-size: 15px"><?php echo $vo['title']; ?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php if(!(empty($vo['child']) || (($vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator ) && $vo['child']->isEmpty()))): foreach($vo['child'] as $son): ?>
                        <li>
                            <a class="J_menuItem" href="<?php echo url($son['name']); ?>" style="font-size: 15px"><?php echo $son['title']; ?></a>
                        </li>
                        <?php endforeach; endif; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
    <script type="text/javascript">
        $(function(){
            $('.nav-second-level li a').click(function () {
                $(this).addClass('on').parents('li').siblings().find('a').removeClass('on');
            });
        })

    </script>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="javascript:;" style="margin-top: 25px" ><i class="fa fa-bars"></i></a>
                </div>
                <div class="form-group">
                    <h3 style="float: right; margin-right: 40px; line-height: 60px;"><a href="<?php echo url('Login/loginout'); ?>">退出登录</a></h3>
                    <h3 style="float: right; margin-right: 40px; line-height: 60px;"><a href="<?php echo url('/'); ?>" target="_blank">网站首页</a></h3>
                    <h3 style="float: right; margin-right: 80px; line-height: 60px;">欢迎 <?php echo $username; ?> 登录平台</h3>
                </div>
            </nav>
        </div>

        <div class="row J_mainContent" id="content-main">
            <iframe id="J_iframe" width="100%" height="100%" src="<?php echo url('Index/info'); ?>" frameborder="0" data-id="index_v1.html" seamless></iframe>
        </div>

</div>
<!--右侧部分结束-->
</div>

<!-- 全局js -->

<script src="/static/admin/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/static/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/static/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/static/admin/js/plugins/layer/layer.min.js"></script>

<!-- 自定义js -->
<script src="/static/admin/js/hAdmin.js?v=4.1.0"></script>
<script type="text/javascript" src="/static/admin/js/index.js"></script>

<!-- 第三方插件 -->
<script src="/static/admin/js/plugins/pace/pace.min.js"></script>

</body>

</html>
