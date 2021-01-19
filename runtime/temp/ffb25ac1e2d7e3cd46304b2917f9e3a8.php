<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"E:\wwwroot\www.bless.com\public/../application/admin\view\loginlog\index.html";i:1603163038;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/admin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <!-- Data Tables -->
    <link href="/static/admin/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <link href="/static/admin/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $alltitle; ?></h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover log">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>登录ip</th>
                            <th>上次登录时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr class="gradeX">
                            <td><?php echo $vo['id']; ?></td>
                            <td><?php echo $vo['username']; ?></td>
                            <td><?php echo $vo['ip']; ?></td>
                            <td><?php echo $vo['create_time']; ?></td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="/static/admin/js/jquery.min.js?v=2.1.4"></script>
<script src="/static/admin/js/bootstrap.min.js?v=3.3.6"></script>



<script src="/static/admin/js/plugins/jeditable/jquery.jeditable.js"></script>

<!-- Data Tables -->
<script src="/static/admin/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="/static/admin/js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!-- 自定义js -->
<script src="/static/admin/js/content.js?v=1.0.0"></script>


<!-- Page-Level Scripts -->
<script>
    $(document).ready(function () {
        $('.log').dataTable({
            ordering:  false,
            "aLengthMenu": [30,50,100,500],

        });

    });

    function fnClickAddRow() {
        $('#editable').dataTable().fnAddData([
            "Custom row",
            "New row",
            "New row",
            "New row",
            "New row"]);

    }
</script>

</body>

</html>
