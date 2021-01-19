<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"E:\wwwroot\www.bless.com\public/../application/admin\view\webuser\index.html";i:1610941965;s:66:"E:\wwwroot\www.bless.com\application\admin\view\public\colors.html";i:1603163038;}*/ ?>
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
    <style type="text/css">
    /*adelect删除，btn-edit修改，btn-add添加，btn-up返回上一级，btn-desc查看详情，模块列表*/
   .adelect{
    background-color: <?php echo $adminpage['delcolor']; ?>;
    border-color: <?php echo $adminpage['delcolor']; ?>;
    }

   .adelect , .adelect:hover,.adelect:focus,.adelect:active:hover {
   background-color: <?php echo $adminpage['delcolor']; ?>;
   border-color: <?php echo $adminpage['delcolor']; ?>;
   }

   .btn-edit,.btn-edit:hover,.btn-edit:focus,.btn-edit:active:hover {
   background-color: <?php echo $adminpage['editcolor']; ?>;
   border-color: <?php echo $adminpage['editcolor']; ?>;

   }
   .btn-add,.btn-add:hover,.btn-add:focus,.btn-add:active:hover{
   background-color: <?php echo $adminpage['addcolor']; ?>;
   border-color: <?php echo $adminpage['addcolor']; ?>;
   }
   .btn-up,.btn-up:hover,.btn-up:focus,.btn-up:active:hover{
    color: <?php echo $adminpage['upcolor']; ?>;
   }
    .btn-desc,.btn-desc:hover,.btn-desc:focus,.btn-desc:active:hover{
    background-color: <?php echo $adminpage['desccolor']; ?>;
    border-color: <?php echo $adminpage['desccolor']; ?>;
    }



</style>
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
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>头像</th>
                            <th>创建时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr class="gradeX">
                            <td><?php echo $vo['id']; ?></td>
                            <td><?php echo $vo['nickname']; ?></td>
                            <td><?php echo $vo['phone']; ?></td>
                            <td><a target="_blank" href="<?php echo $vo['imgurl']; ?>"><?php echo getimgurl($vo['imgurl']); ?></a></td>
                            <td class="center"><?php echo $vo['create_time']; ?></td>
                            <td class="center"><a class="btn btn-primary" href="javascript:;" onclick="getstatus(<?php echo $vo['status']; ?>,<?php echo $vo['id']; ?>)" ><?php echo getstatus($vo['status']); ?></a></td>
                            <td class="center"><a href="<?php echo url('Webuser/edit',array('id'=>$vo['id'])); ?>" class="btn btn-primary btn-desc">查看详情</a>&nbsp&nbsp&nbsp<a  href="<?php echo url('Webuser/del',array('id'=>$vo['id'])); ?>" class="btn btn-primary adelect">删除</a></td>
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
<script src="/static/admin/js/plugins/layer/layer.min.js"></script>
<script type="text/javascript">
    $(function () {
        $(".adelect").click(function () {
            var delurl=$(this).attr('href');
            layer.confirm('是否要真的删除？', {
                btn: ['是','否'] //按钮
            }, function(){
                layer.msg('删除成功!', {time: 1000,icon: 1},function () {
                    window.location.href=delurl;
                });
            }, function(){
            });
            return false;
        })
    })
</script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function () {
        $('.dataTables-example').dataTable();

        /* Init DataTables */
        var oTable = $('#editable').dataTable();

        /* Apply the jEditable handlers to the table */
        oTable.$('td').editable('../example_ajax.php', {
            "callback": function (sValue, y) {
                var aPos = oTable.fnGetPosition(this);
                oTable.fnUpdate(sValue, aPos[0], aPos[1]);
            },
            "submitdata": function (value, settings) {
                return {
                    "row_id": this.parentNode.getAttribute('id'),
                    "column": oTable.fnGetPosition(this)[2]
                };
            },

            "width": "90%",
            "height": "100%"
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
    function getstatus(status,id) {
        $.ajax({
            type: "POST",
            url: "<?php echo url('Webuser/getstatus'); ?>",
            data: {id:id,status:status},
            dataType: "json",
            success: function (data) {
                if (data.code == '200') {
                    layer.msg(data.message, {
                        time:2000,icon: 6
                    },function(){
                        window.location.reload();
                    });
                } else {
                    layer.alert(data.message, {
                    icon: 2,
                    skin: 'layer-ext-moon'
                });
                    return false;
                }

            }
        });
    }


</script>

</body>

</html>
