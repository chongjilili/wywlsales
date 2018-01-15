<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1"/>
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

<?php if( session(C('ADMIN_AUTH_KEY')) ) : ?>
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
<?php else: ?>


    <meta charset="UTF-8">


    <div class="top">
        <section></section>
    </div>
    <div id="header" class="container">
        <div class="nowtime hidden-xs">登录时间：<?php echo (session('wy_logintime')); ?></div>
        <div class="welcome">
            <span>Welcome,<b><?php echo (session('wy_username')); ?></b>
              <?php if(session('usertype') == 1): ?>普通代理
            <?php elseif(session('usertype') == 2): ?>
                 银牌代理
            <?php elseif(session('usertype') == 3): ?>
                金牌代理
            <?php elseif(session('usertype') == 9): ?>
                公司管理员<?php endif; ?>
                <a href="<?php echo U('Login/logout');?>" target="_parent" class="hidden-xs" onclick="return confirm('你真的要退出登录吗？')">
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
                    <li><a href="/wywlsale/index.php?s= " <?php if($active == 1): ?>class="active"<?php endif; ?> >首页</a></li>
                    <li><a href="<?php echo U('Achievement/index',array('adminid'=> session('adminid') ) );?>" <?php if($active == 2): ?>class="active"<?php endif; ?> >业绩查看</a></li>
                    <li><a href="<?php echo U('Achievement/picture',array('adminid'=> session('adminid') ));?>" <?php if($active == 3): ?>class="active"<?php endif; ?> >组织视图</a></li>
                    <li><a href="<?php echo U('User/index');?>" <?php if($active == 4): ?>class="active"<?php endif; ?> >个人中心</a></li>
                    <li><a href="<?php echo U('Withdrawalsmsg/wsdeelwithofuser');?>" <?php if($active == 7): ?>class="active"<?php endif; ?> >提现记录</a></li>



                    <!--<li class="visible-xs"><a href="javascript:;" class="openOfManager" data-url="changePassword">修改密碼</a>
                    </li>-->
                    <li class="visible-xs"><a href="<?php echo U('Login/logout');?>"  target="_parent" onclick="return confirm('你真的要退出登录吗？')" class="logout">退出</a></li>
                </ul>
            </div>
        </div>
    </nav>

<?php endif; ?>


<script type="application/javascript">
    $(function () {


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
            var addgoldarr = atips.attr('add-goldarr');
            var addyinarr = atips.attr('add-yinarr');
            var addputongarr = atips.attr('add-putongarr');

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
            var tipshtml = '<br>' + '普通代理编号：' + dataputong + '<br>' + '银牌代理编号：' + datayin + '<br>' + '金牌代理编号：' + datagold + '<br>'
                            + '本月新增普通代理编号：' + addputongarr + '<br>' + '本月新增银牌代理编号：' + addyinarr + '<br>' + '本月新增金牌代理编号：' + addgoldarr + '<br>'
                            + '本月新增普通代理数目：' + addputong + '<br>' + '本月新增银牌代理数目：' + addyin + '<br>' + '本月新增金牌代理数目：' + addgold + '<br>'
                    ;
//                console.log(tipshtml);
            that.html(that.html() + '<br>详细内容 ：' + tipshtml);
        }


        /*导出使用的*/
        $('.downloadexcel').click(function () {
            var tid = $(this).parents('.downloadexceldiv').attr('dl');//父级元素的id
            var table = $('#' + tid).find('table');//获得导出的Excel表

            /*
             * 获得html 对html转换为jq对象进行操作，操作完才变回html字符串，不影响原来页面的html
             * */
            var tablehtml = table.get(0).outerHTML;
            tablehtml = $(tablehtml);//转换成jq对象
            var tds = tablehtml.find('.showtd');//获得所有的showtd的td
            console.log(tds);
            tds.each(function (i, t) {
                shownumexcel(this);

            });
            tablehtml.find('td').css('border', '1px solid #000000');
            tablehtml.find('th').css('border', '1px solid #000000');
            tablehtml = tablehtml.get(0).outerHTML;


            console.log(tablehtml);
            post("<?php echo U('Public/downloadexcel');?>", {'tablehtml': tablehtml, 'tid': tid});//模拟订单提交
//
        });
    })

</script>

