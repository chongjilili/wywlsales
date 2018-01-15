<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/31
 * Time: 13:19
 * PowerBy 万域网络技术团队
 * 右上单量控制的model ，还有报表的json处理
 */

namespace Wanyu\Model;


use Think\Model;

class RisingsettingModel extends Model
{
    protected $_validate = array(

        array('nownum', 'require', '目前单量不能为空！'),
        array('risingtime', 'require', '上升率不能为空！'),
        array('shares', 'require', '股值不能为空！'),
    );


    /*
     * 自定义排序功能实现
     * $jsonarr 排序数组
     * $sidx 排序自动
     * $sord 排序顺序还是倒序
     * */
    public function rowsort(&$jsonarr, $sidx = 'id', $sord = 'desc')
    {
        $sordid = 0;
        switch ($sidx) {
            case 'id': {
                $sordid = 0;
                break;
            }
            case 'invdate': {
                $sordid = 1;
                break;
            }
            case 'pvdiramount': {
                $sordid = 2;
                break;
            }
            case 'shares': {
                $sordid = 3;
                break;
            }
            case 'pvindiramount': {
                $sordid = 4;
                break;
            }
            case 'pvtotal': {
                $sordid = 5;
                break;
            }
            default : {
                $sordid = 0;
            }
        }
       // echo (strtotime($jsonarr['rows'][0]['cell'][$sordid]) > strtotime($jsonarr['rows'][1]['cell'][$sordid])) ? 1 : -1;
        /*自定义排序
         * */
        usort($jsonarr['rows'], function ($a, $b) use ($sordid, $sord, $sidx) {
            //排序规则


            if ($sordid == 1) {
                //日期的排序
               if (strtotime($a['cell'][$sordid]) == strtotime($b['cell'][$sordid])){
                   return 0;
               }else{
                   if (strtolower($sord) == 'desc') {
                       return (strtotime($a['cell'][$sordid]) > strtotime($b['cell'][$sordid])) ? -1 : 1;
                   } else {
                       return (strtotime($a['cell'][$sordid]) > strtotime($b['cell'][$sordid])) ? 1 : -1;
                   }
               }


            } else {
                //数字的排序

                if (floatval($a['cell'][$sordid]) == floatval($b['cell'][$sordid])) {
                    return 0;
                } else {

                    if (strtolower($sord) == 'desc') {
                        return (floatval($a['cell'][$sordid]) > floatval($b['cell'][$sordid])) ? 1 : -1;
                    } else {
                        return (floatval($a['cell'][$sordid]) > floatval($b['cell'][$sordid])) ? -1 : 1;
                    }
                }


            }


        });

        return $jsonarr;


    }




    /*
     * 判断是否符合搜索的条件，主表的搜索
     * @param $adminid
     * @param $searchField 搜索字段
     * @param $searchString 搜索信息
     * @param $searchOper 搜索方式
     * @return boolean 
     * */
    public function isrowsearch($adminid,$searchField,$searchString,$searchOper){
        $datethismonth = date('Y-m', time());
        $datethismontht = strtotime($datethismonth);//这个月1号的时间戳
        $resbool = false;//返回的Boolean
        $adminmodel = D('Admin');
        $achievementmodel = D('achievement');
        $settlementmsg = D('settlementmsg');
        if ($searchString === ''){
            //不填搜索信息，默认为全部
            return true;
        }
       /* $encbonus = $achievementmodel->getencbonus($av['id'], $datethismontht, time());//Array ( [encbonus] => 28.71 ) 激励奖金
        $dirbonkus = $achievementmodel->getdirbonkus($av['id'], $datethismontht, time());//直接开拓奖金
        $indirbonkus = $achievementmodel->getindirbonus($av['id'], $datethismontht, time());//间接开拓奖金*/
        /**/
        switch ($searchField){
            case 'seid' : {
                //代理工号的搜索
                $seid = $adminmodel->getseidByAdminid($adminid);
                $resbool = $this->issearchOper($seid,$searchOper,$searchString);
                break;
            }
            /*case 'invdate' : {
                $sf=2;
                break;
            }*/
            case 'pvdiramount' : {
                //直接开拓奖金的搜索
                $dirbonkus = $achievementmodel->getdirbonkus($adminid, $datethismontht, time());//当月直接开拓奖金
                $resbool = $this->issearchOper($dirbonkus,$searchOper,$searchString);
                break;
            }
            case 'shares' : {
                //激励奖金
                $encbonus = $achievementmodel->getencbonus($adminid, $datethismontht, time());
                $resbool = $this->issearchOper($encbonus,$searchOper,$searchString);
                break;
            }
            case 'pvindiramount' : {
                $indirbonkus = $achievementmodel->getindirbonus($adminid, $datethismontht, time());//间接开拓奖金*/
                $resbool = $this->issearchOper($indirbonkus,$searchOper,$searchString);
                break;
            }
            case 'pvtotal' : {
                $dirbonkus = $achievementmodel->getdirbonkus($adminid, $datethismontht, time());//当月直接开拓奖金
                $encbonus = $achievementmodel->getencbonus($adminid, $datethismontht, time());
                $indirbonkus = $achievementmodel->getindirbonus($adminid, $datethismontht, time());//间接开拓奖金*/
                $pvtotal = $dirbonkus + $encbonus + $indirbonkus;
                $resbool = $this->issearchOper($pvtotal,$searchOper,$searchString);
                break;
            }
            case 'averagebonus' : {
                $averagebonus = $achievementmodel->getAverageBonus($adminid, $datethismontht, time());

                $resbool = $this->issearchOper($averagebonus,$searchOper,$searchString);
                break;
            }
            case 'settlement' : {
                $issettle = $settlementmsg->issettle($adminid,$datethismontht);
                $resbool = $this->issearchOper($issettle,$searchOper,$searchString);
                break;
            }
            default :{
                //代理工号的搜索
                $seid = $adminmodel->getseidByAdminid($adminid);
                $resbool = $this->issearchOper($seid,$searchOper,$searchString);
                break;
            }
        }
        return $resbool;





    }



