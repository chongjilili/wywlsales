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
<style>
    .sort:hover {
        background-color: #2f91ff !important;
    }


</style>
<div class="container">

    <div class="row">
        
            <?php if($usertype == 9): ?><div class="row marbottom">


                    <div class="col-sm-6   column ">
                        <div class="btn-group btn-group-md">
                            <button class="btn btn-primary    " type="button" onclick="goUrl('<?php echo U('addadmin');?>')"><em
                                    class="glyphicon glyphicon-plus-sign"></em> 添加代理商
                            </button>
                            <button class="btn btn-success    " type="button" onclick="location.reload();">
                                <em class="glyphicon glyphicon-refresh"></em> 刷新
                            </button>
                            <!-- <button class="btn btn-default  　" type="button" onclick="doConfirmBatch('<?php echo U('deladmin', array('batchFlag' => 1));?>', '确实要删除选择项吗？')"><em class="glyphicon glyphicon-remove-circle"></em> 删除</button>-->
                        </div>

                    </div>

                    <div class="col-sm-6   text-left">

                        <form method="post" action="<?php echo U('manage');?>" id="kform">
                            <div class="row ">
                                <div class="col-xs-3">
                                    <label class="sr-only">代理级别</label>
                                    <select class="form-control  " name="usertype">
                                        <option value="">请选择代理级别</option>
                                        <option value="1"
                                        <?php if($searusertype == 1): ?>selected="selected"<?php endif; ?>
                                        >普通代理</option>
                                        <option value="2"
                                        <?php if($searusertype == 2): ?>selected="selected"<?php endif; ?>
                                        >银牌代理</option>
                                        <option value="3"
                                        <?php if($searusertype == 3): ?>selected="selected"<?php endif; ?>
                                        >金牌代理</option>
                                    </select>
                                </div>


                                <div class="col-xs-2">
                                    <label class="sr-only">是否激活</label>
                                    <select class="form-control  " name="islock">
                                        <option value="">请选择激活情况</option>
                                        <option value="1"
                                        <?php if($searislock == 1): ?>selected="selected"<?php endif; ?>
                                        >已激活</option>
                                        <option value="2"
                                        <?php if($searislock == 2): ?>selected="selected"<?php endif; ?>
                                        >未激活</option>


                                    </select>
                                </div>


                                <div class="col-xs-2">
                                    <label class="sr-only" for="inputKeyword">工号</label>
                                    <input type="text" class="form-control " name="seid" id="inputKeyword"
                                           placeholder="工号" value="<?php echo ($seid); ?>">
                                </div>

                                <div class="col-xs-3">
                                    <label class="sr-only">身份证</label>
                                    <input type="text" class="form-control  " name="idcard" placeholder="身份证"
                                           value="<?php echo ($idcard); ?>">
                                </div>

                                <div class="col-xs-2">
                                    <input type="hidden" name="search" value="1"/>
                                    <button type="submit" class="btn btn-default  ">搜索</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div><?php endif; ?>


            <div class="row">
                <div class="col-lg-12">
                    <form action="" method="post" id="form_do" name="form_do">
                        <div class="table-responsive">
                            <table class="table table-hover xyh-table-bordered-out">
                                <thead>
                                <tr class="active">
                                    <!--<th><input type="checkbox" id="check"></th>-->
                                    <input type="hidden" id="issort" value="<?php echo ($issort); ?>">
                                    <th class="sort " sort="seid"
                                    <?php if($sort == 'seid' ): ?>sorttype="<?php echo ($sorttype); ?>"
                                        <?php else: ?>
                                        sorttype="asc"<?php endif; ?>
                                    >工号</th>
                                    <!--<th class="hidden-xs">上次登录时间</th>-->
                                    <th class="hidden-xs">姓名</th>
                                    <th class="hidden-xs sort sortregistertime" sort="registertime"
                                    <?php if($sort == 'registertime' ): ?>sorttype="<?php echo ($sorttype); ?>"
                                        <?php else: ?>
                                        sorttype="asc"<?php endif; ?>
                                    >注册时间

                                    </th>
                                    <th>代理类型</th>
                                    <th>推荐人</th>
                                    <th class="text-right">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($user)): foreach($user as $key=>$v): ?><tr>
                                        <!--<td><input type="checkbox" name="key[]" <?php if($v['usertype'] == 9): ?>disabled="disabled"<?php endif; ?> value="<?php echo ($v["id"]); ?>"></td>-->

                                        <td><?php echo ($v["username"]); ?></td>


                                        <!--<td class="hidden-xs"><?php echo (date('Y-m-d H:i:s',$v["logintime"])); ?></td>-->
                                        <td class="hidden-xs"><?php echo ($v["realname"]); ?></td>
                                        <td class="hidden-xs"><?php echo (date('Y-m-d H:i:s',$v["registertime"])); ?></td>
                                        <!--<td class="visible-xs-block"><?php echo (date('m-d H:i',$v["logintime"])); ?></td>-->
                                        <td class="">
                                            <?php if($v["usertype"] == 1): ?>普通代理
                                                <?php elseif($v["usertype"] == 2): ?>
                                                银牌代理
                                                <?php elseif($v["usertype"] == 3): ?>
                                                金牌代理
                                                <?php elseif($v["usertype"] == 9): ?>
                                                公司管理员<?php endif; ?>
                                        </td>

                                        <td><?php echo ($v["pseid"]); ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo U('Achievement/picture',array('adminid'=>$v['id']));?>"
                                               class="label label-primary" title="组织网图">网图</a>
                                            <?php if(($v['usertype'] == 9) OR ($usertype != 9) ): ?><a href="<?php echo U('Achievement/companyprofit',array('adminid'=> 1 ) );?>"
                                                   class="label label-info">业绩</a>
                                                <?php elseif($v['islock'] == 1): ?>

                                                    <a href="<?php echo U('Achievement/index',array('adminid'=>$v['id']));?>"
                                                       class="label label-info ">业绩</a>

                                                    <?php else: ?>

                                                    <span class="label label-default ">业绩</span><?php endif; ?>

                                            <a href="<?php echo U('Admin/addadmin',array('adminid'=>$v['id']));?>"
                                               class="label label-success">修改</a>
                                            <!-- <?php if(($v['usertype'] == 9) OR ($usertype != 9) ): ?><span class="label label-default">删除</span>
                                                 <?php else: ?>
                                                 <a href="javascript:;" onclick="toConfirm('<?php echo U('Admin/deladmin',array('adminid'=>$v['id']));?>','你确定要删除？')" class="label label-danger">删除</a><?php endif; ?>-->
                                        </td>
                                    </tr><?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>


                    <div class="wypage">

                        <nav>
                            <ul class="pagination">
                                <li><a href="<?php echo U('Admin/manage',array('nowpage'=> 1 ) );?>"> 首页 </a></li>
                                <?php if($nowpage != 1): ?><li><a href="<?php echo U('Admin/manage',array('nowpage'=> $nowpage-1 ) );?>"
                                           title="上一页">&laquo;</a></li>
                                    <?php else: ?>
                                    <li class="disabled"><a
                                            href="<?php echo U('Admin/manage',array('nowpage'=> $nowpage-1 ) );?>">&laquo;</a></li><?php endif; ?>
                                <!--<li class="active"> <span >1</span></li>-->

                                <?php $__FOR_START_11964__=advoidnegative($nowpage-3);$__FOR_END_11964__=advoidTranscend($nowpage+3,$pagecount+1);for($i=$__FOR_START_11964__;$i < $__FOR_END_11964__;$i+=1){ if($i == $nowpage): ?><li class="active"><span><?php echo ($i); ?></span></li>
                                        <?php else: ?>
                                        <li><a href="<?php echo U('Admin/manage',array('nowpage'=> $i ) );?>"><?php echo ($i); ?></a></li><?php endif; } ?>

                                <?php if($nowpage != $pagecount): ?><li><a href="<?php echo U('Admin/manage',array('nowpage'=> $nowpage+1 ) );?>"
                                           title="下一页">&raquo;</a></li>
                                    <?php else: ?>
                                    <li class="disabled"><a
                                            href="<?php echo U('Admin/manage',array('nowpage'=> $nowpage+1 ) );?>">&raquo;</a></li><?php endif; ?>
                                <li><a href="<?php echo U('Admin/manage',array('nowpage'=> $pagecount ) );?>"> 末页 </a></li>

                                <li><span> 共<?php echo ($allnum); ?>条数据，共<?php echo ($pagecount); ?>页 ,现在第 <?php echo ($nowpage); ?>页</span></li>
                            </ul>

                        </nav>

                    </div>


                </div>
            </div>

        

    </div>