<div class="container">
    <center><br>
        <h1 style="color: #2D93CA">个人业绩</h1><br></center>
    <div class="row">
        <div class="col-xs-12 col-md-6 downloadexceldiv" dl="Personalinformation">
            <div class="panel-heading">
                <h2>个人信息<i class="hidden-xs"> Personal information</i> <span>
                    <?php if($admin["usertype"] == 1): ?>普通代理
                     <?php elseif($admin["usertype"] == 2): ?>
                        银牌代理
                     <?php elseif($admin["usertype"] == 3): ?>
                        金牌代理<?php endif; ?>

                    &nbsp;编号：<?php echo ($admin["seid"]); ?>&nbsp;&nbsp; </span>
                    <button type="button" class="btn btn-info downloadexcel">导出</button>

                </h2>
            </div>
            <div class="allowTextWrap">
                <table class="table bouns-table format fixedlayout">
                    <thead>
                    <tr>
                        <th width="30.3%">奖金信息</th>
                        <th width="30.3%"><?php echo ($lastmonth); ?>月</th>
                        <th><?php echo ($thismonth); ?>月</th>

                    </tr>
                    </thead>
                    <tbody>



                    <tr>
                        <td>直接开拓pv分红</td>
                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['dirbonkus']) && ($ltmp['dirbonkus'] !== ""))?($ltmp['dirbonkus']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                   <!-- <tr>
                        <td>每月前六分红</td>
                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['encbonus']) && ($ltmp['encbonus'] !== ""))?($ltmp['encbonus']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>-->
                    <tr>
                        <td>间接开拓pv分红</td>

                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['indirbonkus']) && ($ltmp['indirbonkus'] !== ""))?($ltmp['indirbonkus']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                    <tr>
                        <td>金银牌加权分红</td>
                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['averagebonus']) && ($ltmp['averagebonus'] !== ""))?($ltmp['averagebonus']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                    <tr>
                        <td>总pv分红</td>

                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['pvtotal']) && ($ltmp['pvtotal'] !== ""))?($ltmp['pvtotal']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>

                    <tr>
                        <td>实际奖金<!--提现金额最高只可以是总额的80%--></td>
                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['truebonus']) && ($ltmp['truebonus'] !== ""))?($ltmp['truebonus']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                    <tr>
                        <td>已提现奖金</td>

                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['alreadysettlemoney']) && ($ltmp['alreadysettlemoney'] !== ""))?($ltmp['alreadysettlemoney']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                    <tr>
                        <td>可提金额</td>
                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['leftsettlemoney']) && ($ltmp['leftsettlemoney'] !== ""))?($ltmp['leftsettlemoney']):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                    <tr>
                        <td>碧玉豆</td>
                        <?php if(is_array($lasttowmonthperformance)): $i = 0; $__LIST__ = $lasttowmonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ltmp): $mod = ($i % 2 );++$i;?><td><?php echo (round((isset($ltmp['biyudou'] ) && ($ltmp['biyudou'] !== ""))?($ltmp['biyudou'] ):0,2)); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>



                    <td colspan="3" class="Personalinformationmore"
                        style="color: #2aabd2;font-size: 18px;border-top: 1px solid #FBFBFB;cursor: Pointer;text-align: center;">
                        <sapn>更 多</sapn>
                    </td>

                    </tbody>
                </table>
                <table class="table bouns-table bouns-withdrawl format fixedlayout" style="margin-top:20px;">
                    <tbody>
                    <tr>
                        <th colspan="3" style=" vertical-align:middle">提现金额最高只可以是总额的80%，提现金额必须是100的倍数</th>

                    </tr>
                    <tr>
                        <td width="33%" style=" vertical-align:middle">累积总PV值</td>
                        <td width="60%" colspan="2" style=" vertical-align:middle"><b><?php echo (round($pvtotalofallmonth["pvtotalofallmonth"],2)); ?></b>
                        </td>

                    </tr>
                    <tr>
                        <td width="33%" style=" vertical-align:middle">碧玉豆（总PV值20%）</td>
                        <td width="60%" colspan="2" style=" vertical-align:middle"><b><?php echo (round($pvtotalofallmonth["biyudouofallmonth"],2)); ?></b>
                        </td>

                    </tr>
                    <tr>
                        <td width="33%" style=" vertical-align:middle">实际奖金（总PV值80%）</td>
                        <td width="60%" colspan="2" style=" vertical-align:middle"><b><?php echo (round($pvtotalofallmonth["truepvtotalofallmonth"],2)); ?></b>
                        </td>

                    </tr>
                    <tr>
                        <td class="Personalinformationmore" colspan="3" style="text-align: center;"><a
                                href="javascript:;" style="text-align: center;" class="btn btn-default">去提现</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if(session(C('ADMIN_AUTH_KEY'))): ?><div class="col-xs-12 col-md-6 downloadexceldiv " dl="Teaminformation" id="Teaminformation">
            <div class="panel-heading">
                <h2>团队资讯<i class="hidden-xs"> Team information</i>
                    <button type="button" class="btn btn-info downloadexcel">导出</button>
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
                                <td class="showtd" ><a href="javascript:;" class="show-num"
                                       data-putong="<?php echo (implode(',',$lmsg["dir"]["普通代理"])); ?>"
                                       data-gold="<?php echo (implode(',',$lmsg["dir"]["金牌代理"])); ?>"
                                       data-yin="<?php echo (implode(',',$lmsg["dir"]["银牌代理"])); ?>"
                                       add-gold="<?php echo ($lmsg["dir"]["newjinnum"]); ?>"
                                       add-yin="<?php echo ($lmsg["dir"]["newyinnum"]); ?>"
                                       add-putong="<?php echo ($lmsg["dir"]["newputongnum"]); ?>"
                                       add-goldarr="<?php echo ($lmsg["dir"]["newjinarr"]); ?>"
                                       add-yinarr="<?php echo ($lmsg["dir"]["newyinarr"]); ?>"
                                       add-putongarr="<?php echo ($lmsg["dir"]["newputongarr"]); ?>"
                                ><?php echo ($lmsg["dirnum"]); ?></a>
                                </td>
                                <td class="showtd" ><a href="javascript:;" class="show-num"
                                       data-putong="<?php echo (implode(',',$lmsg["indir"]["普通代理"])); ?>"
                                       data-gold="<?php echo (implode(',',$lmsg["indir"]["金牌代理"])); ?>"
                                       data-yin="<?php echo (implode(',',$lmsg["indir"]["银牌代理"])); ?>"
                                       add-gold="<?php echo ($lmsg["indir"]["newjinnum"]); ?>"
                                       add-yin="<?php echo ($lmsg["indir"]["newyinnum"]); ?>"
                                       add-putong="<?php echo ($lmsg["indir"]["newputongnum"]); ?>"
                                       add-goldarr="<?php echo ($lmsg["indir"]["newjinarr"]); ?>"
                                       add-yinarr="<?php echo ($lmsg["indir"]["newyinarr"]); ?>"
                                       add-putongarr="<?php echo ($lmsg["indir"]["newputongarr"]); ?>"
                                ><?php echo ($lmsg["indirnum"]); ?></a>
                                </td>
                                <td><?php echo ($lmsg["allnum"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><?php endif; ?>



        <div class="col-xs-12 col-md-6 downloadexceldiv" dl="Totalperformanceoverview" id="Totalperformanceoverview">
            <div class="panel-heading">
                <h2>业绩总概况<i class="hidden-xs"> Total performance overview </i>
                    <button type="button" class="btn btn-info downloadexcel">导出</button>
                </h2>
            </div>
            <div class="allowTextWrap">
                <div class="box">
                    <table class="table bouns-table fixedlayout">
                        <thead>
                        <tr>
                            <th width="25%">直推人数</th>
                            <th width="25%">直推的人编号</th>
                            <th width="25%">自己的订单数</th>
                            <th width="25%">被推荐人</th>

                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td width="25%"><?php echo ($sao["sidnum"]); ?>(人)</td>
                            <td width="25%"> <?php echo ($sao["serverids"]); ?></td>
                            <td width="25%"> <?php echo ($sao["ordernum"]); ?></td>
                            <td width="25%"><?php echo ($sao["pseid"]); ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <div class="row">



        <div class="col-xs-12 col-md-6 downloadexceldiv" dl="Totalperformanceoverviewofmonth">
            <div class="panel-heading">
                <h2>直推人分月情况<i class="hidden-xs"> Total performance overview of month </i>
                    <button type="button" class="btn btn-info downloadexcel">导出</button>
                </h2>
            </div>
            <div class="allowTextWrap">
                <div class="box">
                    <table class="table bouns-table fixedlayout">
                        <thead>
                        <tr>
                            <th width="33.3%">月份</th>
                            <th width="33.3%">直推的人数量</th>
                            <th width="33.4%">直推的人编号</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($saoofMonth)): $m = 0; $__LIST__ = array_slice($saoofMonth,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sm): $mod = ($m % 2 );++$m;?><tr>
                                <td><?php echo ($key); ?></td>
                                <td><?php echo ($sm["sidnum"]); ?>(人)</td>
                                <td> <?php echo ($sm["serverids"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <td colspan="4" class="Totalperformanceoverviewofmonthmore"
                            style="color: #2aabd2;font-size: 18px;border-top: 1px solid #FBFBFB;cursor: Pointer;text-align: center;">
                            <sapn>更 多</sapn>
                        </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-6 downloadexceldiv" dl="indirperformanceoverviewofmonth"  >
            <div class="panel-heading">
                <h2>间推人分月情况<i class="hidden-xs"> indirect performance overview of month </i>
                    <button type="button" class="btn btn-info downloadexcel">导出</button>
                </h2>
            </div>
            <div class="allowTextWrap">
                <div class="box">
                    <table class="table bouns-table fixedlayout">
                        <thead>
                        <tr>
                            <th width="33.3%">月份</th>
                            <th width="33.3%">间推的人数量</th>
                            <th width="33.4%">间推的人编号</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($indirseidofmonth)): $i = 0; $__LIST__ = array_slice($indirseidofmonth,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$idrsm): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($key); ?></td>
                                <td><?php echo (count($idrsm)); ?>(人)</td>
                                <td>
                                    <?php if(empty($idrsm) ): ?>无
                                        <?php else: ?>
                                        <?php echo (implode(',',$idrsm)); endif; ?>

                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <td colspan="4" class="indirperformanceoverviewofmonth"
                            style="color: #2aabd2;font-size: 18px;border-top: 1px solid #FBFBFB;cursor: Pointer;text-align: center;">
                            <sapn>更 多</sapn>
                        </td>
                        </tbody>
                    </table>
                </div>
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
            var addgoldarr = $(this).attr('add-goldarr');
            var addyinarr = $(this).attr('add-yinarr');
            var addputongarr = $(this).attr('add-putongarr');
            if (dataputong == '') {
                dataputong = '无';
            }
            if (datagold == '') {
                datagold = '无';
            }
            if (datayin == '') {
                datayin = '无';
            }

            var html =
                    '<p style="width: 150px;word-wrap:break-word; word-break:normal;line-height: 14px">' + '普通代理编号：' + dataputong + '</p>' + '<p style="width: 150px;word-wrap:break-word; word-break:normal;line-height: 14px">' + '银牌代理编号：' + datayin + '</p>' + '<p style="width: 110px;word-wrap:break-word; word-break:normal;line-height: 14px">' + '金牌代理编号：' + datagold + '</p>'
                    + '<p style="width: 150px;word-wrap:break-word; word-break:normal;line-height: 14px">' + '本月新增普通代理编号：' + addputongarr + '</p>' + '<p style="width: 150px;word-wrap:break-word; word-break:normal;line-height: 14px">' + '本月新增银牌代理编号：' + addyinarr + '</p>' + '<p style="width: 110px;word-wrap:break-word; word-break:normal;line-height: 14px">' + '本月新增金牌代理编号：' + addgoldarr + '</p>'
                    + '本月新增普通代理数目：' + addputong + '<br>' + '本月新增银牌代理数目：' + addyin + '<br>' + '本月新增金牌代理数目：' + addgold;
            layer.tips(html, that);
        }, function () {

        });


        $('.Totalperformanceoverviewofmonthmore').click(function () {
            layer.open({
                type: 1,
                title: '直推人分月情况',
                skin: 'layui-layer-rim', //加上边框
                area: ['100%', '90%'], //宽高
                content: $('#Totalperformanceoverviewofmonth')
            });
        });


        $('.Personalinformationmore').click(function () {
            layer.open({
                type: 1,
                title: '个人信息(每月的分红的情况)',
                skin: 'layui-layer-rim', //加上边框
                area: ['100%', '90%'], //宽高
                content: $('#Personalinformation')
            });
        });


        $('.indirperformanceoverviewofmonth').click(function () {
            layer.open({
                type: 1,
                title: '间推人分月情况)',
                skin: 'layui-layer-rim', //加上边框
                area: ['100%', '90%'], //宽高
                content: $('#indirperformanceoverviewofmonth')
            });
        });

    })
