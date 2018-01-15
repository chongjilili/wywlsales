<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/11
 * Time: 17:18
 * PowerBy 万域网络技术团队
 * 业绩计算系统
 */

namespace Wanyu\Controller;


class AchievementController extends CommonController
{


        /*
         * 前置操作，用来做导航active，显示当前导航
         * */
    public function _before_index()
    {
        $this->assign('active', 2);
    }

    public function _before_picture()
    {
        $this->assign('active', 3);
    }

    public function _before_companyprofit()
    {
        $this->assign('active', 2);
    }


    /*代理业绩页面*/
    public function index()
    {   set_time_limit(0);
         
        $adminmodel = D('Admin');
        $adminid = I('adminid', '', 'htmlspecialchars,trim');
        $admin = $adminmodel->field('seid,usertype')->find($adminid);
        $achievementmodel  = D('Achievement');
        $monthmodel  = D('month');//月份表
        $settlementmsgmodel = D('Settlementmsg');

        /*pv值的计算*/
//        $bonus = $achievementmodel->getachievementmsglasttwomonth($adminid);//奖金信息
        $lastmonth = date("m", strtotime("-1 Months"));
        $thismonth = date("m", time());
       
        /*每一次的情况，团队情况*/
        $levelmsg =$adminmodel->getLevelMagArr($adminid);//每一层的seid
        $levelmsg = array_splice($levelmsg, 0, 6);//前六层
//         p($levelmsg);
        $layermsg = $adminmodel->gatherLayernummsg($adminid, $levelmsg);//团队情况
//         p($layermsg);
        $layerdetailmsg = $adminmodel->gatherLayerDetailMsg($adminid, $levelmsg);
//         p($layerdetailmsg);
//         var_dump(D('Admin')->isThisMonthAddOfSeid(5));
        $sao = $adminmodel->getServeridsAndOrder($adminid);//业绩总概况
        $saoofMonth = $adminmodel->getServeridsAndOrderOfMonth($adminid);//获得个人的直推人和自己的订单 每个月的情况

//         $achievementmodel->getencbonus($adminid,strtotime('2017-03'),time());


        //所有月份的业绩,键是月份
        $allMonthperformance = $achievementmodel->getachievementmsgofallmonth($adminid);
        $allMonthperformance = $achievementmodel->startandachievementmsgofallmonth($allMonthperformance);
//        p($allMonthperformance);
        $pvtotalofallmonth = $achievementmodel->getpvtotalofallmonth($allMonthperformance);


//        $settlementmsgmodel->refreshmsgByAdminid($adminid);


//        $settlementmsgmodel->refreshTop6Encbonus();

        $lasttowmonthperformance = array_slice($allMonthperformance,-2);
        if (count($lasttowmonthperformance) == 1){
            //当月注册  ，插入一个空的数组
            array_push($lasttowmonthperformance, array());
            $lasttowmonthperformance = array_reverse($lasttowmonthperformance);

        }



//        p($lasttowmonthperformance);
        /* p($pvtotalofallmonth);*/
        $allMonthperformance = array_reverse($allMonthperformance);///所有月份的业绩

        $months = $monthmodel->getMonthsMsg('',$adminid);//获得所有月份的信息
//        p($months);
//        p($saoofMonth);






        $indirseidofmonth =  $adminmodel->getIndirSeidsOfMonth($adminid);//每个月的新增间接seid
//        p($indirseidofmonth);







        $this->assign('lastmonth', $lastmonth);
        $this->assign('thismonth', $thismonth);
        $this->assign('adminid', $adminid);
//        p($adminid);
//        $this->assign('bonus', $bonus);
        $this->assign('admin', $admin);
        $this->assign('layermsg', $layermsg);
        $this->assign('layerdetailmsg', $layerdetailmsg);
        $this->assign('sao', $sao);
        $this->assign('saoofMonth', $saoofMonth);
        $this->assign('month', $months);//获得所有月份的信息
        $this->assign('pvtotalofallmonth', $pvtotalofallmonth);//获得历史以来的pv总分红的总额,实际奖金的总额，还有累计的碧玉豆
        $this->assign('lasttowmonthperformance', $lasttowmonthperformance);//最近两个月的业绩
        $this->assign('allMonthperformance', $allMonthperformance);//所有月份的业绩
        $this->assign('indirseidofmonth', $indirseidofmonth);//每个月的新增间接seid
        $this->display();
    }


    /*
     *组织视图页面
     *
     * */
    public function picture()
    {

        $adminid = I('adminid', '', 'htmlspecialchars,trim');
        $adminmodel = D('admin');
//          echo $adminid;
        if ($adminid == '') {
            $adminid = session('adminid');
        }

        cookie('adminidy', cookie('adminid'));
        cookie('adminid', $adminid);
        $json_arr = $adminmodel->picjson($adminid);//刷新页面,把树图数据传进seidtree.json文件

        $childnum = $adminmodel->getChildrenNum($json_arr) ;//旗下的人数 ，子孙
        $this->assign('childnum',$childnum);
        $this->assign('adminid',$adminid);
        $this->display();

    }


