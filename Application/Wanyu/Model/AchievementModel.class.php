<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/11
 * Time: 19:23
 * PowerBy 万域网络技术团队
 *
 * 业绩的逻辑处理
 */

namespace Wanyu\Model;


use Think\Model;


class AchievementModel extends Model
{
    /*
     * ************************
     * 计算代理的最近两个月的业绩
     * 直接开拓pv总值，开拓了的人买的商品提成，15% dirbonus
     * 激励金    每月的业绩1%的分红   encbonus
     * 间接开拓奖金  树网下的人给的分红，8% indirbonus
     * @param $adminid 根据id；来计算业绩
     *
     *
     * */
    public function getachievementmsglasttwomonth($adminid)
    {


        $bonus = array(
            'dirbonus' => array(),//直接开拓pv总值 0 为上个月，1为这个月，2是俩个月的总和，下面的以此类推
            'encbonus' => array(),//激励金
            'indirbonus' => array(),//间接开拓奖金
            'sumbonus' => array(),//总和

        );
        $adminmodel = D('Admin');

        $this->getAverageBonus($adminid);

        /************计算直接开拓pv总值start*******************/


        $where = array('pid' => $adminid);
        $severadmins = $adminmodel->where($where)->field('id,seid,usertype')->select();// 他直推的人

//          p($severadmins);

//格式化，取出月份
        $datelastmonth = date('Y-m', strtotime("-1 Months"));
        $datelastmonth = strtotime($datelastmonth);//上个月1号的时间戳
//           echo $datelastmonth;
        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳

//           echo $datenow;
        /*************************************************************/
        /* $serverids = $this->getseveradmins($adminid);


         $sqllastmonth = "SELECT  a.id as adminid ,o.orderid ,o.otime AS 'ordertime', SUM(p.pprice) as sumprice  FROM wywl_order as o
          LEFT   JOIN wywl_admin as a ON a.id = o.adminid
          LEFT JOIN wywl_product AS p ON o.pid = p.pid
           WHERE  a.id IN( ".$serverids.")
          AND  o.otime > ".$datelastmonth." AND  o.otime < ".$datethismonth." ";


         $sqlthismonth = "SELECT  a.id as adminid ,o.orderid ,o.otime AS 'ordertime', SUM(p.pprice) as sumprice  FROM wywl_order as o
          LEFT   JOIN wywl_admin as a ON a.id = o.adminid
          LEFT JOIN wywl_product AS p ON o.pid = p.pid
           WHERE  a.id IN( ".$serverids.")
          AND  o.otime > ".$datethismonth." AND  o.otime < ".$datenow." ";




         if( ($lastmonthdirbonusarr =  $this->query($sqllastmonth)) !== false   ){
             $lastmonthdirbonusarr = intval($lastmonthdirbonusarr[0]['sumprice'] == 0 ? 0 : $lastmonthdirbonusarr[0]['sumprice'] )*0.15;
         }

         if( ($thismonthdirbonusarr =  $this->query($sqlthismonth)) !== false   ){
             $thismonthdirbonusarr = intval($thismonthdirbonusarr[0]['sumprice'] == 0 ? 0 : $thismonthdirbonusarr[0]['sumprice'] )*0.15;
         }*/


        /***********录入开拓奖金**********/
        $bonus['dirbonus'][0] = $this->getdirbonkus($adminid, $datelastmonth, $datethismonth);//上个月直接开拓pv总值
        $bonus['dirbonus'][1] = $this->getdirbonkus($adminid, $datethismonth, $datenow);//这个月直接开拓pv总值
        $bonus['dirbonus'][2] = $bonus['dirbonus'][0] + $bonus['dirbonus'][1];//俩个月综合直接开拓pv总值
        $bonus['dirbonus'][3] = "直接开拓pv总值";

        /************  计算直接开拓pv总值 end  *******************/


        /************  计算激励金 start  *******************/
        $percent = array(0.5, 0.15, 0.15, 0.666, 0.666, 0.666);//激励分红的百分比分红


        $sqllastmonth_enc = "SELECT SUM(o.finalpprice) AS sumprice FROM wywl_order as o 
            LEFT JOIN wywl_product as p
            ON o.pid = p.pid
            WHERE o.otime  >  " . $datelastmonth . " AND o.otime  <  " . $datethismonth . "  AND o.ispass = 1";

        $sqlthismonth_enc = "SELECT SUM(o.finalpprice) AS sumprice FROM wywl_order as o 
            LEFT JOIN wywl_product as p
            ON o.pid = p.pid
            WHERE o.otime  > " . $datethismonth . " AND o.otime  < " . $datenow . " " . "  AND o.ispass = 1";

        /*上个月的1% 作为激励奖金*/
        if (($lastmonthencbonusarr = $this->query($sqllastmonth_enc)) !== false) {
            $lastmonthencbonusarr = floatval($lastmonthencbonusarr[0]['sumprice'] == 0 ? 0 : $lastmonthencbonusarr[0]['sumprice']) * 0.01;
        }


//            p($sqllastmonth_enc);


        $adminids = $adminmodel->field('id')->where('id <> 1')->select();// 所有id

        foreach ($adminids as $ak => $av) {
            $adminids[$ak] = $av['id'];
        }

        $lastmontop6 = $this->getbestachievement_top6($adminids, $datelastmonth, $datethismonth);
//            p($lastmontop6);

        if (array_key_exists($adminid, $lastmontop6)) {
            $top = 0;
            foreach ($lastmontop6 as $ltk => $ltv) {
                $top++;
                if (intval($ltk) == intval($adminid)) {
                    break;
                }
            }
            $bonus['encbonus'][0] = $lastmonthencbonusarr * $percent[$top - 1];
        } else {
            $bonus['encbonus'][0] = 0;
        }

        /*这个月的1% 作为激励奖金*/
        if (($thismonthencbonusarr = $this->query($sqlthismonth_enc)) !== false) {

            $thismonthencbonusarr = floatval($thismonthencbonusarr[0]['sumprice'] == 0 ? 0 : $thismonthencbonusarr[0]['sumprice']) * 0.01;
        }

        $thismontop6 = $this->getbestachievement_top6($adminids, $datethismonth, $datenow);//前六的人

        if (array_key_exists($adminid, $thismontop6)) {
            $top = 0;
            foreach ($thismontop6 as $ttk => $ttv) {
                $top++;

                if (intval($ttk) == intval($adminid)) {
                    break;
                }

            }

            $bonus['encbonus'][1] = $thismonthencbonusarr * $percent[$top - 1];

        } else {
            $bonus['encbonus'][1] = 0;
        }

        $bonus['encbonus'][2] = $bonus['encbonus'][0] + $bonus['encbonus'][1];
        $bonus['encbonus'][3] = "每月前六分红";


        /****************************  计算激励金 end  *********************************/

        /****************************  计算间接开拓pv总值 start  *********************************/

        $bonus['indirbonus'][0] = $this->getindirbonus($adminid, $datelastmonth, $datethismonth);
        $bonus['indirbonus'][1] = $this->getindirbonus($adminid, $datethismonth, $datenow);
        $bonus['indirbonus'][2] = $bonus['indirbonus'][0] + $bonus['indirbonus'][1];
        $bonus['indirbonus'][3] = "间接开拓pv总值";

        /****************************  计算间接开拓pv总值 end  *********************************/


        /*********************************** 银牌和金牌加权分红 start*************************************/
        $bonus['saveragebonus'][0] = $this->getAverageBonus($adminid, $datelastmonth, $datethismonth);
        $bonus['saveragebonus'][1] = $this->getAverageBonus($adminid, $datethismonth, $datenow);
        $bonus['saveragebonus'][2] = $bonus['averagebonus'][0] + $bonus['averagebonus'][1];
        $bonus['saveragebonus'][3] = "金银牌加权分红";


        /*********************************** 银牌和金牌加权分红 end*************************************/


        /****************************  汇总奖金    *******************************************/
        $bonus['sumbonus'][0] = $bonus['dirbonus'][0] + $bonus['indirbonus'][0] + $bonus['encbonus'][0] + $bonus['saveragebonus'][0];
        $bonus['sumbonus'][1] = $bonus['dirbonus'][1] + $bonus['indirbonus'][1] + $bonus['encbonus'][1] + $bonus['saveragebonus'][1];
        $bonus['sumbonus'][2] = $bonus['sumbonus'][0] + $bonus['sumbonus'][1];
        $bonus['sumbonus'][3] = "总pv总值";
        ksort($bonus);//按照键来排序

        return $bonus;
        /* Array
         (
             [dirbonus] => Array
             (
                  [0] => 0
                  [1] => 90
                  [2] => 90
                      )

          [encbonus] => Array
                 (
                  [0] => 0
                  [1] => 7
                  [2] => 7
              )

          [indirbonus] => Array
                 (
                  [0] => 0
                  [1] => 32
                  [2] => 32
                 )

          [sumbonus] => Array
                 (
                  [0] => 0
                  [1] => 129
                  [2] => 129
              )

      )*/
    }


