<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/4/6
 * Time: 19:39
 * PowerBy 万域网络技术团队
 *
 * 月份结算model类
 */

namespace Wanyu\Model;


use Think\Model;

class SettlementmsgModel extends Model
{


    /*
     *
     * 判断报表里的一行，也就是盖月的钱是否结算了
     * $adminid
     * $monthtime 月份的时间戳
     * */

    public function issettle($adminid,$monthtime){
        $montharr = D("month")->where('month = '.$monthtime)->find();
        $monthid = $montharr['monthid'];
        $where['adminid'] = $adminid;
        $where['monthid'] = $monthid;
        $settingarr = $this->where($where)->find();//数据，adminid monthid issetting
        $issetting = $settingarr['issettlement'] ;
        return $issetting?1:0;//0或者1，是否结算
    }

    /*
    *
    * 设置结算状态
    * $adminid
    * $monthtime 月份的时间戳
    * $issettle
    * */

    public function setsettle($adminid,$monthtime,$issettle){
        $montharr = D("month")->where('month = '.$monthtime)->find();
        $monthid = $montharr['monthid'];
        $data['adminid']=$where['adminid'] = $adminid;
        $data['monthid']=$where['monthid'] = $monthid;
        $data['issettlement'] = $issettle;
        $sarr = $this->where($where)->select();
        if (empty($sarr)){
            //原来没有数据就插入
            $res = $this->add($data);//数据，adminid monthid issetting
        }else{
            //有数据就修改
            $res = $this->where($where)->save($data);//数据，adminid monthid issetting
        }
        if ($res !== false){
            return 1;
        }else{
            return 0;
        }

    }






    /*
     *
     *判断报表里的一行，也就是盖月已经结算的钱
     * $adminid
     * $monthtime 月份的时间戳
     *
     *
     * */
    public function getAlreadySettleMoney($adminid,$monthtime){
        $montharr = D("month")->where('month = '.$monthtime)->find();
        $monthid = $montharr['monthid'];
        $where['adminid'] = $adminid;
        $where['monthid'] = $monthid;
        $settingarr = $this->where($where)->find();//数据，adminid monthid issetting
        $alreadysettlemoney = $settingarr['alreadysettlemoney'] ;//已经结算提现的钱
        return  $alreadysettlemoney?floatval($alreadysettlemoney):number_format(0,2);//格式化结算过的钱
    }



    /*
     *
     *判断报表里的一行，也就是盖月 实际奖金
     * $adminid
     * $monthid 月份id**
     *
     *
     * */
    public function getTruebonus($adminid,$monthid){

        $where['adminid'] = $adminid;
        $where['monthid'] = $monthid;
        $settingarr = $this->where($where)->find();//数据，adminid monthid issetting
        $truebonus = $settingarr['truebonus'] ;//已经结算提现的钱
        return  $truebonus?floatval($truebonus):number_format(0,2);//格式化结算过的钱
    }









    /*
     * 修改已经结算的钱
     * $adminid
     * $monthtime 月份的时间戳
     * $alreadysettlemoney 已结算的钱
     * */
    public function setAlreadySettleMoney($adminid,$monthtime,$alreadysettlemoney){
        $montharr = D("month")->where('month = '.$monthtime)->find();
        $monthid = $montharr['monthid'];
        $data['adminid']=$where['adminid'] = $adminid;
        $data['monthid']=$where['monthid'] = $monthid;
        $data['alreadysettlemoney'] = $alreadysettlemoney;
        $sarr = $this->where($where)->select();
        if (empty($sarr)){
            //原来没有数据就插入
            $res = $this->add($data);//数据，adminid monthid $alreadysettlemoney
        }else{
            //有数据就修改
            $res = $this->where($where)->save($data);//数据，adminid monthid $alreadysettlemoney
        }

        if ($res !== false){
            return 1;
        }else{
            return 0;
        }
    }




