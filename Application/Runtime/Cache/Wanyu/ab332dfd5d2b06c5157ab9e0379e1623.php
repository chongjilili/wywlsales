<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo ($title); ?> 管理系统</title>
    
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
</head>
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
        <h1 style="color: #2D93CA">订单列表</h1><br></center>
    <div class="row">


            <div class="row marbottom">

                <div class="col-sm-12 ">

                    <form   method="post" action="<?php echo U('orderlist');?>" id="osform">
                        <div class="row">
                            <label class="sr-only"  >订单号</label>
                            <div class="col-xs-2">
                                <input type="text" class="form-control  " name="orderid"   placeholder="订单号" value="<?php echo ($where["orderid"]); ?>">
                            </div>

                            <label class="sr-only"  >代理工号</label>
                            <div class="col-xs-2">
                                <input type="text" class="form-control  " name="seid"   placeholder="代理工号" value="<?php echo ($where["seid"]); ?>">
                            </div>

                            <label class="sr-only"  >该工号当月的全部直推订单</label>
                            <div class="col-xs-3">
                                <input type="text" class="form-control  " name="serverofseid"   placeholder="该工号当月的全部直推订单" value="<?php echo ($where["serverofseid"]); ?>">
                            </div>


                            <label class="sr-only"  >订单审核情况</label>
                            <div class="col-xs-2">
                                <select name="ispass" class="form-control"       >
                                    <option value="2"   >请选择订单审核情况</option>
                                    <option value="0" <?php if($where['ispass'] === '0' ): ?>selected="selected"<?php endif; ?>  >未审核</option>
                                    <option value="1" <?php if($where['ispass'] == 1 ): ?>selected="selected"<?php endif; ?> >已审核</option>
                                    <option value="2"<?php if($where['ispass'] === '' ): ?>selected="selected"<?php endif; ?> >全部</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-default col-xs-2">搜索</button>
                        </div>

                    </form>

                </div>
            </div>



        <div class="prolist">
            <form id="olform">
                <table class="table table-bordered table-hover ">
                    <tr id="pthead">
                        <td style="width: 3%">
                            选择
                            <input type="checkbox" id="qx" onClick="if(this.checked==true) { checkAll('oids[]'); } else { clearAll('oids[]'); }"  />
                        </td>
                        <td style="width: 7%">订单号</td>
                        <td style="width: 7%">产品名称</td>
                        <td style="width: 7%">代理工号</td>
                        <td style="width: 7%">总价格</td>
                        <td style="width: 7%">pv值</td>
                        <td style="width: 7%">下单时间</td>
                        <td style="width: 8%">操作</td>


                    </tr>

                    <?php if(is_array($orderlist)): $i = 0; $__LIST__ = $orderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$od): $mod = ($i % 2 );++$i;?><tr >
                            <td><input type="checkbox" name="oids[]" value="<?php echo ($od["orderid"]); ?>" <?php if($od["ispass"] == 1): ?>disabled="disabled"<?php endif; ?> ></td>
                            <td><?php echo (getorder_sn($od["orderid"])); ?> </td>

                            <td><?php echo ($od["pname"]); ?></td>
                            <td><?php echo ($od["seid"]); ?></td>
                            <td><?php echo ($od["finalprice"]); ?></td>
                            <td><?php echo ($od["finalpprice"]); ?></td>

                            <td class="hidden-xs"><?php echo (date("Y-m-d H:i:s",$od["otime"])); ?></td>
                            <td class="visible-xs-block"><?php echo (date("m-d H:i",$od["otime"])); ?></td>


                            <td>
                                <?php if(session('toexaminepass')): if($od["ispass"] == 1): ?><a href="#" oid="<?php echo ($od["orderid"]); ?>" class="orderpass label label-success" pass="1" >已审核</a>
                                    <?php else: ?>
                                    <a href="#" oid="<?php echo ($od["orderid"]); ?>" class="orderpass label label-warning" pass="0" >未审核</a><?php endif; endif; ?>

                                <?php if($od["ispass"] == 1): ?><span>
                                        <a href="<?php echo U('Order/orderedit',array('oid' => $od['orderid']) );?>" oid="<?php echo ($od["orderid"]); ?>" class="label label-info"   >编辑</a>
                                        <span oid="<?php echo ($od["orderid"]); ?>" class=" label label-default   ">删除</span>
                                    </span>

                                    <?php else: ?>
                                      <span>
                                        <a href="<?php echo U('Order/orderedit',array('oid' => $od['orderid']) );?>" oid="<?php echo ($od["orderid"]); ?>" class="label label-info"   >编辑</a>
                                        <a href="#" oid="<?php echo ($od["orderid"]); ?>" class="orderdel label label-danger">删除</a>
                                      </span><?php endif; ?>
                            </td>


                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>




                </table>
                <button class="btn btn-primary" type="button" id="olbtn">批量删除</button>
                <a href="<?php echo U('Order/orderadd');?>" class="btn btn-primary"  >添加订单</a>
            </form>
        </div>

        
        <div class="wypage">

            <nav>
                <ul class="pagination">
                    <li><a href="<?php echo U('Order/orderlist',array('nowpage'=> 1 ) );?>">  首页 </a></li>
                    <?php if($nowpage != 1): ?><li  ><a href="<?php echo U('Order/orderlist',array('nowpage'=> $nowpage-1 ) );?>" title="上一页" >&laquo;</a></li>
                        <?php else: ?>
                        <li class="disabled"><a href="<?php echo U('Order/orderlist',array('nowpage'=> $nowpage-1 ) );?>">&laquo;</a></li><?php endif; ?>
                    <!--<li class="active"> <span >1</span></li>-->

                    <?php $__FOR_START_1090__=advoidnegative($nowpage-3);$__FOR_END_1090__=advoidTranscend($nowpage+3,$pagecount+1);for($i=$__FOR_START_1090__;$i < $__FOR_END_1090__;$i+=1){ if($i == $nowpage): ?><li class="active"> <span ><?php echo ($i); ?></span></li>
                            <?php else: ?>
                            <li><a href="<?php echo U('Order/orderlist',array('nowpage'=> $i ) );?>"><?php echo ($i); ?></a></li><?php endif; } ?>

                    <?php if($nowpage != $pagecount): ?><li><a href="<?php echo U('Order/orderlist',array('nowpage'=> $nowpage+1 ) );?>" title="下一页" >&raquo;</a></li>
                        <?php else: ?>
                        <li class="disabled"><a href="<?php echo U('Order/orderlist',array('nowpage'=> $nowpage+1 ) );?>">&raquo;</a></li><?php endif; ?>
                    <li><a href="<?php echo U('Order/orderlist',array('nowpage'=> $pagecount ) );?>">  末页 </a></li>

                    <li><span > 共<?php echo ($allnum); ?>条数据，共<?php echo ($pagecount); ?>页 ,现在第 <?php echo ($nowpage); ?>页</span></li>
                </ul>

            </nav>

        </div>
    </div>
    <script>
        /*
         * 全选函数
         * */
        function checkAll(name) {
            var el = document.getElementsByTagName('input');
            var len = el.length;
            for(var i=0; i<len; i++){
                if((el[i].type=="checkbox") && (el[i].name==name)){
                    el[i].checked = true;
                }
            }
        }

        /*
         * 全不选函数
         * */
        function clearAll(name) {
            var el = document.getElementsByTagName('input');
            var len = el.length;
            for(var i=0; i<len; i++){
                if((el[i].type=="checkbox") && (el[i].name==name)){
                    el[i].checked = false;
                }
            }

        }

    </script>
    <script>
        $(function () {

            /*删除一个*/
            $('.orderdel').click(function (e) {
                var self =$(this);
                e.preventDefault();
                if(confirm('你真的要删除这个订单吗？')){
                    $.ajax({
                        url:"<?php echo U('Order/orderdel');?>",
                        type:"POST",
                        data:"orderid="+self.attr('oid'),
                        success:function (data) {
                            console.log(data);
                            if(parseInt(data) == 1){
                                layer.msg("删除成功");
                                location.reload();
                            }else {
                                layer.msg("删除失败");
                            }
                        }

                    })
                }

            });

            /*批量删除多个*/

            $('#olbtn').click(function (e) {
                e.preventDefault();
                if(confirm("你真的要删除这些订单吗？")){
                    $.ajax({
                        url:"<?php echo U('Order/ordermanydel');?>",
                        type:"POST",
                        data:$('#olform').serialize(),
                        success:function (data) {
                            console.log(data);
                            if(parseInt(data) == 1){
                                layer.msg("批量删除成功");
                                location.reload();
                            }else {
                                layer.msg("删除失败");
                            }
                        }

                    })
                }
            })


            $('.orderpass').click(function (e) {
                e.preventDefault();
                var that = $(this);
                var oid = $(this).attr('oid');
                var pass = $(this).attr('pass');
                if (pass === '1'){
                    if(confirm("你确定要取消这订单的审核吗？")){
                        $.ajax({
                            url:"<?php echo U('Order/ordertogglepass');?>",
                            type:"POST",
                            data:{
                                "oid" :   oid,
                                "pass" :  pass
                            },
                            success:function (data) {
                                console.log(data);
                                if (data == "0" ){
                                    var orderid = that.attr('oid');
                                    layer.msg("修改成功");
                                    that.attr('pass',0).removeClass('label-success')
                                            .addClass('label-warning')
                                            .text('未审核');
                                    that.siblings('span')
                                            .html(' <a href="/wywlsale/index.php/Order/orderedit/oid/'+orderid+'" oid="'+orderid+'" class="label label-info"   >编辑</a>'+
                                    '<a href="#" oid="'+orderid+'" class="orderdel label label-danger">删除</a> ');
                                    that.parents('tr').children('td:first').find('input').removeAttr('disabled');


                                }else {
                                    layer.msg(data);
                                }
                            }

                        })
                    }
                }else {
                    if(confirm("你确定要通过这订单的审核吗？")){
                        $.ajax({
                            url:"<?php echo U('Order/ordertogglepass');?>",
                            type:"POST",
                            data:{
                                "oid" :   oid,
                                "pass" :  pass
                            },
                            success:function (data) {
                                console.log(data);
                                if (data == "1" ){
                                    var orderid = that.attr('oid');
                                    layer.msg("修改成功");
                                    that.attr('pass',1).removeClass('label-warning')
                                            .addClass('label-success')
                                            .text('已审核');
                                    that.siblings('span')
                                            .html(' <a href="/wywlsale/index.php/Order/orderedit/oid/'+orderid+'" oid="'+orderid+'" class="label label-info"   >编辑</a>'+
                                                    '<span class=" label label-default   ">删除</span>');
                                    that.parents('tr').children('td:first').find('input').attr('disabled','disabled');

                                }else {
                                    layer.msg(data);
                                }
                            }

                        })
                    }
                }




            });


           $('.wypage').find('a').click(function (e) {
               e.preventDefault();
               var href = $(this).attr('href');
               var formparam = $('#osform').serialize();
               console.log(formparam);
//               formparam = formparam.replace(/&/g,'/').replace(/=/g,'/');
               href+='/search/1';
//               console.log(formparam);
               href+=('?'+formparam);
               //alert(href);
               goUrl(href);
           })









        })


    </script>



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