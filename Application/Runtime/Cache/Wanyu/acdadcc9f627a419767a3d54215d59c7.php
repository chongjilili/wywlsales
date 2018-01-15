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

    <div class="row">
        

            <div class="row">

                <div class="col-lg-11 col-xs-offset-1 col-xs-11  " style="margin-top: 10px;">
                    <h4 style="text-align: center"><?php echo ($title); ?></h4><br>
                    <form method='post' class="form-horizontal" id="form_do" name="form_do"
                          action="<?php if($adminid != null): echo U('editadmin'); else: echo U('addadmin'); endif; ?>">

                        <div class="form-group">
                            <label for="inputUsername" class="col-sm-2 control-label">
                                <?php if($adminid == null ): ?>(留空系统会自动生成编号)<?php endif; ?>
                                用户编号</label>
                            <div class="col-sm-9">
                                <input type="text" name="username" id="inputUsername" value="<?php echo ($admin["username"]); ?>"
                                <?php if($adminid != null ): ?>disabled="disabled"<?php endif; ?>
                                class="form-control" placeholder="
                                <?php if($adminid == null): ?>(留空，系统会自动生成编号)
                                    <?php else: ?>
                                    用户编号<?php endif; ?>
                                " />
                                <?php if($adminid != null ): ?><input type="hidden" name="seid"
                                                                          value="<?php echo ($admin["seid"]); ?>"/><?php endif; ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">
                                <?php if($adminid != null ): ?>(不修改请留空)<?php endif; ?>
                                密码</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" id="inputPassword" value="" class="form-control"
                                <?php if($adminid != null): ?>placeholder="不修改请留空"<?php endif; ?>
                                />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="qPassword" class="col-sm-2 control-label">确认密码</label>
                            <div class="col-sm-9">
                                <input type="password" name="qpassword" id="qPassword" value="" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">电话</label>
                            <div class="col-sm-9">
                                <input type="text" name="phone" id="phone"
                                       value="<?php echo ($admin["phone"]); ?>" class="form-control" placeholder="电话"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="realname" class="col-sm-2 control-label">身份证姓名</label>
                            <div class="col-sm-9">
                                <input type="text" name="realname" id="realname"
                                       value="<?php echo ($admin["realname"]); ?>" class="form-control" placeholder="身份证姓名"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="idcard" class="col-sm-2 control-label">身份证</label>
                            <div class="col-sm-9">
                                <input type="text" name="idcard" id="idcard"
                                       value="<?php echo ($admin["idcard"]); ?>" class="form-control" placeholder="身份证"/>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="creditcard" class="col-sm-2 control-label">银行卡</label>
                            <div class="col-sm-9">
                                <input type="text" name="creditcard" id="creditcard"
                                       value="<?php echo ($admin["creditcard"]); ?>" class="form-control" placeholder="银行卡"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="addressofcreditcard" class="col-sm-2 control-label">开卡户地</label>
                            <div class="col-sm-9">
                                <input type="text" name="addressofcreditcard" id="addressofcreditcard"
                                       value="<?php echo ($admin["addressofcreditcard"]); ?>" class="form-control" placeholder="开卡户地"/>
                            </div>
                        </div>
                        <!--个人资料 -->

                        <?php if($adminid != null ): ?><div class="form-group">
                                <label for="registertime" class="col-sm-2 control-label">注册时间</label>
                                <div class="col-sm-9">
                                    <input type="text" id="registertime" disabled="disabled"
                                           value="<?php echo (date('Y-m-d h:i:s',$admin["registertime"])); ?>"
                                           class="form-control" placeholder="注册时间"/>
                                </div>
                            </div><?php endif; ?>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">性别</label>
                            <div class="col-sm-9">
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="sex" value="1"
                                        <?php if($admin['sex'] == 1 ): ?>checked<?php endif; ?>
                                        >
                                        男
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="sex" value="2"
                                        <?php if($admin['sex'] == 2 ): ?>checked<?php endif; ?>
                                        >
                                        女
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-9">
                                <input type="text" name="email" id="email"
                                       value="<?php echo ($admin["email"]); ?>" class="form-control" placeholder="邮箱"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">地址</label>
                            <div class="col-sm-9">
                                <input type="text" name="address" id="address"
                                       value="<?php echo ($admin["address"]); ?>" class="form-control" placeholder="地址"/>
                            </div>
                        </div>

                        <?php if($admin['usertype'] != 9 ): if($admin['islock'] != 1 ): ?><!--代理还没有激活-->
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">推荐他的人</label>
                                    <div class="col-sm-9">
                                        <select name="masterid" class="form-control">
                                            <option value="">请选择推荐他的人</option>
                                            <?php if(is_array($seids)): foreach($seids as $k=>$v): ?><option value="<?php echo ($v["seid"]); ?>"
                                                <?php if($admin['master']['seid'] == $v['seid'] ): ?>selected="selected"<?php endif; ?>
                                                >
                                                <?php if( $v['seid'] == 0 ): ?>公司管理员
                                                    <?php else: ?>
                                                    <?php echo ($v["seid"]); endif; ?>
                                                </option><?php endforeach; endif; ?>
                                        </select>
                                    </div>


                                </div>


                                <!--所属代理类型 -->

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">所属代理类型</label>
                                    <div class="col-sm-9">
                                        <select name="usertype" class="form-control">
                                            <?php if(is_array($usertype)): foreach($usertype as $k=>$v): ?><option value="<?php echo ($k); ?>"
                                                <?php if($admin['usertype'] == $k ): ?>selected="selected"<?php endif; ?>
                                                ><?php echo ($v); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                    <!--<input type="hidden" name="usertype" value="1"   />-->

                                </div>
                                <?php else: ?>
                                <!--代理激活-->

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">推荐他的人</label>
                                    <div class="col-sm-9">
                                        <select name="masterid" class="form-control" disabled="disabled">
                                            <option value="">请选择推荐他的人</option>
                                            <?php if(is_array($seids)): foreach($seids as $k=>$v): ?><option value="<?php echo ($v["seid"]); ?>"
                                                <?php if($admin['master']['seid'] == $v['seid'] ): ?>selected="selected"<?php endif; ?>
                                                >
                                                <?php if( $v['seid'] == 0 ): ?>公司管理员
                                                    <?php else: ?>
                                                    <?php echo ($v["seid"]); endif; ?>
                                                </option><?php endforeach; endif; ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="masterid" value="<?php echo ($admin["master"]["seid"]); ?>"   />

                                </div>


                                <!--所属代理类型 -->

                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">所属代理类型</label>
                                    <div class="col-sm-9">
                                        <select name="usertype" class="form-control" disabled="disabled">
                                            <?php if(is_array($usertype)): foreach($usertype as $k=>$v): ?><option value="<?php echo ($k); ?>"
                                                <?php if($admin['usertype'] == $k ): ?>selected="selected"<?php endif; ?>
                                                ><?php echo ($v); ?></option><?php endforeach; endif; ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="usertype" value="<?php echo ($admin["usertype"]); ?>"   />
                                    <input type="hidden" name="islock" value="1"   />

                                </div><?php endif; ?>


                            <?php else: ?>
                            <input type="hidden" name="usertype" value="9"/><?php endif; ?>

                        <!--  订单添加  -->
                        <?php if($adminid == null ): ?><div class="form-group">
                                <h3 align="center">订单添加</h3>
                            </div>
                            <div class="form-group">
                                <label for="pid" class="col-sm-2 control-label">请选择产品</label>
                                <div class="col-sm-9">
                                    <select name="pid" class="form-control" id="pid">
                                        <option value="">请选择产品</option>
                                        <?php if(is_array($product)): foreach($product as $k=>$v): ?><option value="<?php echo ($v["pid"]); ?>" price="<?php echo ($v["price"]); ?>" pprice="<?php echo ($v["pprice"]); ?>">
                                                <?php echo ($v["pname"]); ?>---<?php echo ($v["price"]); ?>元---pv值:<?php echo ($v["pprice"]); ?>元
                                            </option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="additionalprice" class="col-sm-2 control-label">附加价格</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="additionalprice" name="additionalprice"
                                           value="<?php echo ($v["additionalprice"]); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="finalprice" class="col-sm-2 control-label">总价格</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" disabled="disabled" id="finalprice"
                                           name="finalprice" value="<?php echo ($v["finalprice"]); ?>" placeholder="0">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="finalpprice" class="col-sm-2 control-label">总pv值</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" disabled="disabled" id="finalpprice"
                                           name="finalpprice" value="<?php echo ($v["finalpprice"]); ?>" placeholder="0">
                                </div>
                            </div><?php endif; ?>

                        <!--个人资料-->
                        <!-- <div class="form-group">
                             <div style="border-bottom: 1px solid #2441ff">

                                 <button class="btn btn-primary" type="button" data-toggle="collapse"
                                         data-target="#collapseExample" aria-expanded="false"
                                         aria-controls="collapseExample">
                                     个人资料(点击显示)
                                 </button>
                             </div>
                             <div class="collapse" id="collapseExample">
                                 <div class="well">


                                     <?php if($adminid != null ): ?><div class="form-group">
                                             <label for="registertime" class="col-sm-2 control-label">注册时间</label>
                                             <div class="col-sm-9">
                                                 <input type="text" id="registertime" disabled="disabled"
                                                        value="<?php echo (date('Y-m-d h:i:s',$admin["registertime"])); ?>"
                                                        class="form-control" placeholder="注册时间"/>
                                             </div>
                                         </div><?php endif; ?>



                                     <div class="form-group">
                                         <label  class="col-sm-2 control-label">性别</label>
                                         <div class="col-sm-9">
                                             <div class="radio-inline"  >
                                                 <label>
                                                     <input type="radio" name="sex"  value="1" <?php if($admin['sex'] == 1 ): ?>checked<?php endif; ?> >
                                                     男
                                                 </label>
                                             </div>
                                             <div class="radio-inline">
                                                 <label>
                                                     <input type="radio" name="sex"  value="2" <?php if($admin['sex'] == 2 ): ?>checked<?php endif; ?> >
                                                     女
                                                 </label>
                                             </div>
                                         </div>
                                     </div>



                                     <div class="form-group">
                                         <label for="email" class="col-sm-2 control-label">邮箱</label>
                                         <div class="col-sm-9">
                                             <input type="text" name="email" id="email"
                                                    value="<?php echo ($admin["email"]); ?>" class="form-control" placeholder="邮箱"/>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <label for="address" class="col-sm-2 control-label">地址</label>
                                         <div class="col-sm-9">
                                             <input type="text" name="address" id="address"
                                                    value="<?php echo ($admin["address"]); ?>" class="form-control" placeholder="地址"/>
                                         </div>
                                     </div>



                                 </div>
                             </div>
                         </div>-->


                        <div class="row margin-botton-large">
                            <div class="col-sm-offset-2 col-sm-9">
                                <?php if($adminid): ?><input type="hidden" name="adminid" value="<?php echo ($adminid); ?>" id="adminid"/><?php endif; ?>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" id="admnsubmit"><i
                                            class="glyphicon glyphicon-saved"></i>
                                        保存
                                    </button>
                                    <button type="button" onclick="goUrl('<?php echo U('index');?>')" class="btn btn-default"><i
                                            class="glyphicon glyphicon-chevron-left"></i>
                                        返回
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

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