    /*
     * 获得前六的业绩分红
     *
     *
     *
     * */

    public function getencbonus($adminid, $starttime = '', $endtime = '')
    {
        /*******************************************
         * 取消了前六分红


         if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }

        $percent = array(0.5, 0.15, 0.15, 0.666, 0.666, 0.666);//激励分红的百分比分红

        $adminmodel = D('Admin');

        if ($adminmodel->isislock($adminid)) {
            //代理要激活的才计算，没有激活直接返回0
            $monthencbonus = $this->getMonthencbonusOfTime($starttime, $endtime);//总业绩
            $monthencbonus = $monthencbonus * 0.01;//1% 做分红


            $adminids = explode(',', $adminmodel->getadminids());// 所有id
//        p($adminmodel->getadminids());


            $lastmontop6 = $this->getbestachievement_top6($adminids, $starttime, $endtime);


            if (array_key_exists($adminid, $lastmontop6)) {
                $top = 0;
                foreach ($lastmontop6 as $ltk => $ltv) {
                    $top++;
                    if (intval($ltk) == intval($adminid)) {
                        break;
                    }
                }
                $encbonus['encbonus'] = $monthencbonus * $percent[$top - 1];
            } else {
                $encbonus['encbonus'] = 0;
            }


//        p($adminids);
            return $encbonus['encbonus'];
        } else {
            return 0;
        }
         ************************************************************************************/
        return 0 ;

    }


