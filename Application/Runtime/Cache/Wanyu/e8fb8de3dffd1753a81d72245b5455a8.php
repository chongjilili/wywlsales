<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0047)https://member.comeway.hk/Home/Index/puckerTree -->
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0;">
    <meta name="HandheldFriendly" content="true">
    <meta name="mobileoptimized" content="0">
    <meta name="Cache-Control" content="no-cache,max-age=0">

    
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
    <link rel="stylesheet" href="/wywlsale/Application/Wanyu/View/public/css/tipso.css">
    <script src="/wywlsale/Application/Wanyu/View/public/js/tipso.js"></script>
</head>
<body>
<script type="text/javascript" src="/wywlsale/Application/Wanyu/View/public/js/d3.js"></script>

<style>
    #window {
        background: #fff;
        border: 1px solid #ccc;
        position: relative;
        cursor: move;
        border-radius: 5px;
        overflow: hidden;
    }

    .fullscreen {
        position: absolute;
        right: 0;
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
    }

    .fullscreen a {
        display: block;
        padding: 4px 8px;
    }

    .fullscreen a:hover {
        background: #F9F9F9;
    }

    .node {
        cursor: pointer;
    }

    .node circle {
        fill: #fff;
        stroke: steelblue;
        stroke-width: 1.5px;
    }

    .node text {
        font: 10px sans-serif;
    }

    .link {
        fill: none;
        stroke: #ccc;
        stroke-width: 1.5px;
    }

    .tooltip {
        font-family: simsun;
        font-size: 16px;
        color: #000;
        width: 240px;
        height: auto;
        position: absolute;
        text-align: center;
        border-style: solid;
        border: 1px #CCCCCC solid;
        background-color: #FFF;
        border-radius: 10px;
        padding: 15px;
        z-index: 90000;
    }

    .tooltip li {
        list-style-type: none;
        list-style: none;
        font-size: 18px;
        min-width: 180px;
        text-align: left;
    }
</style>

