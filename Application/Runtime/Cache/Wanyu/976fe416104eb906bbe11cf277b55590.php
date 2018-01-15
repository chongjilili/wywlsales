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

    <link rel="stylesheet" type="text/css" media="screen" href="/wywlsale/Public/jqgrid/css/redmond/jquery-ui-1.8.16.custom.css" />

    <link rel="stylesheet" type="text/css" media="screen" href="/wywlsale/Public/jqgrid/css/ui.jqgrid.css" />

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

<script>

    $(function(){
        pageInit();
    });
    /*
    * t this
    * rowObject seid
    * cellvalue 是否结算
    *
    * */
    function clickbtn(t,seid,monthtime) {
//        alert($(t).parents('tr').prop("outerHTML"));

//        console.log(arguments);
//        [button.editbutton, 2, 1490976000000, 1]
        monthtime=monthtime/1000;
        var issettle = $(t).attr('issettle');
        if (issettle==1){
            if(confirm("是否要取消原来的结算，请慎重！")){

                $.ajax({
                    url:"<?php echo U('settletoggle');?>",
                    type:'POST',
                    data:{
                        seid:seid,
                        monthtime:monthtime,
                        issettle:0
                    },
                    success:function (data) {
                        console.log(data);
                        if (data == 1){
                            $(t).css({
                                color:'#ff322d'
                            }).attr('issettle',0).text('未结算');
                        }else {
                            layer.msg('修改失败');
                        }

                    }
                })





              }

            }else {
                if(confirm("是否结算完成？")){
                    $.ajax({
                        url:"<?php echo U('settletoggle');?>",
                        type:'POST',
                        data:{
                            seid:seid,
                            monthtime:monthtime,
                            issettle:1
                        },
                        success:function (data) {
                            console.log(data);
                            if (data == 1){
                                $(t).css({
                                    color:'#488cff'
                                }).attr('issettle',1).text('已结算');
                            }else {
                                layer.msg('修改失败');
                            }

                        }
                    })
            }
        }



    }
    function pageInit(){
        var lastsel;
        jQuery("#list4").jqGrid(
                {
//                    datatype : "local",
                    url : "<?php echo U('jqGridjson');?>",//组件创建完成之后请求数据的url
                    datatype : "json",//请求数据返回的类型。可选json,xml,txt
                    height : 600,
                    colNames : [ '工号', '月份', '直推奖', /*'每月前六分红',*/ '分润奖','金银牌加权分红','总pv分红','实际奖金','已提现金额','可提金额','碧玉豆' ,'是否结算' ],
                    colModel : [
                        {name : 'seid',index : 'seid',width : 80,sorttype : "int",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}    },
                        {name : 'monthstr',index : 'monthstr',width : 100,sorttype : "date", search:false,sortable : true },
                        {name : 'dirbonkus',index : 'dirbonkus',width : 100,searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
//                        {name : 'encbonus',index : 'encbonus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                        {name : 'indirbonkus',index : 'indirbonkus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                        {name : 'averagebonus',index : 'averagebonus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                        {name : 'pvtotal',index : 'pvtotal',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },

                        {name : 'truebonus',index : 'truebonus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                        {name : 'alreadysettlemoney',index : 'alreadysettlemoney',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} ,editable : true},
                        {name : 'leftsettlemoney',index : 'leftsettlemoney',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                        {name : 'biyudou',index : 'biyudou',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}},

                        {name : 'issettlement',index : 'issettlement',width : 100,sortable : false,align: 'center',stype:'select',searchoptions:{ sopt:['eq'],value:{0:'未结算',1:'已结算'} },
                            formatter: function (cellvalue, options, rowObject) {
                                if(cellvalue!='1'){
                                    cellvalue = '0';
                                }
                               /* console.log(typeof rowObject[1]);
                                console.log(rowObject);*/
                                  var seid = rowObject[0];
                                  var monthdate = rowObject[1].replace(/-/g,'/');
                                 // console.log(rowObject);

                                  var monthtime = Date.parse(new Date(monthdate));//时间戳
                               // rowstr = rowObject.toString();
                                if (cellvalue == '0') return "<button  class='editbutton' issettle='"+cellvalue+"' style='color:#ff322d' onclick='clickbtn (this,"+seid+","+monthtime+","+cellvalue+")'>未结算</button>";
                                if (cellvalue == '1') return "<button  class='editbutton' issettle='"+cellvalue+"' style='color:#488cff' onclick='clickbtn (this,"+seid+","+monthtime+","+cellvalue+")'>已结算</button>"
                            }
                        }

                    ],
                    sortable: true,  //可以排序
                    sortname:'id',
                    sortorder: "asc",//排序方式：正序，本例中设置默认按sno倒序排序
                    caption : "奖金信息",
                    rowNum : 20,//一页显示多少条
                    rowList : [ 10, 20, 30 ],//可供用户选择一页显示多少条
                    pager : '#pager4',
                    onCellSelect : function(id) {
                        if (id && id !== lastsel) {
                            jQuery('#list4').jqGrid('restoreRow', lastsel);
                            jQuery('#list4').jqGrid('editRow', id,{
                                keys : true,
                                successfunc:function () {
                                     //修改后做的的事情

                                    rowdata = $('#list4').jqGrid("getRowData",id);
                                    window.seid = rowdata.seid;
                                    var monthdate = rowdata.monthstr.replace(/-/g,'/');
                                    window.monthtime = Date.parse(new Date(monthdate))/1000;//时间戳
                                    $('#list4').jqGrid("setCell",id,'leftsettlemoney',rowdata.truebonus-rowdata.alreadysettlemoney);

                                    return true;
                                }(window),
                                /*successfunc:function () {
                                    layer.msg('修改成功');
                                },*/
                                extraparam : {
                                    seid:window.seid,
                                    monthtime:window.monthtime
                                },
                                mtype : "POST"
                            });
                            lastsel = id;
                        }
                    },
                    editurl : "<?php echo U('settleEdit');?>" ,

                    viewrecords: true,
                    multiselect: false,
                    subGrid : true,
                     /*subGridUrl: "<?php echo U('jqGridjson');?>",
                    subGridModel: [{ name  : [ '工号', '时间', '直接开拓pv总值', '每月前六分红', '间接开拓pv总值','总pv总值', '是否提现' ],
                        width : [80,140,140,140,140,140,140] }
                    ]*/
                    subGridRowExpanded: function(subgrid_id, row_id) {
                        // we pass two parameters
                        // subgrid_id is a id of the div tag created whitin a table data
                        // the id of this elemenet is a combination of the "sg_" + id of the row
                        // the row_id is the id of the row
                        // If we wan to pass additinal parameters to the url we can use
                        // a method getRowData(row_id) - which returns associative array in type name-value
                        // here we can easy construct the flowing
                        var sublastsel;
                        var subgrid_table_id, pager_id;
                        subgrid_table_id = subgrid_id+"_t";
                        pager_id = "p_"+subgrid_table_id;
                        $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
                        jQuery("#"+subgrid_table_id).jqGrid({
                            url:"<?php echo U('jqSubGridjson');?>/q/2/id/"+row_id,
                            datatype: "json",
                            colNames: [ '工号', '月份', '直推奖', /*'每月前六分红',*/ '分润奖','金银牌加权分红','总pv分红','实际奖金','已提现金额','可提金额','碧玉豆' ,'是否结算' ],
                            colModel: [
                                {name : 'subid',index : 'subid',width : 80,sorttype : "int",search:false,sortable : false},
                                {name : 'monthstr',index : 'monthstr',width : 100,sorttype : "date",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}},
                                {name : 'dirbonkus',index : 'dirbonkus',width : 100,searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}},
//                                {name : 'encbonus',index : 'encbonus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}},
                                {name : 'indirbonkus',index : 'indirbonkus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}},
                                {name : 'averagebonus',index : 'averagebonus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                                {name : 'pvtotal',index : 'pvtotal',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}},

                                {name : 'truebonus',index : 'truebonus',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                                {name : 'alreadysettlemoney',index : 'alreadysettlemoney',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} ,editable : true},
                                {name : 'leftsettlemoney',index : 'leftsettlemoney',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']} },
                                {name : 'biyudou',index : 'biyudou',width : 100,align : "right",sorttype : "float",searchoptions:{ sopt:['eq','ne','lt','le','gt','ge']}},

                                {name : 'issettlement',index : 'issettlement',width : 100,sortable : false,align: 'center',stype:'select',searchoptions:{ sopt:['eq'],value:{0:'未结算',1:'已结算'}},
                                    formatter: function (cellvalue, options, rowObject) {
                                        if(cellvalue!='1'){
                                            cellvalue = '0';
                                        }
                                       /* console.log(typeof rowObject[1]);
                                        console.log(rowObject);*/
                                        var seid = rowObject[0];
                                        var monthdate = rowObject[1].replace(/-/g,'/');
                                        // console.log(rowObject);

                                        var monthtime = Date.parse(new Date(monthdate));
                                        // rowstr = rowObject.toString();
                                        if (cellvalue == '0') return "<button  class='editbutton'  issettle='"+cellvalue+"' style='color:#ff322d' onclick='clickbtn (this,"+seid+","+monthtime+","+cellvalue+")'>未结算</button>";
                                        if (cellvalue == '1') return "<button  class='editbutton' issettle='"+cellvalue+"' style='color:#488cff' onclick='clickbtn (this,"+seid+","+monthtime+","+cellvalue+")'>已结算</button>"
                                    }
                                }
                            ],
                            rowNum:20,
                            pager: pager_id,
                            onCellSelect : function(id,iCol,cellcontent,e) {
                                //rowid：当前行id；iCol：当前单元格索引；cellContent：当前单元格内容；e：event对象
                                if (id && id !== sublastsel) {
//                                    console.log(id);

                                    jQuery("#"+subgrid_table_id).jqGrid('restoreRow', sublastsel);
                                    jQuery("#"+subgrid_table_id).jqGrid('editRow', id, {
                                        keys : true,
                                        successfunc:function () {
                                            //修改后做的的事情
                                            console.log($("#"+subgrid_table_id).jqGrid("getRowData",id));
                                            rowdata = $("#"+subgrid_table_id).jqGrid("getRowData",id);
                                            window.seid = rowdata.subid;
                                            var monthdate = rowdata.monthstr.replace(/-/g,'/');

                                            window.monthtime = Date.parse(new Date(monthdate))/1000;//时间戳
                                            $("#"+subgrid_table_id).jqGrid("setCell",id,'leftsettlemoney',rowdata.truebonus-rowdata.alreadysettlemoney);
//                                             layer.msg('修改成功dd');
                                            return true;
                                        }(window),
//                                        url:"<?php echo U('settleEdit');?>/seid/"+ window.seid+"/month/"+window.monthtime,
                                        extraparam : {
                                            seid:window.seid,
                                            monthtime:window.monthtime
                                        },
                                        mtype : "POST"
                                    });
                                    sublastsel = id;
                                }
                            },
                            editurl : "<?php echo U('settleEdit');?>" ,
                            sortname: 'monthstr',
                            sortorder: "desc",
                            height: '100%'
                        });
                        jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false/*,search:false*/})
                    }

                });
        jQuery("#list4").jqGrid('navGrid', '#pager4', {edit : false,add : false,del : false/*,
            search:{
                odata : ['equal', 'not equal', 'less', 'less or equal','greater','greater or equal'],
            }*/
        }
        );
        /*

        var mydata = [
            {id : "1",invdate : "2007-10-01",name : "test",note : "note",amount : "200.00",tax : "10.00",total : "210.00"},
            {id : "2",invdate : "2007-10-02",name : "test2",note : "note2",amount : "300.00",tax : "20.00",total : "320.00"},
            {id : "3",invdate : "2007-09-01",name : "test3",note : "note3",amount : "400.00",tax : "30.00",total : "430.00"},
            {id : "4",invdate : "2007-10-04",name : "test",note : "note",amount : "200.00",tax : "10.00",total : "210.00"},
            {id : "5",invdate : "2007-10-05",name : "test2",note : "note2",amount : "300.00",tax : "20.00",total : "320.00"},
            {id : "6",invdate : "2007-09-06",name : "test3",note : "note3",amount : "400.00",tax : "30.00",total : "430.00"},
            {id : "7",invdate : "2007-10-04",name : "test",note : "note",amount : "200.00",tax : "10.00",total : "210.00"},
            {id : "8",invdate : "2007-10-03",name : "test2",note : "note2",amount : "300.00",tax : "20.00",total : "320.00"},
            {id : "9",invdate : "2007-09-01",name : "test3",note : "note3",amount : "400.00",tax : "30.00",total : "430.00"}
        ];
        for ( var i = 0; i <= mydata.length; i++){
            jQuery("#list4").jqGrid('addRowData', i + 1, mydata[i]);
        }

        */
    }


</script>
<div class="container">

    <div class="row">
        



            <div>
                <!--业绩报表-->
                <!-- Nav tabs -->


                <div class="row">

                    <div class="col-lg-11  col-xs-11  " style="margin-top: 10px;">
                        <h4 style="text-align: center"><?php echo ($title); ?></h4><br>


                        <table id="list4"></table>
                        <div id="pager4"></div>



                    </div>
                </div>

            </div>










        

    </div>

</div>
<script>
   $(function () {
       $('#rssubmit').click(function (e) {
           e.preventDefault();
           clearInterval(settime);
           $('#rsform_edit').submit();
       })
   }) ;
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