</script>

</body>

</html>
<div style="height: 0;overflow: hidden;">
<!--直推人分月情况-->
    <div class="col-xs-12 col-md-6 col-md-offset-3" dl="Totalperformanceoverviewofmonth"
         id="Totalperformanceoverviewofmonth">
        <div class="panel-heading">
            <h2>直推人分月情况<i class="hidden-xs"> Total performance overview of month </i>

            </h2>
        </div>
        <div class="allowTextWrap">
            <div class="box">
                <table class="table bouns-table fixedlayout">
                    <thead>
                    <tr>
                        <th width="30%">月份</th>
                        <th width="30%">直推的人数量</th>
                        <th width="30%">直推的人编号</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($saoofMonth)): $m = 0; $__LIST__ = $saoofMonth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sm): $mod = ($m % 2 );++$m;?><tr>
                            <td><?php echo ($key); ?></td>
                            <td><?php echo ($sm["sidnum"]); ?>(人)</td>
                            <td> <?php echo ($sm["serverids"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--间推人分月情况-->
    <div class="col-xs-12 col-md-6 col-md-offset-3  " dl="indirperformanceoverviewofmonth"  id="indirperformanceoverviewofmonth">
        <div class="panel-heading">
            <h2>间推人分月情况<i class="hidden-xs"> indirect performance overview of month </i>

            </h2>
        </div>
        <div class="allowTextWrap">
            <div class="box">
                <table class="table bouns-table fixedlayout">
                    <thead>
                    <tr>
                        <th width="33.3%">月份</th>
                        <th width="33.3%">间推的人数量</th>
                        <th width="33.4%">间推的人编号</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($indirseidofmonth)): $i = 0; $__LIST__ = $indirseidofmonth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$idrsm): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($key); ?></td>
                            <td><?php echo (count($idrsm)); ?>(人)</td>
                            <td>
                                <?php if(empty($idrsm) ): ?>无
                                    <?php else: ?>
                                    <?php echo (implode(',',$idrsm)); endif; ?>

                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



