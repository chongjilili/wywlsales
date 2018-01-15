<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <script type="application/javascript">
        $(function () {
            /*导出使用的*/

            /* .show-num 的导出Excel 的操作函数*/
            function shownumexcel(t) {
                //遍历所有有tips的td
                var that = $(t);//传入的td对象
                var atips = that.find('a');
//                console.log(atips);
                var dataputong = atips.attr('data-putong');
                var datagold = atips.attr('data-gold');
                var datayin = atips.attr('data-yin');
                var addgold = atips.attr('add-gold');
                var addyin = atips.attr('add-yin');
                var addputong = atips.attr('add-putong');

                if (dataputong == '') {
                    dataputong = '无';
                }
                if (datagold == '') {
                    datagold = '无';
                }
                if (datayin == '') {
                    datayin = '无';
                }

                //获得tips的内容
                var tipshtml =   '<br>'+'普通代理编号：' +dataputong + '<br>'+ '银牌代理编号：'+ datayin+ '<br>' +'金牌代理编号：' + datagold+ '<br>'
                        + '本月新增普通代理数目：' + addputong + '<br>' + '本月新增银牌代理数目：' + addyin + '<br>' + '本月新增金牌代理数目：' + addgold;
//                console.log(tipshtml);
                that.html(that.html()+'<br>详细内容 ：'+tipshtml);
            }


            /*导出使用的*/
            $('.downloadexcel').click(function () {
                var tid =  $(this).parents('.downloadexceldiv').attr('dl');//父级元素的id
                var table = $('#'+tid).find('table');//获得导出的Excel表
                var hs = $(this).attr('hs');//获得操作的函数名字
                /*
                 * 获得html 对html转换为jq对象进行操作，操作完才变回html字符串，不影响原来页面的html
                 * */
                var tablehtml = table.get(0).outerHTML;
                tablehtml = $(tablehtml);//转换成jq对象
                var tds = tablehtml.find('.showtd');//获得所有的showtd的td
                console.log(tds);

                // tds存在才操作
//                console.log(tds + 'yes2');
                switch (hs){
                    case 'shownumexcel' : {
                        tds.each(function (i,t) {
                            shownumexcel(this);
                        });
                        break;
                    }

                    default :break;

                }



                tablehtml.find('td').css('border','1px solid #000000');
                tablehtml.find('th').css('border','1px solid #000000');
                tablehtml =tablehtml.get(0).outerHTML;



                console.log(tablehtml);
                post("<?php echo U('Public/downloadexcel');?>", {'tablehtml' :tablehtml,'tid':tid});//模拟订单提交
//
            });
        })

    </script>