</div>


<script>
    $(function () {
        $('.sort').click(function (e) {
            //排序
            $('#issort').val(1);
            var sort = $(this).attr('sort');//排序字段
            var sorttype = $(this).attr('sorttype');//排序类型，升序和降序
            var href = "<?php echo U('manage');?>";
            href += '/issort/1/sort/' + sort + '/sorttype/' + sorttype;
            console.log(href);
            goUrl(href);
        });

        $('.wypage').find('a').click(function (e) {
            //让分页有搜索的信息
            e.preventDefault();
            var href = $(this).attr('href');
            var formparam = $('#kform').serialize();
            console.log(formparam);
            href += '/wypage/1';

            /****  排序 *****/
            var issort = $('#issort').val();

            if (issort == 1) {
                //有搜索的条件
                var sort = "<?php echo ($sort); ?>";
                var wypage = "<?php echo ($wypage); ?>";//用来判断是否分页过,如果为0，则上一操作不是分页，而是排序
                var sorttype = "<?php echo ($sorttype); ?>";
                if (wypage == 1) {
                    //上一操作也是分页
                    sorttype = "<?php echo ($sorttype); ?>";
                } else {
                    sorttype = ("<?php echo ($sorttype); ?>" == 'desc' ? 'asc' : 'desc');//翻转
                }

                href += '/issort/1/sort/' + sort + '/sorttype/' + sorttype;
            }


            /****搜索的条件*****/
//               formparam = formparam.replace(/&/g,'/').replace(/=/g,'/');
            href += '/search/1';
//               console.log(formparam);
            href += ('?' + formparam);
            //alert(href);
            goUrl(href);
        })
    })
</script>


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