<script>

    //     window.location.reload();
    function getCookie(name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    }

    if (getCookie('adminid') != getCookie('adminidy')) {
        window.location.reload();
    }

    $(function () {

        var full_width = $(window).width();
        var full_height = $(window).height();

        var treeNode = '';

        var fid = $("#fid").val();
        var reSize = $("#reSize").val();

        //圖像區域大小
        var w_offset = 0;
        var h_offset = 450;
        var spacing = reSize == '' ? 64 : reSize;
        var w = window.screen.width * spacing - 240;
        var h = window.screen.height;

        w_offset = (window.screen.width > 1168) ? window.screen.width - 1168 : 0;
        h_offset = (window.screen.height > 630) ? window.screen.height - 630 : h_offset;

        this_width = window.screen.width - w_offset;
        this_height = window.screen.height - h_offset;

        $("#window").width(this_width);
        $("#window").height(this_height);

//**************************************************************
        var margin = {
                    top: 20,
                    right: 120,
                    bottom: 20,
                    left: 120
                },
                width = 960 - margin.right - margin.left,
                height = 800 - margin.top - margin.bottom;


        var root;
        d3.json("/wywlsale/Application/Wanyu/View/public/js/seidtree.json", function (error, root1) {
                    root = root1;

                    var i = 0,
                            duration = 750,
                            rectW = 30,//节点大小
                            rectH = 20;

                    var tree = d3.layout.tree().nodeSize([50, 30]);//节点距离
                    var diagonal = d3.svg.diagonal()
                            .projection(function (d) {
                                return [d.x + rectW / 2, d.y + rectH / 2];
                            });

                    var svg = d3.select("#body").append("svg").attr("width", 3500).attr("height", 3000)
                            .call(zm = d3.behavior.zoom().scaleExtent([1, 3]).on("zoom", redraw)).append("g")
                            .attr("transform", "translate(" + 100 + "," + 20 + ")");

                    //necessary so that zoom knows where to zoom and unzoom from
                    zm.translate([100, 20]);

                    root.x0 = 0;
                    root.y0 = height / 2;


                    /*
                     * 折叠起来
                     * **/
                    function collapse(d) {
                        if (d.children) {
                            d._children = d.children;
                            d._children.forEach(collapse);
                            d.children = null;
                        }
                    }

                    root.children.forEach(collapse);
                    update(root);

                    d3.select("#body").style("height", "800px");

                    function update(source) {
                        //  console.log(source);
                        // Compute the new tree layout.
                        var nodes = tree.nodes(root).reverse(),
                                links = tree.links(nodes);

                        // Normalize for fixed-depth.
                        nodes.forEach(function (d) {
                            d.y = d.depth * 180;
                        });

                        // Update the nodes…
                        var node = svg.selectAll("g.node")
                                .data(nodes, function (d) {
                                    return d.id || (d.id = ++i);
                                });

                        // Enter any new nodes at the parent's previous position.
                        var nodeEnter = node.enter().append("g")
                                .attr("class", "node")
                                .attr("transform", function (d) {
                                    return "translate(" + source.x0 + "," + source.y0 + ")";
                                })
                                .on("click", click)
                                .on("mouseover", function (d, i) {

                                    switch (d.usertype) {
                                        case 1 :
                                            d.usertypen = '普通代理';
                                            break;
                                        case 2 :
                                            d.usertypen = '银牌代理';
                                            break;
                                        case 3 :
                                            d.usertypen = '金牌代理';
                                            break;
                                        case 9 :
                                            d.usertypen = '公司管理员';
                                            break;
                                        default :
                                            d.usertypen = '暂无';
                                    }
                                    var html = '暂无';
                                    if (d.name == " ") {
                                        html = '暂无';
                                    } else {
                                        html = '代理编号为：' + d.name + '<br>' +
                                                '代理类型为：' + d.usertypen + '<br>' +
                                                '推荐人编号为：' + d.pseid;

                                    }
                                    $(this).tipso({
                                        useTitle: false,
                                        content: html,
                                        position: 'right'
                                    })
                                });

                        nodeEnter.append("rect")
                                .attr("width", rectW)
                                .attr("height", rectH)
                                .attr("stroke", "black")
                                .attr("stroke-width", 1)
                                .style("fill", function (d) {
                                    var ncolor = "#fff";
                                    if (d.usertype == 1) {
                                        ncolor = "#93EACA";
                                    } else if (d.usertype == 2) {
                                        ncolor = "#D4D9DE";
                                    } else if (d.usertype == 3) {
                                        ncolor = "#E9F533";
                                    }
                                    return d._children ? "#3697ED" : ncolor;
                                });

                        nodeEnter.append("text")
                                .attr("x", rectW / 2)
                                .attr("y", rectH / 2)
                                .attr("dy", ".35em")
                                .attr("text-anchor", "middle")
                                .text(function (d) {
                                    return d.name;
                                });

                        // Transition nodes to their new position.
                        var nodeUpdate = node.transition()
                                .duration(duration)
                                .attr("transform", function (d) {
                                    return "translate(" + d.x + "," + d.y + ")";
                                });

                        nodeUpdate.select("rect")
                                .attr("width", rectW)
                                .attr("height", rectH)
                                .attr("stroke", "black")
                                .attr("stroke-width", 1)
                                .style("fill", function (d) {

                                    //console.log(this);
                                    var ncolor = "#fff";
                                    if (d.usertype == 1) {
                                        ncolor = "#93EACA";
                                    } else if (d.usertype == 2) {
                                        ncolor = "#D4D9DE";
                                    } else if (d.usertype == 3) {
                                        ncolor = "#E9F533";
                                    }
                                    return d._children ? "#3697ED" : ncolor;//没有折叠的颜色
                                });

                        nodeUpdate.select("text")
                                .style("fill-opacity", 1);

                        // Transition exiting nodes to the parent's new position.
                        var nodeExit = node.exit().transition()
                                .duration(duration)
                                .attr("transform", function (d) {
                                    return "translate(" + source.x + "," + source.y + ")";
                                })
                                .remove();

                        nodeExit.select("rect")
                                .attr("width", rectW)
                                .attr("height", rectH)
                                //.attr("width", bbox.getBBox().width)""
                                //.attr("height", bbox.getBBox().height)
                                .attr("stroke", "black")
                                .attr("stroke-width", 1);

                        nodeExit.select("text");

                        // Update the links…
                        var link = svg.selectAll("path.link")
                                .data(links, function (d) {
                                    return d.target.id;
                                });

                        // Enter any new links at the parent's previous position.
                        link.enter().insert("path", "g")
                                .attr("class", "link")
                                .attr("x", rectW / 2)
                                .attr("y", rectH / 2)
                                .attr("d", function (d) {
                                    var o = {
                                        x: source.x0,
                                        y: source.y0
                                    };
                                    return diagonal({
                                        source: o,
                                        target: o
                                    });
                                });

                        // Transition links to their new position.
                        link.transition()
                                .duration(duration)
                                .attr("d", diagonal);

                        // Transition exiting nodes to the parent's new position.
                        link.exit().transition()
                                .duration(duration)
                                .attr("d", function (d) {
                                    var o = {
                                        x: source.x,
                                        y: source.y
                                    };
                                    return diagonal({
                                        source: o,
                                        target: o
                                    });
                                })
                                .remove();

                        // Stash the old positions for transition.
                        nodes.forEach(function (d) {
                            d.x0 = d.x;
                            d.y0 = d.y;
                        });
                    }

                    // Toggle children on click.展开树
                   /* function click(d) {

                        if (d.children) {
                            d._children = d.children;
                            d.children = null;
                        } else {

                            d.children = d._children;
                            d._children = null;
                        }
                        update(d);
                    }*/


                    function click(d) {
                        openSixLayer(d);
                        update(d);
                    }

                    function openSixLayer(d) {
                        var layer =  arguments[1] ? arguments[1] : 0;

                        console.log(layer+"**********"+d.name+"****"+arguments[1]);
                        var j=0;
                        var i=0;
                        if (d.children) {
                            //已经展开
                            if (layer == 0){
                                //第0层的展开和合并交替
                                d._children = d.children;
                                d.children = null;
                            }else{
                                //其他6层的打开的就继续打开，不打开的就要打开，并且遍历下一层
                                if(layer < 5&& typeof(d.children) !="undefined" && d.children != null){
                                     $.each(d.children,function (i,item) {
                                         openSixLayer(item,layer+1);
                                     })
                                }

                            }

                        } else {
                            //还没有展开
                            d.children = d._children;
                            d._children = null;
                            if(layer < 5&& typeof(d.children) !="undefined"&& d.children != null){
                                $.each(d.children,function (i,item) {
                                    openSixLayer(item,layer+1);
                                })
                            }
                        }

                    }

                    //Redraw for zoom
                    function redraw() {
                        //console.log("here", d3.event.translate, d3.event.scale);
                        svg.attr("transform",
                                "translate(" + d3.event.translate + ")"
                                + " scale(" + d3.event.scale + ")");
                    }

                    /*$('.node').hover(function () {
                     //                          console.log(this);
                     var html = '代理编号为：' + 1 + '<br>' +
                     '代理类型为：' + '普通代理' + '<br>' +
                     '推荐人编号为：' + 1 + '<br>';
                     layer.tips(html, this);
                     }, function () {

                     });*/


                }
        );


        /**************************************************/


        //全屏
        $('.fullscreen a').click(function () {
            if ($(this).html() == '全屏') {
                $('#window').css({
                    "position": "absolute",
                    "top": "0px",
                    "left": "0px",
                    "width": full_width + "px",
                    "height": full_height + "px",
                    "border": "0px",
                    "border-radius": "0px"
                });
                $(this).html('退出');
            } else {
                $('#window').css({
                    "position": "relative",
                    "top": "0px",
                    "left": "0px",
                    "border": "1px solid #ccc",
                    "width": this_width + "px",
                    "height": this_height + "px",
                    "border-radius": "5px"
                });
                $(this).html('全屏');
            }
        })


        $('.single-slider').jRange({
            from: 64,
            to: 100,
            step: 1,
            scale: [64, 73, 83, 91, 100],
            format: '%s',
            width: 100,
            showLabels: true,
            showScale: true
        });
    })