    /*
     *
     * 判断目标数据是否符合搜索条件
     * @param $searchString 搜索信息
     * @param $searchOper 搜索方式
     * @param $isdata 可选，1为时间，要转换为时间戳，默认为0，非时间
     * @return boolean
     * */
    public function issearchOper($target,$searchOper,$searchString,$isdata=0){
        $resbool = false;//返回的Boolean
        if ($isdata == 1){
//            如果是时间的话，转换为时间戳
            $target = strtotime($target);
            $searchString = strtotime($searchString);
        }
        switch ($searchOper){
            case 'eq' : {
                $resbool = ($target == $searchString);
                break;
            }
            case 'ne' : {
                $resbool = ($target != $searchString);
                break;
            }
            case 'lt' : {
                $resbool = ($target < $searchString);
                break;
            }
            case 'le' :  {
                $resbool = ($target <= $searchString);
                break;
            }
            case 'gt' : {
                $resbool = ($target > $searchString);
                break;
            }
            case 'ge' : {
                $resbool = ($target >= $searchString);
                break;
            }
            default :{
                $resbool = ($target == $searchString);
                break;
            }


        }
        return $resbool;
    }


    /*
     *
     * 判断是否符合搜索条件，subgrid的搜索
     * @param $monthdate 月份时间
     * @param $bonus 四金
     * @param $searchField 搜索字段
     * @param $searchString 搜索信息
     * @param $searchOper 搜索方式
     * @param $issettle 是否结算
     * @return boolean
     * */

    public function issubrowsearch($monthdate,$bonus,$searchField,$searchString,$searchOper,$issettle){
        $resbool = false;//返回的Boolean
        $adminmodel = D('Admin');
        $achievementmodel = D('achievement');
        $settlementmsg = D('settlementmsg');
        if ($searchString === ''){
            //不填搜索信息，默认为全部
            return true;
        }

        switch ($searchField){
            /*case 'seid' : {
                //代理工号的搜索
                $seid = $adminmodel->getseidByAdminid($adminid);
                $resbool = $this->issearchOper($seid,$searchOper,$searchString);
                break;
            }*/
            case 'monthstr' : {
                $resbool = $this->issearchOper($monthdate,$searchOper,$searchString,1);
                break;
            }
            case 'dirbonkus' : {
                //直接开拓奖金的搜索

                $resbool = $this->issearchOper($bonus['dirbonkus'],$searchOper,$searchString);
                break;
            }
            case 'encbonus' : {
                //激励奖金
                $resbool = $this->issearchOper($bonus['encbonus'],$searchOper,$searchString);
                break;
            }
            case 'indirbonkus' : {
                $resbool = $this->issearchOper($bonus['indirbonkus'],$searchOper,$searchString);

                break;
            }
            case 'averagebonus' : {
                $resbool = $this->issearchOper($bonus['averagebonus'],$searchOper,$searchString);

                break;
            }
            case 'pvtotal' : {

                $pvtotal = $bonus['dirbonkus'] + $bonus['encbonus'] + $bonus['indirbonkus'];
                $resbool = $this->issearchOper($pvtotal,$searchOper,$searchString);
                break;
            }
            case 'issettlement' : {


                $resbool = $this->issearchOper($issettle,$searchOper,$searchString);
                break;
            }
            default :{
                $resbool = true;
                break;
            }
        }
        return $resbool;





    }






    



    /*
     *
     *
     * 右上角股值自动计算为总PV的2%，新增订单后更新一次
     *
     * */
    public function sharesreflash(){
        $companyachimodel = D('companyachi') ;
        $allmoney = $companyachimodel->getAllMoney();

        $allpv = $allmoney['allpv'];//所有订单的pv值的总和
//        p($allmoney);
        $shares = floatval($allpv)*0.02;
        $data['shares'] = $shares;
        $data['id'] = 1;
        $this->save($data);


    }














}