    /*
     *
     * 更新所有数据并且插入数据，所有人和所有月份的数据
     *
     * */
    public function refreshmsgofAllAdminid(){
        $achievementmodel  = D('Achievement');
        $adminmodel = D('Admin');
        $adminids = $adminmodel->getadminids();//所有激活的adminid
        $adminidsarr = explode(',',$adminids );//所有激活的代理的adminid数组
        foreach ($adminidsarr as $aiv ){
            //遍历所有adminid
            $this->refreshmsgByAdminid($aiv);
        }

    }



    /*
     *
     * $adminid
     * $isone 如果是1只更新目前月份的业绩，默认是1,更新当前月
     * 对于某个人的业绩进行插入更新
     *
     * */
    public function refreshmsgByAdminid($adminid,$isone=1){
        $achievementmodel  = D('Achievement');
        $adminmodel = D('Admin');

        //所有月份的业绩
        if ($isone == 1){
            $allMonthperformance = $achievementmodel->startandachievementmsgofallmonth( $achievementmodel->getachievementmsgofallmonth($adminid,time()) );

        }else{
            $allMonthperformance = $achievementmodel->startandachievementmsgofallmonth( $achievementmodel->getachievementmsgofallmonth($adminid) );

        }
        foreach ($allMonthperformance as $amfv){
            $where['adminid'] = $adminid;
            $where['monthid'] = $amfv['monthid'];
              if ($this->ishaving($adminid, $amfv['monthid'] ) ){
                  //存在信息，更新
                   $this->where($where)->save($amfv);
              }else{
                //不存在，插入
                  $this->add($amfv);
            }
        }


    }




    /*
     *
     * $adminidsarr 一个adminid组成的数组
     *
     * 对于某个adminid数组的业绩进行插入更新
     *
     * */
    public function refreshmsgByAdminidsarr($adminidsarr){
        foreach ($adminidsarr as $aiv){
            $this->refreshmsgByAdminid($aiv);
        }
    }



    /*
     * @param $adminid
     * 更新一个adminid 以及 tree里面的父亲祖先，还有推荐他的人的业绩
     *
     * */
    public function refreshmsgByAdminidAndTreepidAndPid($adminid){

        $adminmodel = D('admin');
        $adminidarr = $adminmodel->getTreeSixPid($adminid);//要更新的adminid的数组
        array_push($adminidarr, $adminid);
        $pid = $adminmodel->getpid($adminid);//推荐自己的人
        if ($pid != 1){
            //1是超级管理员，不用更新
            array_push($adminidarr, $pid);

        }
//        delByValue($adminidarr, 1);
        $this->refreshmsgByAdminidsarr($adminidarr);
    }





    /*
     * 通过adminid和monthid ，判断这条信息是否存在
     *
     * */
    public function ishaving($adminid,$monthid){
        $where['adminid'] = $adminid;
        $where['monthid'] = $monthid;
        $sarr = $this->where($where)->select();
        if (empty($sarr)){
            return false;
        }else{
            return true;
        }
    }

    /*
     *
     * 更新当月前六的分红
     *
     *
     *
     */
    public function refreshTop6Encbonus(){
        $monthmodel = D('month');
        /*Array
                (
                    [7] => 262.5
                    [8] => 78.75
                    [6] => 78.75
                    [5] => 349.65
                    [3] => 349.65
                    [4] => 349.65
                )
                */
        /*
         *
         *
         * ******************************取消了前六分红***************************************************

          $top6encbonus =  $this->getTop6Encbonus();//键为id，值为前六的分红



        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
        $nowmonthid = $monthmodel->getMonthidByTime($datethismonth);//当月monthid
//        p($nowmonthid);

        //1.清空所有当月的encbonus
        $w['monthid'] = $nowmonthid;
        $data['encbonus'] = 0;
        if ($this->where($w)->save($data) !== false ){
            //清空成功
            foreach ($top6encbonus as $tek => $tev ){
                //键为id，值为前六的分红
                $w['adminid'] = $tek;
                $data['encbonus'] = $tev;
                if ($this->where($w)->save($data) === false ){
                    //更新失败就直接更新这个id当月的数据
                    $this->refreshmsgByAdminid($tek);
//                    p($tev);

                }//给前六的激励分红赋值
            }
        }

        *************************************************************************/





    }