</script>
<script>
    $(function () {

        $(document).bind("click", function (e) {
            var target = $(e.target); //表示當前對象，切記，如果沒有e這個參數，即表示整個BODY對象
            if (target.closest(".setting").length == 0) {
                $(".dropdown-menu").hide();
            }
        })
    })
</script>
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




<div class="container">
    <center><br>
        <h1 style="color: #2D93CA">组织视图</h1><br>

        <div style="margin: 10px auto;">
            <div style="height: 20px;float: left; ">
                <div style="width:30px;height: 20px;float: left;background-color: #3697ED"></div>
                <span> &nbsp;&nbsp;有下级</span></div>

            <div style="height: 20px;float: left; ">
                <div style="width:30px;height: 20px;float: left;background-color: #E9F533"></div>
                <span> &nbsp;&nbsp;金牌代理</span></div>

            <div style="height: 20px;float: left; ">
                <div style="width:30px;height: 20px;float: left;background-color: #D4D9DE"></div>
                <span> &nbsp;&nbsp;银牌代理</span></div>

            <div style="height: 20px;float: left; ">
                <div style="width:30px;height: 20px;float: left;background-color: #93EACA"></div>
                <span> &nbsp;&nbsp;普通代理&nbsp;&nbsp;&nbsp;&nbsp;</span></div>


            <?php if($adminid != 1): ?><div style="height: 20px;float: left; ">

                    <div style="width:50px;height: 20px;float: left;text-align: right;">已用：</div>
                    <span style="float: left;"> <?php echo ($childnum); ?>(位)&nbsp;</span>
                    <div style="width:50px;height: 20px;float: left;text-align: right;">剩下：</div>
                    <span style="float: left;"> <?php echo (abs($childnum+(-1092))); ?>(位)&nbsp;</span>
                </div><?php endif; ?>
            <div style="clear: both;"></div>

        </div>

    </center>

    <input id="fid" type="hidden" value="960">
    <input id="reSizeName" type="hidden" value="">
    <input id="reSize" type="hidden" value="">
    <div class="row">
        <div id="window" style="width: 1170px; height: 632px;">
            <div class="fullscreen"><a href="javascript:;">全屏</a></div><!--preserveAspectRatio="xMidYMid none"-->
            <div id="body"></div>
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


<div class="tooltip" style="opacity: 0;"></div>
</body>
</html>