<script type="text/javascript">


    $(function () {

        var adminid = $('#adminid').val();


        /*
         *
         * 检测电话和身份证是否为空
         *
         * */
        function checkPersonmsg(phone, idcard,email) {

            var checkFlag = 1;
            if ($.trim(phone) === '') {
                layer.tips('联系电话为空', '#phone', {
                    tips: [3, '#3595CC'],
                    time: 2000
                });
                checkFlag *= 0;
            } else if ($.trim(idcard) === '') {
                layer.tips('身份证不可为空', '#idcard', {
                    tips: [3, '#3595CC'],
                    time: 2000
                });
                checkFlag *= 0;

            }else if ($.trim(email) === '') {
                layer.tips('邮箱不可为空', '#email', {
                    tips: [3, '#3595CC'],
                    time: 2000
                });
                checkFlag *= 0;

            }

            return checkFlag;


        }

        function checkEqulePassword(username, password, qpassword) {
            var checkFlag = 1;


            if (false) {

            }
        <?php if($adminid != null ): ?>else
            if (username === '') {

                layer.tips('用户编号为空', '#inputUsername', {
                    tips: [3, '#3595CC'],
                    time: 2000
                });
                checkFlag *= 0;


            }<?php endif; ?>

        <?php if($admin['usertype'] != 9 && $adminid != null): ?>else
            if (!isInteger(username)) {
                layer.tips('用户编号必须为数字', '#inputUsername', {
                    tips: [3, '#3595CC'],
                    time: 2000
                });
                checkFlag *= 0;
            }<?php endif; ?>
            else if (password === '') {
                if (typeof(adminid) == "undefined") {

                    layer.tips('密码为空', '#inputPassword', {
                        tips: [3, '#3595CC'],
                        time: 2000
                    });
                    checkFlag *= 0;
                }

            }
            else if (qpassword !== password) {
                if (typeof(adminid) == "undefined" || password !== '') {
                    layer.tips('确认密码和密码不相同', '#qPassword', {
                        tips: [3, '#3595CC'],
                        time: 2000
                    });
                    checkFlag *= 0;
                }
            }
            ;


            return checkFlag;
        }

        var checkFlag = 0;

        $('#form_do').find('input').blur(function () {

            var username = $('#inputUsername').val();
            var password = $('#inputPassword').val();
            var qpassword = $('#qPassword').val();
            var phone = $('#phone').val();
            var idcard = $('#idcard').val();
            var email = $('#email').val();
            checkFlag = checkEqulePassword(username, password, qpassword);
            checkFlag = checkFlag * checkPersonmsg(phone, idcard,email);
//            console.log(checkFlag);

        });

        <?php if($adminid == null ): ?>$('#additionalprice').change(function () {
                    caculateprice();
                });

        $('#pid').change(function () {
            caculateprice();
        });<?php endif; ?>

        $("#admnsubmit").click(function (e) {
            var username = $('#inputUsername').val();
            var password = $('#inputPassword').val();
            var qpassword = $('#qPassword').val();
            var phone = $('#phone').val();
            var idcard = $('#idcard').val();
            var email = $('#email').val();
            checkFlag = checkEqulePassword(username, password, qpassword);
            checkFlag = checkFlag * checkPersonmsg(phone, idcard,email);
            console.log(checkFlag);
            if (checkFlag === 0) {
                e.preventDefault();
            }
            <?php if($adminid == null ): ?>if ($('#sadminid').val() == '') {
                    e.preventDefault();
                    layer.msg('请选择代理');
                } else if ($('#pid').val() == '') {
                    e.preventDefault();
                    layer.msg('请选择产品');
                } else if ($('#additionalprice').val() != '' && isNaN($('#additionalprice').val())) {
                    e.preventDefault();
                    layer.msg('附加价格！');
                }<?php endif; ?>

        });


        function caculateprice() {
            var price = isNaN(parseFloat($('#pid').find(":selected").attr('price'))) ? 0 : parseFloat($('#pid').find(":selected").attr('price'));
//            var pv = isNaN(parseFloat($('#pid').find(":selected").attr('pv')))  ? 0 : parseFloat($('#pid').find(":selected").attr('pv'));
            var pprice = isNaN(parseFloat($('#pid').find(":selected").attr('pprice'))) ? 0 : parseFloat($('#pid').find(":selected").attr('pprice'));
            var additionalprice = $('#additionalprice').val() == '' ? 0 : parseFloat($('#additionalprice').val());
            $('#finalprice').val(price + additionalprice);
            $('#finalpprice').val(pprice);


        }


    })
</script>
</body>
</html>