    /*
     *
     * 获得当月前六的分红
     *
     *
     *
     */
    public function getTop6Encbonus(){
        $adminmodel = D('admin');
        $Achievement = D('Achievement');

        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
        $adminids = explode(',', $adminmodel->getadminids() );// 所有已经激活的id
        $top6 = $Achievement->getbestachievement_top6($adminids, $datethismonth, time());//键为 id，值为 钱数
        $monthencbonus = $Achievement->getMonthencbonusOfTime($datethismonth, time());//总业绩
        $monthencbonus = $monthencbonus*0.01;//1% 做分红,前六的激励分红总额


        $percent = array(0.5,0.15,0.15,0.666,0.666,0.666);//激励分红的百分比分红
        $index = 0;//索引
        foreach ($top6 as $tidk => $tmoneyv ){
            $top6[$tidk] = $monthencbonus*$percent[$index];
            $index++;
        }

        return $top6;//键为id，值为前六的分红
    }






    /*
     *
     * 更新这个月的金银牌平均加权分红
     *
     * */
    public function refreshAverageBonus(){
        $adminmodel = D('admin');
        $Achievement = D('Achievement');
        $monthmodel = D('month');

        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
        $nowmonthid = $monthmodel->getMonthidByTime($datethismonth);//当月monthid

        $monthencbonus = $Achievement->getMonthencbonusOfTime($datethismonth, time());//当月总业绩


        $yinnum = $adminmodel->getYinNum();//银牌数量
        $yinaveragebonus = ($monthencbonus*0.01)/$yinnum ;//银牌的每人的加权分红


        $jinnum = $adminmodel->getJinNum();//金牌数量

        $jinaveragebonus = ($monthencbonus*0.03)/$jinnum ;//银牌的每人的加权分红


        $yinadminids = implode(',', $adminmodel->getYinAdminids());//银牌的adminid
        $jinadminids = implode(',', $adminmodel->getJinAdminids());//金牌的adminid
//        p($monthencbonus);
        $w['adminid'] = array('in',$yinadminids);
        $w['monthid'] = $nowmonthid;
        $data['averagebonus'] = $yinaveragebonus;
        $this->where($w)->save($data);//更新银牌的加权分红

        $w['adminid'] = array('in',$jinadminids);
        $w['monthid'] = $nowmonthid;
        $data['averagebonus'] = $jinaveragebonus;
        $this->where($w)->save($data);//更新银牌的加权分红


    }






    /*
     *
     * 返回搜索的数据
     * $searchField 搜索字段
     * $searchString  搜索信息
       $searchOper  搜索方式
     *
     * */
    public function getsearwherearr($searchField,$searchString,$searchOper){
        $where =array();
        switch ($searchOper){
            case 'eq' : {
                $where[$searchField] = array('eq',$searchString);// =
                break;
            }
            case 'ne' : {
                $where[$searchField] = array('neq',$searchString);// <>
                break;
            }
            case 'lt' : {
                $where[$searchField] = array('lt',$searchString);// <
                break;
            }
            case 'le' :  {
                $where[$searchField] = array('elt',$searchString);// <=
                break;
            }
            case 'gt' : {
                $where[$searchField] = array('gt',$searchString);// >
                break;
            }
            case 'ge' : {
                $where[$searchField] = array('egt',$searchString);// >=
                break;
            }
            default :{
                $where[$searchField] = array('eq',$searchString);// =
                break;
            }


        }
        return $where;
    }







    /*
     * 返回当月的详细数据
     *
     *
     * */




}