    /*
     *
     * 获得某段时间的总业绩,
     * 就是公司所有的订单pv值相加
     *
     * */
    public function getMonthencbonusOfTime($starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }

        $sqlmonth_enc = "SELECT SUM(o.finalpprice) AS sumprice FROM wywl_order as o 
            WHERE o.otime  >  " . $starttime . " AND o.otime  <=  " . $endtime . "  AND o.ispass = 1";
        $monthencbonus = 0;
        /*月业绩的1% 作为业绩分红*/
        if (($monthencbonusarr = $this->query($sqlmonth_enc)) !== false) {
            $monthencbonus = floatval($monthencbonusarr[0]['sumprice'] == 0 ? 0 : $monthencbonusarr[0]['sumprice']);
        }
//        echo $this->getLastSql();
        // echo $monthencbonus;
        return $monthencbonus;
    }


    /*
     *
     *
     *    加权分红（pv值）
     *    代理：1092位* 7%；
     *    银牌月分红：1%；（每个银牌平均分成）
     *    金牌月分红：3%；（每个金牌平均分成）
     *    现在是求某个代理的 平均分成
     *    @param $adminid
     *    @return $averagebounus float
     *
     * */
    public function getAverageBonus($adminid, $starttime = '', $endtime = '')
    {

        if ($starttime == '') {

            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {

            $endtime = time();
        }

        $averagebonus = 0;//某个代理的 平均分成
        $monthencbonus = $this->getMonthencbonusOfTime($starttime, $endtime);//总业绩

        $adminmodel = D('Admin');

        if ($adminmodel->isislock($adminid)) {
            $usertype = $adminmodel->usertypeofrighttime($adminid, $starttime, $endtime);//返回时间段里面的usertype,没有激活返回FALSE
            $usertype = intval($usertype);//usertype ,判断是否是代理，银牌和金牌 ，1为代理，2为银牌，3为金牌
            switch ($usertype) {
                case 1 : {
                    $averagebonus = 0;
                    break;
                }
                case 2 : {
                    $yinnum = $adminmodel->getYinNum($starttime, $endtime);//银牌数量
                    /*p($yinnum);*/
//                    echo  $adminmodel->getLastSql();
                    $averagebonus = ($monthencbonus * 0.01) / $yinnum;
                    break;
                }
                case 3 : {
                    $jinnum = $adminmodel->getJinNum($starttime, $endtime);//金牌数量
//                    p($jinnum);
                    $averagebonus = ($monthencbonus * 0.03) / $jinnum;
//                       echo  $adminmodel->getLastSql();

                    break;
                }
                default : {
                    $averagebonus = 0;
                }
            }
        }


        return $averagebonus;


    }


    /**********************************************
     *
     *获得某代理直接开拓奖励,20%提成;，有时间范围
     ***********重要****************
     *
     * 首先找出所有直推的id，注册在时间内
     * 再求出直推的人的第一张单的钱总额
     * 乘20%
     *
     *
     * */


    public function getdirbonkus($adminid, $starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }
        $adminmodel = D('admin');
        if ($adminmodel->isislock($adminid)) {
            $serverids = $this->getseveradmins($adminid, $starttime, $endtime);//直推的人
            $dirbonkus = $this->getseveradminsval($serverids);//直推的第一张单的钱
            /*  p(date('Y-m-d',$starttime));
              p(date('Y-m-d',$endtime));*/
//        p($dirbonkus*0.15);
            /*  p($serverids);

              p($dirbonkus);*/
            return $dirbonkus * 0.20;
        } else {
            return 0;
        }

    }


    /*
     ***********************重要*********************
     * 求出时间区间的间接奖金 ，根据人来定
     * @param $adminid
     *
     * */

    public function getindirbonus($adminid, $starttime = '', $endtime = '')
    {
        $adminmodel = D('admin');
        $ursertype = $adminmodel->usertypeofrighttime($adminid,$starttime , $endtime);//时间段里面的usertype
        if ($adminmodel->isislock($adminid)) {
            ///过滤子孙，必须是6层之内
            /*
             *
             *       1——100            （首单）
             *       101——300          （复消1单）
             *       301——600        	（复消2单）
             *       601——1092			（复消3单）
             *     1单就激活1-100工牌，再复消1单就激活101-300，再复消2单激活301-600
             *    ，再复消3单激活601-1092；激活工牌的作用就是可以拿到间推的提成7%；
             *
             *
             *
             * */
            $childrenids = $this->getallchildrenadminid($adminid);//所有的子孙
            //过滤
            $childrenids = $adminmodel->filterChildren($adminmodel->getseidByAdminid($adminid), $childrenids);
//        p($childrenids);

            $indirbonus = 0;
            if ($starttime == '') {
                $starttime = strtotime('1970-01-02');
            }
            if ($endtime == '') {
                $endtime = time();
            }

            if ($ursertype == 1) {

                $serverids = $this->getseveradmins($adminid);//直推的人
                $serveridsarr = explode(',', $serverids);
                foreach ($childrenids as $cidk => $cidv) {
                    if (!in_array($cidv, $serveridsarr)) {
//                    遍历子孙，判断是否是直推的，直推的直接无视,不是直推就继续

                        $allorders = $this->getAllOrders($cidv);
                        if ($starttime <= $allorders[0]['ordertime'] && $allorders[0]['ordertime'] <= $endtime) {
                            //比较订单时间，第一张的订单要在时间之内
                            $indirbonus += (
                            floatval($allorders[0]['price']) >=
                            375 ? 375 : floatval($allorders[0]['price'])
                            );
                        }

                    }

                }


            } else if ($ursertype  == 2) {

                $serverids = $this->getseveradmins($adminid);//直推的人
                $serveridsarr = explode(',', $serverids);
                foreach ($childrenids as $cidk => $cidv) {
                    $allorders = $this->getAllOrders($cidv);
//                p($allorders);
                    if (!in_array($cidv, $serveridsarr)) {
//                    遍历子孙，判断是否是直推的，这是不是直推

                        if ($starttime <= $allorders[0]['ordertime'] && $allorders[0]['ordertime'] <= $endtime) {
                            //比较订单时间，第一张的订单要在时间之内
                            $indirbonus += (
                            floatval($allorders[0]['price']) >=
                            3750 ? 3750 : floatval($allorders[0]['price'])
                            );
                        }


                    }

                }

            } else if ($ursertype  == 3) {
                $serverids = $this->getseveradmins($adminid);//直推的人
                $serveridsarr = explode(',', $serverids);
                foreach ($childrenids as $cidk => $cidv) {
                    $allorders = $this->getAllOrders($cidv);
                    if (!in_array($cidv, $serveridsarr)) {
//                    遍历子孙，判断是否是直推的，这是不是直推


                        if ($starttime <= $allorders[0]['ordertime'] && $allorders[0]['ordertime'] <= $endtime) {
                            //比较订单时间，第一张的订单要在时间之内
                            $indirbonus += (
                            floatval($allorders[0]['price']) >=
                            7500 ? 7500 : floatval($allorders[0]['price'])
                            );
                        }


                    }

                }
            } else if ($ursertype  == 9) {

            }

            return $indirbonus * 0.07;
        } else {
            return 0;
        }

    }


    /*
     * 获得所有的订单，根据订单 下单时间 排序
     * @param $adminid
     * return array()
     * */
    public function getAllOrders($adminid)
    {
        $sql = "SELECT  a.id as adminid ,o.orderid ,o.otime AS 'ordertime',  o.finalpprice as price  FROM wywl_order as o  
LEFT   JOIN wywl_admin as a ON a.id = o.adminid 
LEFT JOIN wywl_product AS p ON o.pid = p.pid 
WHERE  a.id = " . $adminid . "  AND o.ispass = 1  " . "  ORDER BY o.otime ASC";
        return $this->query($sql);

        /*

          Array
         (
             [0] => Array
                 (
                     [adminid] => 5
                 [orderid] => 4
                 [ordertime] => 1488297600
                 [price] => 200.00
                 )

             [1] => Array
                 (
                     [adminid] => 5
                     [orderid] => 8
                     [ordertime] => 1489197375
                     [price] => 200.00
                 )

         )

        */
    }


    /*
     *获得由seid组成的树状网图的所有子孙id
     *@param $adminid
     *
     *return array 他的子孙树的adminid
     * **/

    public function getallchildrenadminid($adminid)
    {
        $allid = D('Admin')->field('id')->select();
        $childrenid = array();
        foreach ($allid as $idk => $idv) {
            if ($this->is_child_inseidtree($adminid, $idv['id'])) {
                array_push($childrenid, $idv['id']);
            }

        }

        return $childrenid;
    }


    /*
     * 判断是否在他的子树下
     * @param $faid ,父级id
     * @param $childid 子级 id
     * return bool
     * */
    public function is_child_inseidtree($faid, $childid)
    {
        $b = false;
        $faseid = $this->getseidByAdminid($faid);
        $faseid = $faseid['seid'];
        $childid = $this->getseidByAdminid($childid);
        $childid = $childid['seid'];

//        $faid = floatval(($childid-1)/3); 公式
        $f = $childid;

        while (true) {
            $f = floor(($f - 1) / 3);

            if (intval($f) === intval($faseid)) {
                $b = true;

                break;
            }

            if (intval($f) < intval($faseid)) {
                break;
            }
        }


        return $b;


    }


    /*
     * 根据adminid 得到 seid
     * @param $adminid
     * return seid
     * */
    public function getseidByAdminid($adminid)
    {
        $seidarr = D('Admin')->field('id,seid')->find($adminid);
        /* p($res);
         Array
         (
             [id] => 2
             [seid] => 1
         )*/
        return $seidarr;
    }


    /*
     *求出时间范围的业绩前6的代理--自己买和直推的
     *$adminids array() $adminid 的一个数组
     *键为 id，值为 钱数
     * */
    public function getbestachievement_top6($adminids, $starttime = '', $endtime = '')
    {
        $p = array();
        foreach ($adminids as $id) {
            $p[$id] = $this->getbestachievement($id, $starttime, $endtime);
        }
        arsort($p);
        $p = array_slice($p, 0, 6, true);

        return $p;
    }


    /*
     *求出时间范围的业绩前6的代理--自己买和直推的
     *$adminids array() $adminid 的一个数组
     *键为 id，值为 钱数，某一个id代理时间范围的业绩--自己直推的人的单pv总值，每人只有一张单
     * */
    public function getbestachievement_top($adminids, $topnum = 50, $starttime = '', $endtime = '')
    {

        //键的升序
        function my_sort($a,$b)
        {
            if ($a==$b) return 0;
            return ($a<$b)?1:-1;
        }



        $p = array();
        foreach ($adminids as $id) {
            $p[$id] = $this->getbestachievement($id, $starttime, $endtime);
        }
//         krsort($p);
         arsort($p);//排序值的降序

        $p = array_slice($p, 0, $topnum, true);
//        p($p);
        return $p;
    }


    /******************************
     *求出某一个id代理时间范围的业绩--自己直推的人的单pv总值，每人只有一张单
     *
     *
     * */
    public function getbestachievement($adminid, $starttime = '', $endtime = '')
    {
        $all = 0;
        $all += $this->getseveradminsval($this->getseveradmins($adminid, $starttime, $endtime));//直推的人的第一张单的钱总额
//        $all += $this->getmyordervalue($adminid,$starttime,$endtime);
//        p($all);
        return $all;
    }


    /*
     *求出直推的人的第一张单的钱总额
     *@param $serverids 所有的直推的id 如 （  5,6,7  ）
     * */
    public function getseveradminsval($serverids)
    {
        $serverids = explode(',', $serverids);
        $all = 0;
        foreach ($serverids as $aid) {
            $sql = "SELECT o.orderid,o.finalpprice as price ,o.otime  FROM wywl_order as o 
               LEFT JOIN wywl_product as p ON o.pid = p.pid
               WHERE o.adminid =" . $aid . "  AND o.ispass = 1 " . "  ORDER BY o.otime ASC";
            $res = $this->query($sql);
            $p = floatval($res[0]['price']);//第一张订单的钱
            $all += $p;
        }

        return $all;
    }


    /*
     *
     *
     * 求出直推的人
     *
     * @param $adminid 代理
     * @param $starttime 注册时间范围上限 可选
     * @param $endtime   注册时间范围下限 可选
     * @param $type 返回的类型 1为adminid 默认 ，2为seid
     * @return 所有的直推的id 如 （  5,6,7  ）$serverids
     *
     * */
    public function getseveradmins($adminid, $starttime = '', $endtime = '', $type = 1)
    {

        if ($starttime === '' && $endtime !== '') {
            //有时间下限
            $where['pid'] = $adminid;
            $where['islock'] = 1 ;
            $where2 = "registertime <=  " . $endtime;
            $severadmins = D('Admin')->where($where)->where($where2)->field('id,seid,usertype')->select();// 他直推的人

        } else if ($starttime !== '' && $endtime === '') {
            //有时间上限
            $where['pid'] = $adminid;
            $where['islock'] = 1 ;
            $where2 = "registertime >  " . $starttime;
            $severadmins = D('Admin')->where($where)->where($where2)->field('id,seid,usertype')->select();// 他直推的人
        } else if ($starttime === '' && $endtime === '') {
            //俩个时间都为空，搜出所有直推的人
            $where['pid'] = $adminid;
            $where['islock'] = 1 ;
            $severadmins = D('Admin')->where($where)->field('id,seid,usertype')->select();// 他直推的人


        } else if ($starttime !== '' && $endtime !== '') {
            //有时间上限和下限
//            p($endtime );
            $where['pid'] = $adminid;
            $where['islock'] = 1 ;
            $where2 = "registertime >  " . $starttime . "  AND  " . "registertime <=  " . $endtime;
            $severadmins = D('Admin')->where($where)->where($where2)->field('id,seid,usertype')->select();// 他直推的人
        }

        $serverids = array();
        if ($type == 2) {
            foreach ($severadmins as $server) {
                $ordermodel = D('order');
                if ($ordermodel->ishaveorder($server['id'], 1)) {
                    //必须有审核过的单才行
                    array_push($serverids, $server['seid']);
                }

            }
        } else {
            foreach ($severadmins as $server) {

                $ordermodel = D('order');
                if ($ordermodel->ishaveorder($server['id'], 1)) {
                    //必须有审核过的单才行
                    array_push($serverids, $server['id']);
                }
            }
        }

        $serverids = implode(',', $serverids);

        return $serverids;
    }


    /*
     *
     *
     * 求出自己买的产品的业绩
     *
     * @param $adminid 代理
     * @param $starttime 订单时间范围上限 可选
     * @param $endtime   订单时间范围下限 可选
     *
     * @return 所有的直推的id 如 （  5,6,7  ）
     *
     * */
    public function getmyordervalue($adminid, $starttime = '', $endtime = '')
    {

        $sql = "SELECT  a.id as adminid ,o.orderid ,o.otime AS 'ordertime', SUM(o.finalpprice) as price  FROM wywl_order as o  
LEFT   JOIN wywl_admin as a ON a.id = o.adminid 
LEFT JOIN wywl_product AS p ON o.pid = p.pid 
WHERE  a.id IN( " . $adminid . ")   " . "  AND o.ispass = 1 ";


        if ($starttime === '' && $endtime !== '') {
            //有时间下限
            $sql .= "  AND o.otime <= " . $endtime . " ";
            $myoval = $this->query($sql);
        } else if ($starttime !== '' && $endtime === '') {
            //有时间上限
            $sql .= "  AND o.otime > " . $starttime . " ";
            $myoval = $this->query($sql);
        } else if ($starttime === '' && $endtime === '') {
            //俩个时间都为空，所有订单钱
            $myoval = $this->query($sql);


        } else if ($starttime !== '' && $endtime !== '') {
            //有时间上限和下限
            $sql .= "  AND o.otime > " . $starttime . " " . "  AND o.otime <= " . $endtime . " ";
            $myoval = $this->query($sql);
        }
        $myoval = floatval($myoval[0]['price']);
//        p($myoval);
        return $myoval;
    }


    /*
     *
     *
     *
     *  获得三金
     *
     *
     * */


    public function getachievementmsg($adminid, $starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }


        $encbonus = $this->getencbonus($adminid, $starttime, $endtime);//Array ( [encbonus] => 28.71 ) 激励奖金前六名
        $dirbonkus = $this->getdirbonkus($adminid, $starttime, $endtime);//直接开拓奖金
        $indirbonkus = $this->getindirbonus($adminid, $starttime, $endtime);//间接开拓奖金
        $averagebonus = $this->getAverageBonus($adminid, $starttime, $endtime);//金银牌加权分红
