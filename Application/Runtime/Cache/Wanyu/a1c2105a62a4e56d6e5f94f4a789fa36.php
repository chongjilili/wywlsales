<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($title); ?> 管理系统 </title>
    
    <meta charset="UTF-8">

    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ($title); ?> 后台</title>
    <link href="/wywlsale/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/wywlsale/Application/Wanyu/View/public/css/main.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="/wywlsale/Application/Wanyu/View/public/css/tipso.css">

    <script type="text/javascript" src="/wywlsale/Public/jquery/jquery-2.1.min.js"></script>
    <script type="text/javascript" src="/wywlsale/Public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/wywlsale/Public/layer/layer.js"></script>
    <script type="text/javascript" src="/wywlsale/Application/Wanyu/View/public/js/common.js"></script>
    <link rel="stylesheet" type="text/css" href="/wywlsale/Application/Wanyu/View/public/css/css.css">
    <link rel="stylesheet" type="text/css" href="/wywlsale/Application/Wanyu/View/public/css/css-responsive.css">
    <link rel="stylesheet" type="text/css" href="/wywlsale/Application/Wanyu/View/public/css/iconfont.css">
    <script src="/wywlsale/Application/Wanyu/View/public/js/tipso.js"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="/wywlsale/Public/jqgrid/css/redmond/jquery-ui-1.8.16.custom.css"/>

    <link rel="stylesheet" type="text/css" media="screen" href="/wywlsale/Public/jqgrid/css/ui.jqgrid.css"/>

    <!--<link rel="stylesheet" type="text/css" media="screen" href="js/src/css/jquery.searchFilter.css" />-->

    <style>

        html, body {
            margin: 0;

            padding: 0;

            font-size: 75%;

        }

    </style>

    <script type="text/javascript" src="/wywlsale/Public/jqgrid/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/wywlsale/Public/jqgrid/js/i18n/grid.locale-cn.js"></script>
    <script type="text/javascript" src="/wywlsale/Public/jqgrid/js/jquery.jqGrid.src.js"></script>
    <script src="/wywlsale/Public/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>


</head>
<body>


<meta charset="UTF-8">


<?php $risingsetting = D('Risingsetting')->find(); ?>

<?php $risingsetting = $risingsetting; ?>

<div class="addtype">
    股值：<span><?php echo ($risingsetting["shares"]); ?></span>&nbsp;|
    公司交易量：累计<span class="nownum"><?php echo ($risingsetting["nownum"]); ?></span>单

    <h2>+1</h2>
</div>
<script type="application/javascript">


    $(function () {
        var speed = '<?php echo ($risingsetting["risingtime"]); ?>';
        speed = parseInt(speed)*1000;
        settime = setInterval(function () {
            addyounum();
        },speed);

    });

    /*右上角的动画函数*/
    function addyounum() {

        var addtype = $('.addtype');
        //复位
        addtype.find('h2').css({
            'top':40,
            'font-size' : '30px'
        });
        addtype.find('h2').animate({
            'top':-40,
            'font-size' : '0px'
        },1500,function () {
            //回调函数
            var addtypespan = addtype.find('span.nownum');
            var ordernum = parseInt(addtypespan.text());
            addtypespan.text(++ordernum);//新的单数
            $.ajax({
                url:"<?php echo U('Risingsetting/refresh');?>",
                type:"POST",
                data:{
                    id:'<?php echo ($risingsetting["id"]); ?>',
                    nownum:ordernum
                },
                success:function (data) {
                    console.log(data);

                }
              }
            );

        })
    }

</script>
<div class="top">
    <section></section>
</div>
<div id="header" class="container">
    <div class="nowtime hidden-xs">登录时间：<?php echo (session('wy_logintime')); ?></div>
    <div class="welcome" style="">
            <span>欢迎<b><?php echo (session('wy_username')); ?></b>
             <?php if(session('usertype') == 1): ?>普通代理
            <?php elseif(session('usertype') == 2): ?>
                 银牌代理
            <?php elseif(session('usertype') == 3): ?>
                金牌代理
            <?php elseif(session('usertype') == 9): ?>
                公司管理员
                               <?php if(session('toexaminepass')): ?><a href="<?php echo U('Login/examinepassloginout');?>" oid=""
                                      target="_parent"
                                       onclick="return confirm('你真的要退出审核员登录吗？')"
                                      class="exampeople label label-success">退出审核</a>

                                   <a href="#"  data-toggle="modal"
                                      data-target=".bs-example-modal-sm2"
                                      target="_parent"
                                      class="exampeople label label-success">审核设置</a>

                                    <?php else: ?>
                                    <a href="#"    oid="" class="exampeople label label-warning" data-toggle="modal"
                                       data-target=".bs-example-modal-sm"  >登录审核</a>



                                   <!-- 登录审核员 --><?php endif; endif; ?>
                <a href="<?php echo U('Login/logout');?>" target="_parent" class="hidden-xs"
                   onclick="return confirm('你真的要退出登录吗？')">
                退出
                  </a>
            </span>

    </div>