<div class="container">
    <center><br>
        <h1 style="color: #2D93CA">首页</h1><br></center>
    <div class="row">


        <div class="col-xs-12 col-md-6 downloadexceldiv" dl="monthprofit" >
            <div class="panel-heading">
                <h2>公司业绩(近半年)<i class="hidden-xs"> Corporate Performance</i>
                    <button type="button" class="btn btn-info downloadexcel"    >导出</button>
                </h2>
            </div>
            <div class="allowTextWrap">
                <table class="table bouns-table format fixedlayout">
                    <thead>
                    <tr>
                        <th width="25%">月份</th>
                        <th width="25%">总业绩</th>
                        <th width="25%">总pv值</th>
                        <th width="25%">总分红支出</th>
                        <th width="25%">总净利润</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($allMonthperformance)): $i = 0; $__LIST__ = array_slice($allMonthperformance,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$profit): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($profit["monthstr"]); ?></td>
                            <td><?php echo ($profit["allprice"]); ?></td>
                            <td><?php echo ($profit["allpv"]); ?></td>
                            <td><?php echo ($profit["bonusofallpeople"]); ?></td>
                            <td><?php echo ($profit["netprofit"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <tr>
                        <td>近半年</td>
                        <td><?php echo ($sixMonthperformance["allprice"]); ?></td>
                        <td><?php echo ($sixMonthperformance["allpv"]); ?></td>
                        <td><?php echo ($sixMonthperformance["bonusofallpeople"]); ?></td>
                        <td><?php echo ($sixMonthperformance["netprofit"]); ?></td>
                    </tr>

                    <tr >
                        <td colspan="5" align="center" class="profitmore" style="text-align: center;color: #2aabd2;font-size: 18px;border-top: 1px solid #FBFBFB;cursor: Pointer;">
                            <sapn >更 多</sapn>
                        </td>

                    </tr>
                    </tbody >
                </table>

            </div>
        </div>



        <div class="col-xs-12 col-md-6 downloadexceldiv"  dl="teammsg" >
            <div class="panel-heading">
                <h2>团队资讯<i class="hidden-xs"> Team information</i>
                    <button type="button" class="btn btn-info downloadexcel"   hs="shownumexcel"  >导出</button>
                </h2>

            </div>
            <div class="allowTextWrap">
                <div class="box">
                    <table class="table bouns-table fixedlayout">
                        <thead>
                        <tr>
                            <th width="30%">行数</th>
                            <th width="23%">直推人数</th>
                            <th width="23%">间接人数</th>
                            <th>总人数</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($layerdetailmsg)): $level = 0; $__LIST__ = array_slice($layerdetailmsg,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lmsg): $mod = ($level % 2 );++$level;?><tr>
                                <td>第<?php echo ($level); ?>行</td>
                                <td><a href="javascript:;" class="show-num" data-putong="<?php echo (implode(',',$lmsg["dir"]["普通代理"])); ?>" data-gold="<?php echo (implode(',',$lmsg["dir"]["金牌代理"])); ?>"
                                       data-yin="<?php echo (implode(',',$lmsg["dir"]["银牌代理"])); ?>" add-gold="<?php echo ($lmsg["dir"]["newjinnum"]); ?>"
                                       add-yin="<?php echo ($lmsg["dir"]["newyinnum"]); ?>" add-putong="<?php echo ($lmsg["dir"]["newputongnum"]); ?>" ><?php echo ($lmsg["dirnum"]); ?></a></td>
                                <td><a href="javascript:;" class="show-num" data-putong="<?php echo (implode(',',$lmsg["indir"]["普通代理"])); ?>" data-gold="<?php echo (implode(',',$lmsg["indir"]["金牌代理"])); ?>"
                                       data-yin="<?php echo (implode(',',$lmsg["indir"]["银牌代理"])); ?>" add-gold="<?php echo ($lmsg["indir"]["newjinnum"]); ?>"
                                       add-yin="<?php echo ($lmsg["indir"]["newyinnum"]); ?>" add-putong="<?php echo ($lmsg["indir"]["newputongnum"]); ?>" ><?php echo ($lmsg["indirnum"]); ?></a></td>
                                <td><?php echo ($lmsg["allnum"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr >
                            <td colspan="4"   class="levelmore" style="color: #2aabd2;font-size: 18px;border-top: 1px solid #FBFBFB;cursor: Pointer;text-align: center;">
                                <sapn >更 多</sapn>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!---->


    </div>

    <div class="row">


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



    <script>
        $(function () {
            $('.show-num').hover(function () {
                var that = this;
                var dataputong = $(this).attr('data-putong');
                var datagold = $(this).attr('data-gold');
                var datayin = $(this).attr('data-yin');
                var addgold = $(this).attr('add-gold');
                var addyin = $(this).attr('add-yin');
                var addputong = $(this).attr('add-putong');

                if (dataputong == '') {
                    dataputong = '无';
                }
                if (datagold == '') {
                    datagold = '无';
                }
                if (datayin == '') {
                    datayin = '无';
                }

                var html =  '<p style="width: 150px;word-wrap:break-word; word-break:normal;line-height: 14px">'+'普通代理编号：' +dataputong+'</p>'  +'<p style="width: 150px;word-wrap:break-word; word-break:normal;line-height: 14px">'+ '银牌代理编号：'+ datayin+'</p>' + '<p style="width: 110px;word-wrap:break-word; word-break:normal;line-height: 14px">'+ '金牌代理编号：' + datagold +'</p>'
                        + '本月新增普通代理数目：' + addputong + '<br>' + '本月新增银牌代理数目：' + addyin + '<br>' + '本月新增金牌代理数目：' + addgold;
                layer.tips(html, that);
            }, function () {

            });


            $('.levelmore').click(function () {
                layer.open({
                    type: 1,
                    title: '代理团队信息',
                    skin: 'layui-layer-rim', //加上边框
                    area: ['100%', '90%'], //宽高
                    content: $('#teammsg')
                });
            });

            $('.profitmore').click(function () {
                layer.open({
                    type: 1,
                    title: '公司业绩(近半年)',
                    skin: 'layui-layer-rim', //加上边框
                    area: ['100%', '90%'], //宽高
                    content: $('#monthprofit')
                });
            });



        })
    </script>

</body>

</html>
<div style="height: 0;overflow: hidden;">
    <div class="col-xs-12 col-md-6 col-md-offset-3" id="teammsg" style="display: block;">
        <div class="panel-heading">
            <h2>团队资讯<i class="hidden-xs"> Team information</i></h2>
        </div>
        <div class="allowTextWrap">
            <div class="box">
                <table class="table bouns-table fixedlayout">
                    <thead>
                    <tr>
                        <th width="30%">行数</th>
                        <th width="23%">直推人数</th>
                        <th width="23%">间接人数</th>
                        <th>总人数</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($layerdetailmsg)): $level = 0; $__LIST__ = $layerdetailmsg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lmsg): $mod = ($level % 2 );++$level;?><tr>
                            <td>第<?php echo ($level); ?>行</td>
                            <td class="showtd"><a href="javascript:;" class="show-num" data-putong="<?php echo (implode(',',$lmsg["dir"]["普通代理"])); ?>" data-gold="<?php echo (implode(',',$lmsg["dir"]["金牌代理"])); ?>"
                                   data-yin="<?php echo (implode(',',$lmsg["dir"]["银牌代理"])); ?>" add-gold="<?php echo ($lmsg["dir"]["newjinnum"]); ?>"
                                   add-yin="<?php echo ($lmsg["dir"]["newyinnum"]); ?>" add-putong="<?php echo ($lmsg["dir"]["newputongnum"]); ?>" ><?php echo ($lmsg["dirnum"]); ?></a></td>
                            <td class="showtd"><a href="javascript:;" class="show-num" data-putong="<?php echo (implode(',',$lmsg["indir"]["普通代理"])); ?>" data-gold="<?php echo (implode(',',$lmsg["indir"]["金牌代理"])); ?>"
                                   data-yin="<?php echo (implode(',',$lmsg["indir"]["银牌代理"])); ?>" add-gold="<?php echo ($lmsg["indir"]["newjinnum"]); ?>"
                                   add-yin="<?php echo ($lmsg["indir"]["newyinnum"]); ?>" add-putong="<?php echo ($lmsg["indir"]["newputongnum"]); ?>" ><?php echo ($lmsg["indirnum"]); ?></a></td>
                            <td><?php echo ($lmsg["allnum"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-xs-12 col-md-6 col-md-offset-3" id="monthprofit">
        <div class="panel-heading">
            <h2>公司业绩(近半年)<i class="hidden-xs"> Corporate Performance</i>

            </h2>
        </div>
        <div class="allowTextWrap">
            <table class="table bouns-table format fixedlayout">
                <thead>
                <tr>
                    <th width="25%">月份</th>
                    <th width="25%">总业绩</th>
                    <th width="25%">总pv值</th>
                    <th width="25%">总分红支出</th>
                    <th width="25%">总净利润</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($allMonthperformance)): $i = 0; $__LIST__ = $allMonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$profit): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($profit["monthstr"]); ?></td>
                        <td><?php echo ($profit["allprice"]); ?></td>
                        <td><?php echo ($profit["allpv"]); ?></td>
                        <td><?php echo ($profit["bonusofallpeople"]); ?></td>
                        <td><?php echo ($profit["netprofit"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                <tr>
                    <td>总业绩（历史以来）</td>
                    <td><?php echo ($performance["allprice"]); ?></td>
                    <td><?php echo ($performance["allpv"]); ?></td>
                    <td><?php echo ($performance["bonusofallpeople"]); ?></td>
                    <td><?php echo ($performance["netprofit"]); ?></td>
                </tr>

                </tbody >
            </table>

        </div>
    </div>
</div>