    /*
     * 公司业绩页面
     *
     *
     * */

    public function companyprofit()
    {
        set_time_limit(0);
        $adminid = I('adminid', '', 'htmlspecialchars,trim');
        $adminmodel = D('Admin');
        $admin = $adminmodel->field('seid,usertype')->find($adminid);

        /*pv值的计算*/
        $bonus = D('Achievement')->getachievementmsglasttwomonth($adminid);//
        $lastmonth = date("m", strtotime("-1 Months"));
        $thismonth = date("m", time());

        $datelastmonth = date('Y-m', strtotime("-1 Months"));
        $datelastmonth = strtotime($datelastmonth);//上个月1号的时间戳
//           echo $datelastmonth;
        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳

        /*每一次的情况，团队情况*/
        $levelmsg = $adminmodel->getLevelMagArr($adminid);//每一层的seid
        /*$levelmsg = array_splice($levelmsg, 0,6);//前六层*///公司不要限制层数
//         p($levelmsg);
        $layermsg = $adminmodel->gatherLayernummsg($adminid, $levelmsg);//团队情况
//         p($layermsg);
        $layerdetailmsg = $adminmodel->gatherLayerDetailMsg($adminid, $levelmsg);//每一层的详细信息，直推和间推，不同类型的代理
//         p($layerdetailmsg);
//         var_dump(D('Admin')->isThisMonthAddOfSeid(5));

        $companyachimodel = D('companyachi');//公司业绩表



        /****新增的注册的人，新增的金银牌的代理*/
        $newpeople = $adminmodel->getNewPeopleOfAllTime();
        //p($newpeople);


        /*******卡******/
       /* $allMonthperformance = $Companyachi->getProfitofCompanyofAllTime();//公司每月业绩，最早到2017年1月
        $sixMonthperformance = $Companyachi->getProfitofCompany(strtotime(date('Y-m', strtotime("-5 Months"))), time());//半年的业绩
        $performance = $Companyachi->getProfitofCompany();//历史以来的公司业绩*/
        /*******卡******/

        //公司业绩
        $allMonthperformance = $companyachimodel->getMonthperformance();
        $sixMonthperformance = $companyachimodel->getMonthperformance(0,6,2);
        $performance = $companyachimodel->getMonthperformance('','',2);


        $top50 = $companyachimodel->getthismonthtop50();//前50名




        /***********折线图***卡**************/
        $sixMontharea2d = $companyachimodel->getMonthperformance(0,6);//公司每月业绩，最早到半年前，作为折线图的数据
//        p($sixMontharea2d);


        //p($sixmonths);
        $sixallprice = array();//六个月的总业绩的值
        $sixnetprofit = array();//六个月的总净利润的值
        $sixmonths = array();//六个月的值
        foreach ($sixMontharea2d as $sma2v){
            array_push($sixallprice, $sma2v['allprice']);
            array_push($sixnetprofit, $sma2v['netprofit']);
            array_push($sixmonths, $sma2v['monthstr']);
        }

        $sixmonths = '"' . implode('","',array_reverse($sixmonths) ) . '"';
        $sixallprice = implode(',', array_reverse($sixallprice));
        $sixnetprofit = implode(',', array_reverse($sixnetprofit));
        /***********折线图***卡**************/







        $this->assign('lastmonth', $lastmonth);
        $this->assign('thismonth', $thismonth);
        $this->assign('bonus', $bonus);
        $this->assign('admin', $admin);
        $this->assign('layermsg', $layermsg);
        $this->assign('layerdetailmsg', $layerdetailmsg);//每一层的详细信息，直推和间推，不同类型的代理
        $this->assign('allMonthperformance', $allMonthperformance);//公司每月业绩，最早到2017年1月
        $this->assign('sixMonthperformance', $sixMonthperformance);//半年的业绩
        $this->assign('performance', $performance);//公司每月业绩，最早到2017年1月
        $this->assign('top50', $top50);//这个月的业绩前六的人

        $this->assign('newpeople', $newpeople);//这个月的业绩前六的人
/******************************************************************************/
        $this->assign('m_account',$adminmodel->getMenberGroupBytype());


/************************************折线图*******************************************/
        $this->assign('sixmonths', $sixmonths);//升序,前六个月
        $this->assign('sixallprice', $sixallprice);//六个月的总业绩的值
        $this->assign('sixnetprofit', $sixnetprofit);//六个月的总净利润的值
        $this->display();
    }







     





}