</div>
<nav class="navbar" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
            <div class="logo-hidden"></div>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/wywlsale/index.php?s="
                    <?php if($active == 1): ?>class="active"<?php endif; ?>
                    >首页</a></li>
            <!--
                <li><a href="<?php echo U('Achievement/companyprofit',array('adminid'=> 1 ) );?>"
                    <?php if($active == 2): ?>class="active"<?php endif; ?>
                    >业绩查看</a></li>
                -->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">业绩总况 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo U('Achievement/companyprofit',array('adminid'=> 1 ) );?>"
                            <?php if($active == 2): ?>class="active"<?php endif; ?>
                            >业绩查看</a>
                        </li>
                        <li><a href="<?php echo U('Risingsetting/jqgrid');?>">业绩报表</a></li>
                        <li><a href="<?php echo U('Withdrawalsmsg/wsdeelwith');?>"  <?php if($active == 7): ?>class="active"<?php endif; ?> >提现申请</a></li>
                        <li><a href="<?php echo U('Risingsetting/index');?>"  <?php if($active == 8): ?>class="active"<?php endif; ?> >右上单量</a></li>
                        <li><a href="<?php echo U('Email/index');?>"  <?php if($active == 9): ?>class="active"<?php endif; ?> >邮箱设置</a></li>


                    </ul>
                </li>

                <li><a href="<?php echo U('Achievement/picture');?>"
                    <?php if($active == 3): ?>class="active"<?php endif; ?>
                    >组织视图</a></li>
                <li><a href="<?php echo U('Order/index');?>"
                    <?php if($active == 4): ?>class="active"<?php endif; ?>
                    >订单管理</a></li>
                <li><a href="<?php echo U('Admin/manage');?>"
                    <?php if($active == 5): ?>class="active"<?php endif; ?>
                    >成员管理</a></li>
                <li><a href="<?php echo U('Promag/index');?>"
                    <?php if($active == 6): ?>class="active"<?php endif; ?>
                    >产品管理</a></li>

               <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>-->

                <!--<li class="visible-xs"><a href="javascript:;" class="openOfManager" data-url="changePassword">修改密碼</a>
                </li>-->
                <li class="visible-xs"><a href="<?php echo U('Login/logout');?>" target="_parent"
                                          onclick="return confirm('你真的要退出登录吗？')" class="logout">退出</a></li>
            </ul>
        </div>
    </div>
</nav>



<!--/*************************登录审核员*******************************/-->

<!-- 登录审核员 -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">登录审核员</h4>

            </div>

            <div class="modal-body">
                <form action="<?php echo U('Login/examinepasslogin');?>" method="post" id="examinform">
                    <div class="form-group">
                        <label for="toexaminepass" class="control-label">审核密码:</label>
                        <input type="password" class="form-control" id="toexaminepass" name="toexaminepass">
                    </div>

                </form>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" onclick="$('#examinform').submit();">提交</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

            </div>
        </div>
    </div>
</div>



<!--/********************************审核员设置***************************************/-->


<div class="modal fade bs-example-modal-sm2" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"  >审核员设置</h4>

            </div>

            <div class="modal-body">
                <form action="<?php echo U('Admin/examinpasschg');?>" method="post" id="examinsettingform">
                    <div class="form-group">
                        <label for="toexaminepass" class="control-label">审核原密码:</label>
                        <input type="password" class="form-control"  id="toexaminepass2" name="toexaminepass" required="required">
                    </div>

                    <div class="form-group">
                        <label for="newtoexaminepass" class="control-label">审核新密码:</label>
                        <input type="password" class="form-control" id="newtoexaminepass"  name="newtoexaminepass" required="required">
                    </div>

                    <div class="form-group">
                        <label for="qnewtoexaminepass" class="control-label">审核密码确认:</label>
                        <input type="password" class="form-control" id="qnewtoexaminepass"  name="qnewtoexaminepass" required="required" >
                    </div>
                </form>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" id="examsetting"  >提交</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

            </div>

            <script type="application/javascript">
                $('#examsetting').click(function (e) {
                    e.preventDefault();
                    var toexaminepass2 = $('#toexaminepass2').val();
                    var newtoexaminepass = $('#newtoexaminepass').val();
                    var qnewtoexaminepass = $('#qnewtoexaminepass').val();

                    if (toexaminepass2 != '' && newtoexaminepass != '' && qnewtoexaminepass != ''){
                        if($.trim(newtoexaminepass) !== $.trim(qnewtoexaminepass)){
                            layer.msg("新旧审核密码不同");
                        }else{
                            $('#examinsettingform').submit();
                        }
                    }else{
                        layer.msg("有选项没有填写");
                    }
                });
            </script>
        </div>
    </div>
</div>