<!--提现表单-->
    <div class="col-xs-12 col-md-8  col-md-offset-2   " dl="Personalinformation" id="Personalinformation">


        <!--这是为了提交信息的提现的申请-->
        <div class="panel panel-default">
            <div class="panel-heading" style="margin-top:0px;">提现表单(提现金额最高只可以是总额的80%，提现金额必须是100的倍数)</div>
            <div class="panel-body">
                <form  class="form-inline"  action="<?php echo U('Withdrawalsmsg/acceptwithdrawalsmsg');?>" id="wsform" method="post">
                    <div class="form-group " style="display: inline!important;margin-right: 10px;" >
                        <label  for="month">月份</label>
                        <select class="form-control" id="month" name="monthid">
                            <?php if(is_array($month)): $i = 0; $__LIST__ = $month;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><option value="<?php echo ($m["monthid"]); ?>"><?php echo ($m["month"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: inline!important;" >
                        <label for="wsmoney">提现金额</label>
                        <input type="text" class="form-control" id="wsmoney" name="wsmoney" placeholder="提现金额">
                    </div>
                    <input type="hidden" value="<?php echo ($adminid); ?>" name="adminid"/>
                    <button type="submit" class="btn btn-default" id="wssubmit" style="display: inline!important;" >提交</button>
                </form>
            </div>
        </div>


    <script>
        $(function () {
            //判断体现的金额符合不符合要求
            $('#wssubmit').click(function (e) {
                e.preventDefault();
                var mid = $('#month').val();//月份的id
                var mtext = $('#month').find(':selected').text();//月份的值
                var mtr =  $('#allMonthperformance').find('tr');//每一行的信息
                var mymsmoney = parseFloat($('#wsmoney').val());//我要提现的钱
                var flag = 1;
                mtr.each(function (i,m) {
                    //遍历每一行的数据
//                    console.log( $(this).find('td').eq(0).text() == mtext );
                   if ($(this).find('td').eq(0).text() == mtext ){
                       //月份相同

                      var leftsettlemoney = parseFloat($(this).find('.leftsettlemoney').text()) ;//该月份可提金额
                       console.log(mymsmoney%100);
                       if (mymsmoney >  leftsettlemoney ){
                           layer.tips('提现的金额不可以超过可提金额', '#wsmoney', {
                               tips: [3, '#3595CC'],
                               time: 2000
                           });
                           flag = 0;
                       }else if(mymsmoney%100 != 0 ){
                           layer.tips('提现金额必须是100的倍数', '#wsmoney', {
                               tips: [3, '#3595CC'],
                               time: 2000
                           });
                           flag = 0;
                       }
                   }
                });
                if (flag == 1){
                    $('#wsform').submit();
//                    alert('555');
                }

            });




        })
        
    </script>





        <div class="panel-heading">
            <h2>个人信息<i class="hidden-xs"> Personal information</i> <span>
                    <?php if($admin["usertype"] == 1): ?>普通代理
                     <?php elseif($admin["usertype"] == 2): ?>
                        银牌代理
                     <?php elseif($admin["usertype"] == 3): ?>
                        金牌代理<?php endif; ?>

                    &nbsp;编号：<?php echo ($admin["seid"]); ?>&nbsp;&nbsp; </span>

            </h2>
        </div>


        <div class="allowTextWrap" id="allMonthperformance">
            <table class="table bouns-table format "  >
                <thead>

                <tr>
                    <th>月份</th>
                    <th>直推奖</th>
                    <!--<th>每月前六分红</th>-->
                    <th>分润奖</th>
                    <th>金银牌加权分红</th>
                    <th>总pv分红</th>
                    <th>实际奖金</th>
                    <th>已提现奖金</th>
                    <th>可提金额</th>
                    <th>碧玉豆</th>
                </tr>
                </thead>
                <tbody>

                <?php if(is_array($allMonthperformance)): $i = 0; $__LIST__ = $allMonthperformance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ampf): $mod = ($i % 2 );++$i;?><tr>


                        <td><?php echo ($key); ?></td>
                        <td><?php echo (round($ampf['dirbonkus'],2)); ?></td>
                        <!--<td><?php echo (round($ampf['encbonus'],2)); ?></td>-->
                        <td><?php echo (round($ampf['indirbonkus'],2)); ?></td>
                        <td><?php echo (round($ampf['averagebonus'],2)); ?></td>
                        <td><?php echo (round($ampf['pvtotal'],2)); ?></td>
                        <td class="truebonus"><?php echo (round($ampf['truebonus'],2)); ?></td>
                        <td class="alreadysettlemoney"><?php echo (round($ampf['alreadysettlemoney'],2)); ?></td>
                        <td class="leftsettlemoney"><?php echo (round($ampf['leftsettlemoney'],2)); ?></td>
                        <td><?php echo (round($ampf['biyudou'],2)); ?></td>

                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>
            <table class="table bouns-table bouns-withdrawl format fixedlayout" style="margin-top:20px;">
                <tbody>
                <tr>
                    <th colspan="3" style=" vertical-align:middle">提现金额最高只可以是总额的80%，提现金额必须是100的倍数</th>

                </tr>
                <tr>
                    <td width="33%" style=" vertical-align:middle">累积总PV值</td>
                    <td width="60%" colspan="2" style=" vertical-align:middle">
                        <b><?php echo (round($pvtotalofallmonth["pvtotalofallmonth"],2)); ?></b></td>

                </tr>
                <tr>
                    <td width="33%" style=" vertical-align:middle">碧玉豆（总PV值20%）</td>
                    <td width="60%" colspan="2" style=" vertical-align:middle">
                        <b><?php echo (round($pvtotalofallmonth["biyudouofallmonth"],2)); ?></b></td>

                </tr>
                <tr>
                    <td width="33%" style=" vertical-align:middle">实际奖金（总PV值80%）</td>
                    <td width="60%" colspan="2" style=" vertical-align:middle"><b><?php echo (round($pvtotalofallmonth["truepvtotalofallmonth"],2)); ?></b>
                    </td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>