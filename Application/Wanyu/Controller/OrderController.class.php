<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2016/11/10
 * Time: 19:25
 * PowerBy 万域网络技术团队
 * OrderController 控制器 有关order的处理
 */

namespace Wanyu\Controller;


class OrderController extends CommonController
{


    /*
     * 前置操作，用来做导航active，显示当前导航
     * */
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('active', 4);
    }


    /*
     * 默认进入列表页面
     * */
    public function index()
    {
        $this->redirect('Order/orderlist');
    }


    /*
         *
         *订单列表页
         *
         *
         * */


    public function orderlist()
    {
       // echo  getTheSixthBiggestSeid(0);
        $adminmodel = D('admin');
        $achievement = D('Achievement');
       /* $risingsetting = D('Risingsetting');
        $risingsetting->sharesreflash();*/
        $datethismonth =  date('Y-m',time());
        $datethismonth =  strtotime($datethismonth)   ;//这个月1号的时间戳
//            echo $datethismonth;



        

/*****************************************************/
        $datenow = time();//现在的时间戳
        $where = array();
        if (IS_POST||( I('search') == 1 )){
            $where = I();
            //$where['orderid'] = intval($where['orderid']);
            if (!is_numeric($where['orderid'])){
                $where['orderid'] = substr($where['orderid'],2);
            }

            if ($where['ispass'] == 2){
                $where['ispass'] = '';
            }
            $where['adminid'] = $adminmodel->getAdminidBySeid($where['seid']);

            if (trim($where['serverofseid']) !== '' && is_numeric($where['serverofseid']) ){
                //不为空并且为数字的时候，找出他所有的推荐过的人
                $serveradminid = $adminmodel->getAdminidBySeid($where['serverofseid']);
               
//                $serverids = $achievement->getseveradmins($serveradminid,$datethismonth,$datenow);//求出直推的人,自己推荐过的人adminid
                $serverids = $achievement->getseveradmins($serveradminid);
                $where['adminid'] = array('in',$serverids);//
            }

            $where = array_filter($where,function ($var){
               return (trim($var) !== '' );
            });
//            p($where);

            $this->assign('where',$where);
            unset($where['seid']);
            unset($where['nowpage']);
            unset($where['search']);
            unset($where['serverofseid']);
        }


        $adminid = session(C('USER_AUTH_KEY'));
        $order = D('Order');
 

        //分页
        $onepagenum = 8;//每一页的数据条数
        $nowpage = I('nowpage') == '' ? 1 : intval(I('nowpage')); // 发送过来的页码
        $orderlist = $order->getorderlist(($nowpage - 1) * $onepagenum, $onepagenum,$where,'orderid <> 0 ');
       // echo $order->getLastSql();
        $allnum = count($order->getorderlist(0,0,$where,'orderid <> 0 '));
        $pagecount = ceil(floatval($allnum) / floatval($onepagenum));//总页数

        //p($orderlist);

        if (session(C('ADMIN_AUTH_KEY'))) {
            $admins = D('admin')->field('id,username')->select();
//                p($admins);
            $this->assign('admins', $admins);
        }

        foreach ($orderlist as $i => $od) {
            $orderlist[$i]['seid'] = D('admin')->getseidByAdminid($od['adminid']);
        }
         // p($orderlist);

        $this->assign('orderlist', $orderlist);//新的在前面
       // exportexcel($orderlist,array(),'order');
        $risingsetting = D('Risingsetting');
        $risingsetting->sharesreflash();

        $this->assign('allnum', $allnum);
        $this->assign('pagecount', $pagecount);
        $this->assign('nowpage', $nowpage);
        $this->assign('title', "订单管理");
        $this->assign('adminid', $adminid);
        $this->display(); // 输出模板
    }




    /*
     * 进入添加订单添加页
     * **/


    public function orderadd()
    {
        $adminid = session(C('USER_AUTH_KEY'));

        if (session(C('ADMIN_AUTH_KEY'))) {
            $admins = D('admin')->field('id,username,seid')->where(' id <> 1 ')->select();
//                p($admins);
            $this->assign('admins', $admins);
        }

        $this->assign('product', D('product')->select());

        //var_dump($pwlist);
        $risingsetting = D('Risingsetting');
        $risingsetting->sharesreflash();

        $this->assign('title', "添加订单");
        $this->assign('adminid', $adminid);

        $this->display();
    }


    /*
     * 订单添加操作
     *
     * */

    public function orderdoadd()
    {
        $send = I();
        $achievement = D('Achievement');
        $adminmodel = D('admin');
        $productmodel = D('product');
        $orders = D('Order');



        $send['otime'] = time();
        $send['adminid'] = I('sadminid', '', 'htmlspecialchars,trim');


        if($orders->ishaveorder($send['adminid'])){
            //如果有单了，就不能再添加单
            $this->error('已有订单，不能再添加订单！');
        }else{
            $send['pid'] = I('pid', '', 'htmlspecialchars,trim');
            $send['additionalprice'] = I('additionalprice', '', 'htmlspecialchars,trim');
            $send['additionalprice'] = is_numeric($send['additionalprice']) ?
                floatval($send['additionalprice']) : 0;

//            p($send);
            $productmsg = $productmodel->find($send['pid']);//取出商品的信息

            //录入商品信息，价格等
            $send['pprice'] = $productmsg['pprice'];
            $send['price'] = $productmsg['price'];
            $send['pv'] = $productmsg['pv'];
            $send['finalprice'] = floatval($send['price']) + $send['additionalprice'] ;
            $send['finalpprice'] = $send['pprice'];
            $send['additionalpprice'] = 0 /*$send['additionalprice']*floatval($send['pv'])*/;
            //p($send);
            $risingsetting = D('Risingsetting');
            $risingsetting->sharesreflash();

            if ($orders->create($send)) {
                $res = $orders->add();
                if ($res) {
//                $adminmodel->checkUsertype($send['adminid']);//在审核的时候才验证
                    $this->success('新增成功', 'orderlist');
                } else {
                    $this->error('新增订单失败');
                }
            } else {
                $this->error('新增订单失败');
            }
        }



    }


    /*
        *
        *订单搜索页
        *
        *
        * */


    public function ordersearch()
    {
        $adminid = session(C('USER_AUTH_KEY'));
        $send = I();
        $seararr = $send;

//        var_dump($send);
        /*

         array (size=6)
           'ordsear' => string '荣耀8' (length=7)
           'starttime' => string '2016-11-09' (length=10)
           'endtime' => string '2016-11-26' (length=10)
           'pwid' => string '1' (length=1)
           'shipping_status' => string '0' (length=1)
           'order_status' => string '0' (length=1)

        */


        $orders = D('Orders');
        //搜索框需要的内容
        $payway = D('Payway');
        $pwlist = $payway->getallpwlist();
        $this->assign('pwlist', $pwlist);//付款方式
        $this->assign('seararr', $seararr);
        //设置adminid条件
        if (session(C('ADMIN_AUTH_KEY'))) {
            //如果是超级管理员
            $where = array();

        } else {
            $where = array('adminid' => $adminid);
        }
        if (session(C('ADMIN_AUTH_KEY'))) {
            $admins = D('admin')->field('id,username')->select();
//                p($admins);
            $this->assign('admins', $admins);
        }

        //分页
        $onepagenum = 13;//每一页的数据条数
        $nowpage = I('nowpage') == '' ? 1 : intval(I('nowpage')); // 发送过来的页码
        $allnum = count($orders->getsearorderlist($seararr, 0, 0, $where));
        $pagecount = ceil(floatval($allnum) / floatval($onepagenum));//总页数


        //搜索处理
        $orderlist = $orders->getsearorderlist($seararr, ($nowpage - 1) * $onepagenum, $onepagenum, $where);

//        $orderlist = $orders->getorderlist(($nowpage-1)*$onepagenum,$onepagenum);
        //var_dump($allnum);
        $this->assign('searorderlist', $orderlist);

        $risingsetting = D('Risingsetting');
        $risingsetting->sharesreflash();
        $this->assign('allnum', $allnum);
        $this->assign('pagecount', $pagecount);
        $this->assign('nowpage', $nowpage);
        $this->assign('title', "订单管理");
        $this->assign('adminid', $adminid);
        $this->display(); // 输出模板
    }


    /*
     * order编辑页
     * orderedit（）
     * */


    public function orderedit()
    {
        $send = I();
        $oid = $send['oid'];
        $adminid = session(C('USER_AUTH_KEY'));
//        print_r($oid);
        $order = D('Order');
        $od = $order->find($oid);
//        var_dump($oid);
        /*  $pw = D('Payway');
          $pwlist = $pw->getallpwlist();
          $spemenu = D('Spemenu');
          $sm = $spemenu->getmenubysmid($od['smid']);
          $smlist = $spemenu->getmenulist($od['pid']);*/
        //var_dump($smlist);

        if (session(C('ADMIN_AUTH_KEY'))) {
            $admins = D('admin')->field('id,username,seid')->where(' id <> 1 ')->select();
//                p($admins);
            $this->assign('admins', $admins);
        }

        $this->assign('product', D('product')->select());

        /*
                $this->assign('smlist',$smlist);//套餐列表
                $this->assign('pwlist',$pwlist);//支付方式*/
        $risingsetting = D('Risingsetting');
        $risingsetting->sharesreflash();

        $this->assign('od', $od);//订单
        $this->assign('title', "编辑订单");
        $this->assign('adminid', $adminid);
        $this->assign('orderid', $oid);

        $this->display();


    }


    /*
     * 修改补充订单操作
     * */

    public function orderchg()
    {
        $send = I();


        $productmodel = D('product');
        $adminmodel = D('admin');

        $order = D('Order');
        if (!$order->getispass($send['orderid']) ){
            //没有审核的才可以改
            $send['adminid'] = I('sadminid', '', 'htmlspecialchars,trim');//要修改的adminid
            //print_r($send);

            if(($order->ishaveorder($send['adminid']))&& ($send['adminid']/*修改的*/ != $send['oradminid']/*原来的*/ ) ){
                //如果有单了，就不能再添加单
                $this->error('该工号代理已有订单！修改失败');
            }else{
                $send['pid'] = I('pid', '', 'htmlspecialchars,trim');
                $send['additionalprice'] = I('additionalprice', '', 'htmlspecialchars,trim');
                $send['additionalprice'] = is_numeric($send['additionalprice']) ?
                    floatval($send['additionalprice']) : 0;

//            p($send);
                $productmsg = $productmodel->find($send['pid']);//取出商品的信息

                //录入商品信息，价格等
                $send['pprice'] = $productmsg['pprice'];
                $send['price'] = $productmsg['price'];
                $send['pv'] = $productmsg['pv'];
                $send['finalprice'] = floatval($send['price']) + $send['additionalprice'] ;
                $send['finalpprice'] = $send['pprice'];
                $send['additionalpprice'] =0 /*$send['additionalprice']*floatval($send['pv'])*/;
                $od = $send;
                $saadminid = $od['sadminid'];
                $oradminid = $od['oradminid'];
                unset($od['sadminid']);
                unset($od['oradminid']);
//        p($od);

                if ($order->create($od)) {
                    $res = $order->save($od);
                    $adminmodel->checkUsertype($adminmodel->getpid($saadminid));
                    $adminmodel->checkUsertype($adminmodel->getpid($oradminid));

                    if ($res === false) {

                        $this->error('修改失败');
                    } else {
                        $this->success('修改成功', 'orderlist');
                    }
                    $risingsetting = D('Risingsetting');
                    $risingsetting->sharesreflash();
                } else {
                    echo $order->getError();
                }
            }



        }else{
            $this->error('订单已经审核，不能修改');
        }






    }


    /*
     *删除一个数据
     *
     * */

    public function orderdel()
    {
        if(session(toexaminepass)) {
            $send = I();

            $adminmodel = D('admin');
            $orderid = $send['orderid'];
            $map['orderid'] = $orderid;
            $order = D('Order');
            $adminid = $order->field('adminid')->find($orderid);//找到删除订单的adminid
            $adminid = $adminid['adminid'];
            $res = $order->where($map)->delete();
            if ($res === false) {
                echo 0;
            } else {

                $adminmodel->checkUsertype($adminmodel->getpid($adminid));
                echo 1;
            }
            $risingsetting = D('Risingsetting');
            $risingsetting->sharesreflash();
        }else{
            //没有权限就返回错误的提示
            echo "你没权限操作，请登录审核员";
        }

    }

    /*
     * 批量删除
     * */

    public function ordermanydel()
    {
        if(session(toexaminepass)) {
            $send = I();
            $adminmodel = D('admin');
            //print_r($send);
            /*Array
            (
                [oids] => Array
                (
                    [0] => 3
                    [1] => 2
                    [2] => 4
                 )

            )*/
            $oids = $send['oids'];

            $map['orderid'] = array('in', $oids);
            $order = D('Order');
            $aids = array();
            foreach ($oids as $oid) {
                $aid = $order->field('adminid')->find($oid);
                array_push($aids, $aid['adminid']);
            }
            $aids = array_unique($aids);
            //print_r($aids);
            $res = $order->where($map)->delete();

            if ($res === false) {
                echo 0;
            } else {


                foreach ($aids as $id) {
//                    $adminmodel->checkUsertype($id);
                    $adminmodel->checkUsertype($adminmodel->getpid($id));
                }
                echo 1;
            }
            $risingsetting = D('Risingsetting');
            $risingsetting->sharesreflash();
        }else{
                //没有权限就返回错误的提示
                echo "你没权限操作，请登录审核员";
            }


    }




    /*
     *
     * orderpass
     * 通过订单审核,或者取消 toggle
     *
     * */

    public function ordertogglepass(){

        if(session(toexaminepass)){
            //有权限才可以操作
            $send = I();
            $adminmodel = D('admin');
//        print_r($send);
            $ordermodel = D('order');
            $ispass = $ordermodel->field('ispass,orderid')->find($send['oid']);
            $adminid = $ordermodel->getadminidByOrderid($send['oid']);
//        $ispass = $ispass['ispass'];
            if ($ispass['ispass'] != 1 ){
                //没有通过，令其通过
                $ispass['ispass'] = 1;
                $ispass['otime'] = time();//下单时间
                if ($ordermodel->save($ispass) !==false){

                    //更新代理的注册时间，审核后才叫做真正的注册成功

                    $ad['id'] = $adminid;
                    $ad['registertime'] = time();//注册时间
                    $ad['logintime'] = time();//登录时间
                    $ad['islock'] = 1;//表示已经激活
                    $ut = $adminmodel->field('usertype')->find($adminid);//usertype
                    $ut = intval($ut['usertype']);
                    switch ($ut){
                        case 1 :{
                            //普通代理
                            $ad['yintime'] = null;//银牌时间
                            $ad['jintime'] = null;//金牌时间
                            break;
                        }
                        case 2 :{
                            //银牌
                            $ad['yintime'] = time();//银牌时间
                            $ad['jintime'] = null;//金牌时间
                            break;
                        }
                        case 3 :{
                            //金牌
                            $ad['yintime'] = time();//银牌时间
                            $ad['jintime'] = time();//金牌时间
                            break;
                        }
                        default :{
                            $ad['yintime'] = null;//银牌时间
                            $ad['jintime'] = null;//金牌时间
                            break;
                        }
                    }


                    $adminmodel->save($ad);
                    echo 1;
                }

            }else{
                //本通过，现在取消审核
                $ispass['ispass'] = 0;
                if ($ordermodel->save($ispass) !==false){
                    $ad2['id'] = $adminid;
                    $ad2['registertime'] = null;//注册时间
                    $ad2['yintime'] = null;//银牌时间
                    $ad2['jintime'] = null;//金牌时间
                    $ad2['logintime'] = null;//登录时间
                    $ad2['islock'] = 0;//表示已经激活
                    $adminmodel->save($ad2);
                    echo 0;
                }
            }
            $adminid = $ordermodel->getadminidByOrderid($send['oid']);
            $adminmodel->checkUsertype($adminid);
            $adminmodel->checkUsertype($adminmodel->getpid($adminid));
            $risingsetting = D('Risingsetting');
            $risingsetting->sharesreflash();//刷新股权

            $settlementmsgmodel = D('settlementmsg');
            $settlementmsgmodel->refreshmsgByAdminidAndTreepidAndPid($adminid);//刷新业绩
            $settlementmsgmodel->refreshTop6Encbonus();//刷新前六分红的数据
            $settlementmsgmodel->refreshAverageBonus();//刷新金银牌加权分红
            $companyachimodel = D('companyachi');//公司业绩表
            $companyachimodel->refreshperformanceofthismonth();//刷新当月的总业绩表

        }else{
            //没有权限就返回错误的提示
            echo "你没权限操作，请登录审核员";
        }

    }


}