<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/11
 * Time: 19:23
 * PowerBy 万域网络技术团队
 *
 * 公司业绩的逻辑处理
 */

namespace Wanyu\Model;


use Think\Model;


class CompanyachiModel extends Model
{


    /*
     * 获取本月表现前六的人
     *
     * */
    public function getthismonthtop6()
    {
        $adminmodel = D('admin');
        $Achievement = D('Achievement');
        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
        $datenow = time();//现在的时间戳
        $adminids = explode(',', $adminmodel->getadminids() );// 所有id
//        p($adminids);
       /* foreach ($adminids as $ak => $av) {
            $adminids[$ak] = $av['id'];
        }*/
        $top6 = $Achievement->getbestachievement_top6($adminids, $datethismonth, $datenow);//键为 id，值为 钱数
        foreach ($top6 as $id => $money) {
            $serverids = $Achievement->getseveradmins($id, $datethismonth, $datenow);
            $severidsnum = count(explode(',', $serverids));
            $map['otime'] = array(array('gt', $datethismonth), array('lt', $datenow));
            $map['ispass'] = 1;
            $myordernum = D('Order')->where('adminid = ' . $id)->where($map)->count();
            /*p($myordernum);
            p($id);*/
            $top6[$id] = array(
                'seid' => $adminmodel->getseidByAdminid($id),//seid
                'money' => $money,//业绩的pv值
                'severidsnum' => $severidsnum,//直推的人
                'mypronum' => $myordernum  //自己买的订单数
            );
        }
//            p($top6);
        return $top6;
    }


    /*
         * 获取本月表现前50的人
         *
         * */
    public function getthismonthtop50()
    {
        $adminmodel = D('admin');
        $Achievement = D('Achievement');
        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
        $datenow = time();//现在的时间戳
//        $adminids = $adminmodel->field('id')->where('id <> 1')->select();// 所有id
        $adminids = explode(',', $adminmodel->getadminids() );// 所有id

        /*foreach ($adminids as $ak => $av) {
            $adminids[$ak] = $av['id'];
        }*/

        $top50 = $Achievement->getbestachievement_top($adminids, 50, $datethismonth, $datenow);//键为 id，值为 钱数
        foreach ($top50 as $id => $money) {
//            键为 id，值为 钱数 =》某一个id代理时间范围的业绩--自己直推的人的单pv总值，每人只有一张单
            $serverids = $Achievement->getseveradmins($id, $datethismonth, $datenow);
            // p($serverids);
            if ($serverids == '') {
                $severidsnum = 0;
            } else {
                $severidsnum = count(explode(',', $serverids));
            }
            $map['otime'] = array(array('gt', $datethismonth), array('lt', $datenow));
            $map['ispass'] = 1;
            $myordernum = D('Order')->where('adminid = ' . $id)->count();
            /*p($myordernum);
            p($id);*/
            $top50[$id] = array(
                'seid' => $adminmodel->getseidByAdminid($id),//seid
                'money' => $money,//业绩的pv值
                'severidsnum' => $severidsnum,//直推的人
                'mypronum' => $myordernum  //自己买的订单数
            );
        }
//            p($top6);
        return $top50;
    }


    /*
     *
     *获得从2017年1月开始每月的业绩
     *
     *$firsttime z最早的日期，默认是2017-01
     *
     * */

    public function getProfitofCompanyofAllTime($firsttime = "2017-01")
    {
        $allMonthperformance = array();//每个月的业绩的结构数组
        $firsttime = strtotime($firsttime);//最早的月份的时间戳
        $monnum = 1;//计算月份的计数器
        $datethismontht = date('Y-m', time());
        $datethismonth = strtotime($datethismontht);//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳

        $allMonthperformance[$datethismontht] = $this->getProfitofCompany($datethismonth, $datenow);//这个月的
        $allMonthperformance[$datethismontht]['monthtime'] = $datethismonth;//这个月的时间戳
        $allMonthperformance[$datethismontht]['monthstr'] = $datethismontht;//这个月的时间字符串
        while (true) {


            $datemontht = date('Y-m', strtotime("-" . $monnum . " Months", $datethismonth));//从上个月开始的
            // p(date('Y-m-d h:i:s',strtotime("-".$monnum." Months")));
            $datemonth = strtotime($datemontht);//时间戳
            $edatemonth = date('Y-m', strtotime("-" . ($monnum - 1) . " Months", $datethismonth));//从上个月开始的
            $edatemonth = strtotime($edatemonth);
            if ($datemonth >= $firsttime) {
                $allMonthperformance[$datemontht] = $this->getProfitofCompany($datemonth, $edatemonth);
                $allMonthperformance[$datemontht]['monthtime'] = $datemonth;//时间戳
                $allMonthperformance[$datemontht]['monthstr'] = $datemontht;//时间字符串
            } else {
                break;
            }

            $monnum++;
        }
//        p($allMonthperformance);
        return $allMonthperformance;

    }


