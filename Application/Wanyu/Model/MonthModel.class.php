<?php




/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/11
 * Time: 17:18
 * PowerBy 万域网络技术团队
 * 月份的model，
 */
 
namespace Wanyu\Model;




use Think\Model;

class MonthModel extends Model
{

    /*
     * 获得所有月份的信息
     * $nowtime //默认的现在的时间戳，返回的月份必须是这个之间之前的
     * */
     public function getMonthsMsg($nowtime='',$adminid='',$firsttime = ""){
         if ($nowtime === '' ){
             $nowtime = time();//默认的现在的时间戳，返回的月份必须是这个之间之前的
         }
         if ($adminid !== '' ){
             $adminmodel = D('admin');
             $registertime = $adminmodel->getRegistertime($adminid);//注册时间
             $firsttime = $firsttime == "" ? \getFirstDaytime($registertime) : \getFirstDaytime($firsttime);//最早的月份的时间戳，默认是注册时间的当月1号时间戳
         }


         $months =  $this->select();//所有的月份
         $fm = array();//要返回的月份信息
         foreach ($months as $mk => $mv ){
             $months[$mk]['time'] = $months[$mk]['month'];//时间戳
             $months[$mk]['month'] = date('Y-m',$months[$mk]['month']);//格式化的日期，如2017-04
             if ($months[$mk]['time'] <= $nowtime && $months[$mk]['time'] >= $firsttime ){
                 array_push($fm,$months[$mk] );
             }
         }
        return array_reverse($fm);
     }


    /*
     * 通过monthid来获取月份信息
     * $monthid
     *
     *
     *
     * */
    public function getMonthByMonthid($monthid){

        $monthmsg =  $this->find($monthid);//月份信息
        $monthmsg['time'] = $monthmsg['month'];//时间戳
        $monthmsg['month'] = date("Y-m",$monthmsg['month']) ;//格式化的日期，如2017-04m

        return $monthmsg;
    }

    /*
     *
     * 通过时间戳来搜索monthid
     * @param $month 时间戳
     *
     * */
    public function getMonthidByTime($month){
        $w['month'] = $month;
        $r = $this->where($w)->find();
        return $r['monthid'];
    }



    /*
     * 新增更新数据表
     *
     * */

    public function refreshmonth(){


        $month = $this->select();


        foreach ($month as $mv){
            $mv['monthstr'] = date('Y-m',$mv['month']);
            $this->save($mv);

        }


    }





}
