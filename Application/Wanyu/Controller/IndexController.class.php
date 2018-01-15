<?php
namespace Wanyu\Controller;
use Think\Controller;

/**
 * Created by PhpStorm.
 * User: lili
 * Date: 2016/11/1
 * Time: 14:00
 *
 * 万域网络公司开发
 * Index控制器
 */
class IndexController extends CommonController {


    /*
     * 前置操作，用来做导航active，显示当前导航
     * */
    public function _initialize (){
         parent::_initialize();
        $this->assign('active',1);
    }


    /*代理商的跳转页面 ，包括普通的代理 ，银牌，和金牌*/
    public function index(){
          if (session(C('ADMIN_AUTH_KEY')) ){
              $this->redirect(MODULE_NAME . '/Index/companyindex');
          }


            $adminid = session('adminid');
        $adminmodel = D('Admin');
        $admin = $adminmodel->field('seid,usertype')->find($adminid);

        /*pv值的计算*/
        $bonus = D('Achievement')->getachievementmsglasttwomonth($adminid);//
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
        $sao = $adminmodel->getServeridsAndOrder($adminid);
        $saoofMonth = $adminmodel->getServeridsAndOrderOfMonth($adminid);//获得个人的直推人和自己的订单 每个月的情况

        $achievementmodel  = D('Achievement');
        $monthmodel  = D('month');//月份表

        //所有月份的业绩,键是月份
        $allMonthperformance = $achievementmodel->getachievementmsgofallmonth($adminid);
        $allMonthperformance = $achievementmodel->startandachievementmsgofallmonth($allMonthperformance);
        $pvtotalofallmonth = $achievementmodel->getpvtotalofallmonth($allMonthperformance);



        $lasttowmonthperformance = array_slice($allMonthperformance,-2);
        if (count($lasttowmonthperformance) == 1){
            //当月注册  ，插入一个空的数组
            array_push($lasttowmonthperformance, array());
            $lasttowmonthperformance = array_reverse($lasttowmonthperformance);

        }
        /*p($allMonthperformance);
        p($pvtotalofallmonth);*/
        $allMonthperformance = array_reverse($allMonthperformance);///所有月份的业绩
        $months = $monthmodel->getMonthsMsg();//获得所有月份的信息



        $this->assign('lastmonth', $lastmonth);
        $this->assign('thismonth', $thismonth);
        $this->assign('adminid', $adminid);
        $this->assign('bonus', $bonus);
        $this->assign('admin', $admin);
        $this->assign('layermsg', $layermsg);
        $this->assign('layerdetailmsg', $layerdetailmsg);
        $this->assign('sao', $sao);

        $this->assign('saoofMonth', $saoofMonth);
        $this->assign('month', $months);//获得所有月份的信息
        $this->assign('pvtotalofallmonth', $pvtotalofallmonth);//获得历史以来的pv总分红的总额,实际奖金的总额，还有累计的碧玉豆
        $this->assign('lasttowmonthperformance', $lasttowmonthperformance);//最近两个月的业绩
        $this->assign('allMonthperformance', $allMonthperformance);//所有月份的业绩


            $this->display();
    }

    /*代理商的跳转页面,公司的登录*/
    /**
     *
     */
    public function companyindex(){
        $adminid = session('adminid');

        $adminmodel = D('Admin');
        $admin = $adminmodel->field('seid,usertype')->find($adminid);

        /*pv值的计算*/
//        $bonus =D('Achievement')->getachievementmsglasttwomonth($adminid);
        $lastmonth = date("m",strtotime("-1 Months")) ;
        $thismonth = date("m",time()) ;

        $datelastmonth =  date('Y-m',strtotime("-1 Months"));
        $datelastmonth =  strtotime($datelastmonth)   ;//上个月1号的时间戳

        $datethismonth =  date('Y-m',time());
        $datethismonth =  strtotime($datethismonth)   ;//这个月1号的时间戳

        $datenow = time();//现在的时间戳

        /*每一次的情况，团队情况*/
        $levelmsg = $adminmodel->getLevelMagArr($adminid);//每一层的seid

        $layerdetailmsg = $adminmodel->gatherLayerDetailMsg($adminid,$levelmsg);//每一层的详细信息，直推和间推，不同类型的代理





        /*****卡的地方******/


        /*
         *
        $Companyachi = D('Companyachi');
        原来的方法，很卡，存储在数据库在调用出来
        $allMonthperformance = $Companyachi->getProfitofCompanyofAllTime();//公司每月业绩，最早到2017年1月
        $sixMonthperformance = $Companyachi->getProfitofCompany(strtotime(date('Y-m',strtotime("-5 Months"))),time());//半年的业绩
        $performance = $Companyachi->getProfitofCompany();//历史以来的公司业绩

        $amp = $allMonthperformance;
        foreach ($amp as $ampk => $ampv ){
            $amp[$ampk]['allprice'] =  $ampv['allmoney']['allprice'];
            $amp[$ampk]['allpv'] =  $ampv['allmoney']['allpv'];
            unset($amp[$ampk]['allmoney']);
        }
        p(array_values($amp));
        $companyachimodel = D('companyachi');
        $companyachimodel->addAll(array_values($amp));//添加在数据库，重新添加数据库
        */
        
        
        

        $companyachimodel = D('companyachi');//公司业绩表
        $allMonthperformance = $companyachimodel->getMonthperformance();
//
        $sixMonthperformance = $companyachimodel->getMonthperformance(0,6,2);
//          p($sixMonthperformance);
        $performance = $companyachimodel->getMonthperformance('','',2);







        /*****卡的地方******/

        $this->assign('lastmonth',$lastmonth);
        $this->assign('thismonth',$thismonth);
//        $this->assign('bonus',$bonus);
        $this->assign('admin',$admin);
//        $this->assign('layermsg',$layermsg);
        $this->assign('layerdetailmsg',$layerdetailmsg);//每一层的详细信息，直推和间推，不同类型的代理
        $this->assign('allMonthperformance',$allMonthperformance);//公司每月业绩，最早到2017年1月
        $this->assign('sixMonthperformance',$sixMonthperformance);//半年的业绩
        $this->assign('performance',$performance);//公司每月业绩，最早到2017年1月

        $this->assign('title','分销系统-公司管理页面');

        $this->display();
    }
}