    /*
     * 获取公司的总业绩和净利润，有时间范围
     * @param $starttime  时间范围上限 可选
     * @param $endtime    时间范围下限 可选
     *   Array
     *   (
     *       [allmoney] => Array
     *           (
     *               [ordernum] => 9
     *               [allpv] => 3330.00
     *               [allprice] => 4500.00
     *           )
     *
     *       [netprofit] => 4155.9
     *       )
     * */
    public function getProfitofCompany($starttime = '', $endtime = '')
    {
        $performance = array();
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }


        $performance['allmoney'] = $this->getAllMoney($starttime, $endtime);//总业绩

        $performance['netprofit'] = $this->getNetProfit($starttime, $endtime);//净利润
        $performance['bonusofallpeople'] = $performance['allmoney']['allprice'] * 0.75 - $performance['netprofit'];//每人的分红的总支出
        // p($performance);
        return $performance;
    }

    /*
     * 获取的公司的总业绩,所有订单的钱
     * @param $starttime  时间范围上限 可选
     * @param $endtime    时间范围下限 可选
     * Array
     *       (
     *           [0] => Array
     *              (
     *                   [ordernum] => 9
     *                   [allpv] => 3330.00
     *                   [allprice] => 4500.00
     *               )
     *
     **       )
     * */
    public function getAllMoney($starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }
        $sql = "SELECT COUNT(o.orderid) as ordernum  , SUM(o.finalpprice) AS allpv,SUM(o.finalprice) AS allprice  FROM wywl_order as o 
WHERE o.otime > " . $starttime . " AND " . " o.otime <=  " . $endtime . "  AND o.ispass = 1";
        $allmoney = $this->query($sql);
        foreach ($allmoney[0] as $k => $v) {
            if ($v == '') {
                //如果有值为空，就把其归零
                $allmoney[0][$k] = 0;
            }
        }
        return $allmoney[0];
    }


    /*
     * 获取的公司的总净利润，= 总业绩(不是pv的) - 总所有人的pv金
     * @param $starttime  时间范围上限 可选
     * @param $endtime    时间范围下限 可选
     *
     * ************太慢的，必须优化***********
     *           *****************
     * */
    public function getNetProfitofcaculate($starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }
        $netprofit = 0;//总净利润
        $allmoney = $this->getAllMoney($starttime, $endtime);//总业绩
        $alldirbonkus = $allindirbonkus = 0;//总的直接开拓pv值 和 总的间接开拓pv值
        $alladminids = D('Admin')->getalladminids();
