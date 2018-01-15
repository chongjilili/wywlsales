<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>分销系统-后台管理系统</title>
    
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
    <script src="/wywlsale/Application/Wanyu/View/public/js/promag.js" type="text/javascript"></script>
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
<div class="wymain">
    <h3 class="wymain_title" style="text-align: center"><?php echo ($title); ?> </h3>
    

    <!--pc端-->
    <div class="proadd hidden-xs ">

        <div class="col-sm-4  col-xs-2  column ">
            <div class="btn-group btn-group-md">

                <button class="btn btn-primary  hidden-xs  " type="button" onclick="goUrl('<?php echo U('Promag/proadd');?>')"><em
                        class="glyphicon glyphicon-plus-sign"></em> 添加商品
                </button>


            </div>

        </div>
        <div class="col-sm-8   col-xs-10 ">
            <form class="form-inline topfrom  " role="form" method="post" action="<?php echo U('Promag/searchpro');?>"
                  id="searform">

                <label class="sr-only" for="searpro">搜索商品:</label>

                    <input type="text" class="form-control" id="searpro" placeholder="商品名称" name="searpro">

                <button type="submit" class="btn btn-primary" id="searprobtn">搜索商品</button>


            </form>
        </div>
    </div>


    <!--移动端-->
      <div class="visible-xs-block">

     <button class="btn btn-primary " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
         添加一个商品
     </button>
     <div class="collapse " id="collapseExample">
         <div class="well">
             <form class="form-inline topfrom tf1" role="form" method="post" action="<?php echo U('Promag/doproadd');?>" id="apform">
                 <div class="form-group">
                     <label   for="pname">添加一个商品:</label>

                     <input type="text" class="form-control" id="pname" placeholder="商品名字" name="pname">

                     <label   for="price">商品价格：</label>
                     <input type="text" class="form-control" id="price" placeholder="价格" name="price">
                     <label   for="pprice">商品pv价格：</label>


                         <select name="pprice" class="form-control"  id="pprice"   >
                             <option value="375">375</option>
                             <option value="3750"  > 3750</option>
                             <option value="7500"  >7500</option>

                         </select>

                      <br>
                     <button type="submit" class="btn btn-primary" id="addprobtn">添加商品</button>
                 </div>

             </form>
             <div style="clear: both;"></div>
         </div>
     </div>

     <form class="form-inline topfrom tf2  " style="margin: 10px 0;" role="form" method="post" action="<?php echo U('Promag/searchpro');?>" id="searform">
         <div class="form-group">
             <label  class="sr-only" for="searpro">搜索商品:</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" id="searpro" placeholder="商品名称" name="searpro">
            </div>
             <button type="submit" class="btn btn-primary col-xs-6" id="searprobtn">搜索商品</button>
         </div>

     </form>

     </div>


    <div class="prolist">
        <table class="table table-bordered table-hover ">
            <tr id="pthead">
                <td>编号</td>
                <td>产品名称</td>
                <td>原价格</td>
                <td>pv值</td>

                <td>操作</td>
            </tr>

            <?php if(is_array($prolist)): $i = 0; $__LIST__ = $prolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><tr>
                    <td style="width: 15%"><?php echo ($p["pid"]); ?></td>
                    <td style="width: 15%"><?php echo ($p["pname"]); ?></td>
                    <td style="width: 15%">￥<?php echo ($p["price"]); ?></td>
                    <td style="width: 15%">￥<?php echo ($p["pprice"]); ?></td>
                    <td style="width: 25%">


                        <a href="<?php echo U('Promag/editpro',array('pid'=> $p['pid'] ) );?>" class=" label label-success">修改</a>

                        <a href="#" pid="<?php echo ($p["pid"]); ?>" class=" delpro label label-danger">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>


        </table>

    </div>

    
    <div class="wypage">

        <nav>
            <ul class="pagination">
                <li><a href="<?php echo U('Promag/index',array('nowpage'=> 1 ) );?>"> 首页 </a></li>
                <?php if($nowpage != 1): ?><li><a href="<?php echo U('Promag/index',array('nowpage'=> $nowpage-1 ) );?>" title="上一页"  >&laquo;</a></li>
                    <?php else: ?>
                    <li class="disabled"><a href="<?php echo U('Promag/index',array('nowpage'=> $nowpage-1 ) );?>">&laquo;</a></li><?php endif; ?>


                <?php $__FOR_START_7251__=advoidnegative($nowpage-3);$__FOR_END_7251__=advoidTranscend($nowpage+3,$pagecount+1);for($i=$__FOR_START_7251__;$i < $__FOR_END_7251__;$i+=1){ if($i == $nowpage): ?><li class="active"><span><?php echo ($i); ?></span></li>
                        <?php else: ?>
                        <li><a href="<?php echo U('Promag/index',array('nowpage'=> $i ) );?>"><?php echo ($i); ?></a></li><?php endif; } ?>

                <?php if($nowpage != $pagecount): ?><li><a href="<?php echo U('Promag/index',array('nowpage'=> $nowpage+1 ) );?>" title="下一页"  >&raquo;</a></li>
                    <?php else: ?>
                    <li class="disabled"><a href="<?php echo U('Promag/index',array('nowpage'=> $nowpage+1 ) );?>">&raquo;</a></li><?php endif; ?>
                <li><a href="<?php echo U('Promag/index',array('nowpage'=> $pagecount ) );?>"> 末页 </a></li>

                <li><span> 共<?php echo ($allnum); ?>条数据，共<?php echo ($pagecount); ?>页 ,现在第 <?php echo ($nowpage); ?>页</span></li>
            </ul>

        </nav>

    </div>


    <script type="text/javascript">
        $(function () {
            $('.delpro').click(function (e) {
                var self = $(this);
                e.preventDefault();
                if (confirm("你确定要删除")) {
                    $.ajax({
                        url: "<?php echo U('Promag/delpro' );?>",
                        type: "POST",
                        data: "pid=" + self.attr('pid'),
                        success: function (data) {
                            if (parseInt(data) == 1) {
                                layer.msg("删除成功");
                                window.location.reload();
                            } else {
                                layer.msg("删除失败");
                            }
                        }
                    })
                }
            })
        })
    </script>

</div>
</body>
</html>