//        p($averagebonus);
        $Monthperformance = array(
            'encbonus' => $encbonus,
            'dirbonkus' => $dirbonkus,
            'indirbonkus' => $indirbonkus,
            'averagebonus' => $averagebonus,
        );

        return $Monthperformance;
    }


    /*
     *
     * 所有月份的成绩
     * $adminid 代理id
     * $firsttime 最早的时间戳
     *  一直延续到注册当月1号
     *
     * */

    public function getachievementmsgofallmonth($adminid, $firsttime = "")
    {
        $adminmodel = D('admin');
        $monthmodel = D('month');

        $allMonthperformance = array();//每个月的业绩的结构数组
        $registertime = $adminmodel->getRegistertime($adminid);//注册时间
        $firsttime = $firsttime == "" ? \getFirstDaytime($registertime) : \getFirstDaytime($firsttime);//最早的月份的时间戳，默认是注册时间的当月1号时间戳
        $monnum = 1;
        $datethismontht = date('Y-m', time());//1h号的格式化时间
        $datethismonth = strtotime($datethismontht);//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳


        $thismonthbonus = $this->getachievementmsg($adminid, $datethismonth, $datenow);//这个月三金
//        p($thismonthbonus);
        $settlementmsg = D('settlementmsg');


        $allMonthperformance[$datethismontht] = $thismonthbonus;//这个月的
        $alreadysettlemoney = $settlementmsg->getAlreadySettleMoney($adminid, strtotime(date('Y-m', time())));//已经结算提现的钱
        $allMonthperformance[$datethismontht]['alreadysettlemoney'] = $alreadysettlemoney;

        $allMonthperformance[$datethismontht]['adminid'] = $adminid;
        $allMonthperformance[$datethismontht]['monthid'] = $monthmodel->getMonthidByTime($datethismonth);//通过时间戳来搜索monthid

        while (true) {


            $datemontht = date('Y-m', strtotime("-" . $monnum . " Months", $datethismonth));//从上个月开始的1号
            // p(date('Y-m-d h:i:s',strtotime("-".$monnum." Months")));
            $datemonth = strtotime($datemontht);
            $edatemonth = date('Y-m', strtotime("-" . ($monnum - 1) . " Months", $datethismonth));//这个月1号
            $edatemonth = strtotime($edatemonth);
            if ($datemonth >= $firsttime) {


                $allMonthperformance[$datemontht] = $this->getachievementmsg($adminid, $datemonth, $edatemonth);
                $alreadysettlemoney = $settlementmsg->getAlreadySettleMoney($adminid, strtotime(date('Y-m', strtotime("-" . $monnum . " Months", $datethismonth))));//已经结算提现的钱
                $allMonthperformance[$datemontht]['alreadysettlemoney'] = $alreadysettlemoney;//已经结算提现的钱

                $allMonthperformance[$datemontht]['adminid'] = $adminid;//adminid
                $allMonthperformance[$datemontht]['monthid'] = $monthmodel->getMonthidByTime($datemonth);//通过时间戳来搜索monthid

            } else {
                break;
            }

            $monnum++;
        }
//        p($allMonthperformance);
        return array_reverse($allMonthperformance);


    }


    /*
     *
     * 计算每个月的具体信息
     * $allMonthperformance 源信息
     *
     * */
    public function startandachievementmsgofallmonth($allMonthperformance)
    {
        foreach ($allMonthperformance as $amtpk => $ampfv) {
            $allMonthperformance[$amtpk]['pvtotal'] = $allMonthperformance[$amtpk]['encbonus'] + $allMonthperformance[$amtpk]['dirbonkus']
                + $allMonthperformance[$amtpk]['indirbonkus'] + $allMonthperformance[$amtpk]['averagebonus'];//总pv分红
            $allMonthperformance[$amtpk]['truebonus'] = $allMonthperformance[$amtpk]['pvtotal'] * 0.80;//实际分红，占80%
            $allMonthperformance[$amtpk]['leftsettlemoney'] = $allMonthperformance[$amtpk]['truebonus'] - $allMonthperformance[$amtpk]['alreadysettlemoney'];//可提金额
            $allMonthperformance[$amtpk]['biyudou'] = $allMonthperformance[$amtpk]['pvtotal'] * 0.20;//实际分红，占80%
        }
        $startandallMonthperformance = $allMonthperformance;
        return $startandallMonthperformance;
    }


    /*
     *
     * 获得历史以来的pv总分红的总额,实际奖金的总额，还有累计的碧玉豆
     * $startandallMonthperformance 处理过的每个月的信息
     * */
    public function getpvtotalofallmonth($startandallMonthperformance)
    {
        $pvtotalofallmonth = array();//数据的数组
        $pvtotalofallmonth['pvtotalofallmonth'] = 0;//所有月份的总分红
        foreach ($startandallMonthperformance as $amtpk => $ampfv) {
            $pvtotalofallmonth['pvtotalofallmonth'] += $ampfv['pvtotal'];
        }
        $pvtotalofallmonth['truepvtotalofallmonth'] = $pvtotalofallmonth['pvtotalofallmonth'] * 0.80;
        $pvtotalofallmonth['biyudouofallmonth'] = $pvtotalofallmonth['pvtotalofallmonth'] * 0.20;
        return $pvtotalofallmonth;
    }


}