//        p($alladminids);

        /*待优化的片段*/
        foreach ($alladminids as $id) {
            if ($id['id'] != 1) {
                $alldirbonkus += D('Achievement')->getdirbonkus($id['id'], $starttime, $endtime);//直接奖金
                $allindirbonkus += D('Achievement')->getindirbonus($id['id'], $starttime, $endtime);//间接奖金

            }
        }
        /*待优化的片段*/

        $rate = 0.01;
        $adminmodel = D('Admin');
        $yinnum = $adminmodel->getYinNum();//银牌数量
        $jinnum = $adminmodel->getJinNum();//金牌数量
        if ($yinnum > 0) {
            //有银牌，就加权分红就要多0.01分出去
            $rate += 0.01;
        }

        if ($jinnum > 0) {
            //有金牌，就加权分红就要多0.013分出去
            $rate += 0.03;
        }


        $netprofit = $allmoney['allprice'] * 0.75 - $alldirbonkus - $allindirbonkus - $allmoney['allpv'] * $rate;//净利润

        return $netprofit;

    }


    /*
    * 获取的公司的总净利润，= 总业绩(不是pv的) - 总所有人的pv金,从业绩表里面查出来，查出当前月的业绩
    * @param $starttime  时间范围上限 可选
    * @param $endtime    时间范围下限 可选
    *
    * ************优化后***********
    *           *****************
    * */
    public function getNetProfit($starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }


        $monthmodel = D('month');
        $settlementmsgmodel = D('Settlementmsg');//个人业绩表

        $netprofit = 0;//总净利润

        $allmoney = $this->getAllMoney($starttime, $endtime);//总业绩


        $nowmonthid = $monthmodel->getMonthidByTime(getFirstDaytime($starttime));//当前月的monthid

        $allpvtotal = floatval($settlementmsgmodel->where('monthid = '.$nowmonthid)->sum('pvtotal'));//获得当月分红支出的总和



        $netprofit = $allmoney['allprice'] * 0.75 - $allpvtotal;//净利润,25%成本

        return $netprofit;

    }




    /*
     * 获得所有的人的分红的总和
     *
     * */
    public function getBonusofAllPeople($starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }
        $allmoney = $this->getAllMoney($starttime, $endtime);//总业绩
        $alldirbonkus = $allindirbonkus = 0;//总的直接开拓pv值 和 总的间接开拓pv值
        $alladminids = D('Admin')->getalladminids();
//        p($alladminids);
        foreach ($alladminids as $id) {
            if ($id['id'] != 1) {
                $alldirbonkus += D('Achievement')->getdirbonkus($id['id'], $starttime, $endtime);
                $allindirbonkus += D('Achievement')->getindirbonus($id['id'], $starttime, $endtime);

            }
        }

        $rate = 0.01;
        $adminmodel = D('Admin');
        $yinnum = $adminmodel->getYinNum();//银牌数量
        $jinnum = $adminmodel->getJinNum();//金牌数量
        if ($yinnum > 0) {
            //有银牌，就加权分红就要多0.01分出去
            $rate += 0.01;
        }

        if ($jinnum > 0) {
            //有金牌，就加权分红就要多0.013分出去
            $rate += 0.03;
        }

        $bonusofallpeople = $alldirbonkus + $allindirbonkus + $allmoney['allpv'] * $rate;
        return $bonusofallpeople;

    }


    /*
     *
     * 获得每月的数据情况，从表里面读取计算
     * @param $start 开始位置，默认是0开始，即这个月开始，
     * @param $len
     * @param $option 1 for list 即所有的数据的列表  ，2 for sum 即所有的数据和，默认是 1
     *
     *
     *
     * */
    public function getMonthperformance($start = '', $len = '', $option = 1)
    {
        $allMonthperformance = array();

        if ($start == '') {
            $start = 0;
        }

        if ($len == '') {
            $allMonthperformance = $this->order('monthtime desc')->limit($start)->select();
        } else {
            $allMonthperformance = $this->order('monthtime desc')->limit($start, $len)->select();
        }

        if ($option == 2) {

          $allMonthperformance = array_merge_sum($allMonthperformance);//合并二维数组求和

        }

//        p($this->getLastSql()) ;
        return $allMonthperformance;


    }



    /*
     *
     * 刷新当前月的公司业绩表数据
     *
     * */
    public function refreshperformanceofthismonth(){
        $datethismontht = date('Y-m', time());
        $datethismonth = strtotime($datethismontht);//这个月1号的时间戳

        $monthmodel = D('month');
        $settlementmsgmodel = D('Settlementmsg');//个人业绩表


//            echo $datethismonth;
        $datenow = time();//现在的时间戳
        $nowmonthid = $monthmodel->getMonthidByTime($datethismonth);//当前月的monthid

        $performance = $this->getProfitofCompany($datethismonth,$datenow);//获得这个月的公司业绩
        $performance['monthstr'] = $datethismontht;
        $performance['monthtime'] = $datethismonth;
        $performance['monthid'] = $nowmonthid;


        $performance['allpv'] = $performance['allmoney']['allpv'];
        $performance['allprice'] = $performance['allmoney']['allprice'];
        unset($performance['allmoney']);
//        p($performance);
        if($this->where('monthid = '.$nowmonthid )->count() <=0 ){
            $this->where('monthid = '.$nowmonthid )->add($performance);
        }else{
            $this->where('monthid = '.$nowmonthid )->save($performance);
        }


    }


}