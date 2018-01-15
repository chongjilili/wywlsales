<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/4/6
 * Time: 19:39
 * PowerBy 万域网络技术团队
 *
 *  wywl_withdrawalsmsg 提现的申请表 model
 */

namespace Wanyu\Model;


use Think\Model;

class WithdrawalsmsgModel extends Model
{



    /*
     * 添加提现的申请表
     * $monthid 月份id
     * $wsmoney 提现的钱wsmoney
     * $adminid
     * */
    public function addwithdrawalsmsg($monthid,$adminid,$wsmoney){

        $wsarr = array();
        $wsarr['monthid'] = $monthid;//月份id
        $wsarr['adminid'] = $adminid;
        $wsarr['wsmoney'] = $wsmoney;//提现的钱wsmoney
        $wsarr['wstime'] = time();//申请的时间戳


        /*
         * 检验是否
         * */
        if ($this->add($wsarr) !== false){
            //添加成功
            return true;
        }else{
            return false;
        }

    }



    /*
     * 判断申请的金额是否超过了实际奖金
     * $monthid 月份id
     * $adminid
     * $wsmoney 即将提现的钱wsmoney
     *
     * */

    public function isExpandTruebonus($monthid,$adminid,$wsmoney = 0,$issettel=2){
        $settlementmsgmodel = D('settlementmsg');

        $truebonus = $settlementmsgmodel->getTruebonus($adminid,$monthid);//判断报表里的一行，也就是盖月 实际奖金
        $alrdwsmoney = $this->getWsmoneyofThisMonth($monthid, $adminid,$issettel);//已经申请的金额，1是已经审核，0是没有审核，默认为2没有审核要求
        $nowwsmoney = $alrdwsmoney + $wsmoney;
        if ($nowwsmoney > $truebonus ){
            //超过了实际奖金范围
            return false;
        }else{
            return true;
        }
    }


    /*
     * 已经获得这个月申请的金额总数
     * $monthid 月份id
     * $adminid
     * $issetttel = 2 ,1是已经审核，0是没有审核，默认为2没有审核要求
     * @return array wsmoney
     * */

    public function getWsmoneyofThisMonth($monthid,$adminid,$issettel=2){
        $w['monthid'] = $monthid;
        $w['adminid'] = $adminid;
         switch ($issettel){
             case 1:{
                 $w['issettel'] = $issettel;
                 break;
             }
             case 0:{
                 $w['issettel'] = $issettel;
                 break;
             }
             default :{
                 break;
             }
         }

        $wsmoney = $this->where($w)->Sum('wsmoney');
        return floatval($wsmoney);
    }




    /*
     * $start 开始的位置
     * $length 长度
     * $sort 升序还是降序
     *
     *
     *
     * */
    public function getAllWsmsg($start='',$length='',$where=array(),$sort=''){

        $monthmodel = D('month');
        $adminmodel = D('admin');
        $wsmsg = array();
       if ($sort==''){
           if ($start == ''&&$length!=''){
               $wsmsg =  $this->limit(0,$length)->where($where)->select();
           }elseif ($start!=''&&$length==''){
               $wsmsg =  $this->limit($start)->where($where)->select();
           }elseif ($start==''&&$length==''){
               $wsmsg =  $this->where($where)->select();
           }elseif ($start!=''&&$length!=''){
               $wsmsg =  $this->limit($start,$length)->where($where)->select();
           }
       }else{
           if ($start == ''&&$length!=''){
               $wsmsg =  $this->limit(0,$length)->order("$sort")->where($where)->select();
           }elseif ($start!=''&&$length==''){
               $wsmsg =  $this->limit($start)->order(" $sort")->where($where)->select();
           }elseif ($start==''&&$length==''){
               $wsmsg =  $this->order("wsid $sort")->where($where)->select();
           }elseif ($start!=''&&$length!=''){
               $wsmsg =  $this->limit($start,$length)->order("$sort")->where($where)->select();
           }
       }
        

        foreach ($wsmsg as $wk => $wv){
            //遍历数据

            $mmsg = $monthmodel->getMonthByMonthid($wv['monthid']);//月份信息
//            P($wsmsg['monthid']) ;
            $wsmsg[$wk]['month'] = $mmsg['month'];//格式化的时间
            $wsmsg[$wk]['seid'] = $adminmodel->getseidByAdminid($wsmsg[$wk]['adminid']);
        }

        return $wsmsg;



       //
    }







}