<div class="container">
    <center><br>
        <h2 style="color: #2D93CA">提现申请表格</h2><br></center>
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post" id="form_do" name="form_do">
                <div class="table-responsive">
                    <table class="table table-hover xyh-table-bordered-out">
                        <thead>
                        <tr class="active">


                            <th>申请编号</th>
                            <th>月份</th>
                            <th>工号</th>
                            <th>申请时间</th>
                            <th>提现金额</th>
                            <th>是否审核</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($allwsm)): foreach($allwsm as $key=>$v): ?><tr>

                                <td><?php echo ($v["wsid"]); ?></td>
                                <td><?php echo ($v["month"]); ?></td>
                                <td><?php echo ($v["seid"]); ?></td>
                                <td><?php echo (date("Y-m-d h:i:s",$v["wstime"])); ?></td>
                                <td><?php echo ($v["wsmoney"]); ?></td>
                                <!--<td><?php echo ($v["issettel"]); ?></td>-->
                                <td>
                                    <?php if(($v['issettel'] == 1) ): ?><span class="label label-success">已审核</span>
                                        <?php else: ?>
                                        <a href="javascript:;"   class="label label-warning wss" wsid="<?php echo ($v["wsid"]); ?>">待审核</a><?php endif; ?>
                                    <a href="javascript:;" onclick="toConfirm('<?php echo U('Withdrawalsmsg/delws',array('wsid'=>$v['wsid']));?>','你确定要删除？')" class="label label-danger">删除</a>

                                </td>


                            </tr><?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>

            
            <script>
                $(function () {
                    $('.wss').click(function (e) {
                        var self =$(this);
                        var selfparent = self.parent('td');
                        e.preventDefault();
                        if(confirm('你真的要通过这次提现的审核吗？')){
                            $.ajax({
                                url:"<?php echo U('Withdrawalsmsg/wssettel');?>",
                                type:"POST",
                                data:"wsid="+self.attr('wsid'),
                                success:function (data) {
                                    console.log(data);
                                    if(parseInt(data) == 1){
                                        layer.msg("操作成功");
                                        self.parent('td').children(':first').remove();
                                        selfparent.prepend('<span class="label label-success">已审核</span>');
                                    }else {
                                        layer.msg("操作失败（检查审核金额是否过大）");
                                    }
                                }

                            })
                        }
                    });

                })
            </script>

            <div class="wypage">

                <nav>
                    <ul class="pagination">
                        <li><a href="<?php echo U('Withdrawalsmsg/wsdeelwith',array('nowpage'=> 1 ) );?>"> 首页 </a></li>
                        <?php if($nowpage != 1): ?><li><a href="<?php echo U('Withdrawalsmsg/wsdeelwith',array('nowpage'=> $nowpage-1 ) );?>">&laquo;</a></li>
                            <?php else: ?>
                            <li class="disabled"><a
                                    href="<?php echo U('Withdrawalsmsg/wsdeelwith',array('nowpage'=> $nowpage-1 ) );?>">&laquo;</a></li><?php endif; ?>
                        <!--<li class="active"> <span >1</span></li>-->

                        <?php $__FOR_START_27277__=1;$__FOR_END_27277__=$pagecount+1;for($i=$__FOR_START_27277__;$i < $__FOR_END_27277__;$i+=1){ if($i == $nowpage): ?><li class="active"><span><?php echo ($i); ?></span></li>
                                <?php else: ?>
                                <li><a href="<?php echo U('Withdrawalsmsg/wsdeelwith',array('nowpage'=> $i ) );?>"><?php echo ($i); ?></a></li><?php endif; } ?>

                        <?php if($nowpage != $pagecount): ?><li><a href="<?php echo U('Withdrawalsmsg/wsdeelwith',array('nowpage'=> $nowpage+1 ) );?>">&raquo;</a></li>
                            <?php else: ?>
                            <li class="disabled"><a
                                    href="<?php echo U('Withdrawalsmsg/wsdeelwith',array('nowpage'=> $nowpage+1 ) );?>">&raquo;</a></li><?php endif; ?>
                        <li><a href="<?php echo U('Withdrawalsmsg/wsdeelwith',array('nowpage'=> $pagecount ) );?>"> 末页 </a></li>

                        <li><span> 共<?php echo ($allnum); ?>条数据，共<?php echo ($pagecount); ?>页 ,现在第 <?php echo ($nowpage); ?>页</span></li>
                    </ul>

                </nav>

            </div>


        </div>
    </div>
</div>

    <meta charset="UTF-8">




    <div class="footer">
       <!-- <center class="join-in">
            <div class="container"><img src="/wywlsale/Application/Wanyu/View/public/images/join-in.png" class="img-responsive"></div>
        </center>-->
        <div class="container">
            <p class="hidden-xs">Compensation Plan Policies and Procedures Terms and Conditions</p>
            <p> Copyright © 2015-2020 &nbsp;&nbsp; 分销系统 All rights reserved.</p>
        </div>
    </div>



</body>
</html>