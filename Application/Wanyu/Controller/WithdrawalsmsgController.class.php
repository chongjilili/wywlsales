<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/11
 * Time: 17:18
 * PowerBy 万域网络技术团队
 *  提现的申请管理的控制器
 */

namespace Wanyu\Controller;


class WithdrawalsmsgController extends CommonController
{

    /*
         * 前置操作，用来做导航active，显示当前导航
         * */
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('active', 7);
    }

    /*
     *接受提交的提现的申请
     *
     * */
    public function  acceptwithdrawalsmsg(){
        $send = I();
//        die();
//        p($send);
        $withdrawalsmsgmodel = D('Withdrawalsmsg');//wywl_withdrawalsmsg 提现的申请表 model
        /*
         *  Array
         *   (
         *         [monthid] => 4
         **        [wsmoney] => 100
         *         [adminid] => 2
         *   )
        */
        if ($withdrawalsmsgmodel->isExpandTruebonus($send['monthid'],$send['adminid'],$send['wsmoney'])){

            //判断申请是否超过了当月的实际奖金，防止无数次提交订单

            if ($withdrawalsmsgmodel->addwithdrawalsmsg($send['monthid'],$send['adminid'],$send['wsmoney'])){
                //添加成功
                if(session(C('ADMIN_AUTH_KEY'))){
                    //如果是超级管理员
                    $this->success('提交提现申请成功', U('Withdrawalsmsg/wsdeelwith'));
                }else{
                    $this->success('提交提现申请成功', U('Withdrawalsmsg/wsdeelwithofuser'));
                }
            }else{
                $this->error('提交提现申请失败');
            }


        }else{
//            echo $withdrawalsmsgmodel->isExpandTruebonus($send['monthid'],$send['adminid'],$send['wsmoney']);
            $this->error("提交的提现总额超过了实际奖金(包括没有审核的提现申请)");
        }









    }






    /*
     *
     * 申请的表单页
     *
     * */
    public function wsdeelwith(){
        $withdrawalsmsgmodel = D('withdrawalsmsg');
        $adminmodel = D('admin');
        /*******分页************/
        //分页
        $onepagenum = 10;//每一页的数据条数
        $nowpage = I('nowpage') == ''  ? 1 : intval(I('nowpage')); // 发送过来的页码
//        $admins = $adminmodel->field('password,encrypt', true)->where($where)->select(); //view;
//        echo  $adminmodel->getLastSql();
        $allwsm = $withdrawalsmsgmodel->getAllWsmsg();//所有的提现申请
        $allnum = count($allwsm);
        $pagecount  =  ceil(floatval($allnum)/floatval($onepagenum));//总页数

        $allwsm = $withdrawalsmsgmodel->getAllWsmsg(($nowpage-1)*$onepagenum,$onepagenum,array()," wstime desc ");//所有的提现申请

//       p($allwsm);
        /* echo (date('Y-m','1492845182'));*/

        $this->assign('allnum',$allnum);
        $this->assign('pagecount',$pagecount);
        $this->assign('nowpage',$nowpage);


        $this->assign('allwsm',$allwsm);
        $this->display();
    }


    /*
     * 删除一个数据
     *
     * */
    public function delws(){
        $send = I();
        $wsid = $send['wsid'];
        $withdrawalsmsgmodel = D('withdrawalsmsg');
        if ($withdrawalsmsgmodel->where('wsid = '.$wsid)->delete() !== false){
            $this->success('删除成功');
        }else{
            $this->error("删除失败");
        }
    }


    /*
     * 审核一个提现
     *
     *  */
    public function wssettel(){
        $send = I();
        $wsid = $send['wsid'];
        $settlementmsgmodel = D('settlementmsg');
        $withdrawalsmsgmodel = D('withdrawalsmsg');
        $data['issettel'] = 1;
        $data['wsid'] = $wsid;
        $data['wssetteltime'] = time();
        $wr = $withdrawalsmsgmodel->find($wsid);

        if ($withdrawalsmsgmodel->isExpandTruebonus($wr['monthid'],$wr['adminid'],$wr['wsmoney'],1)){
            //审核的金额不可以超过实际金额，超过为false

            if ($withdrawalsmsgmodel->save($data)!==false){
                //审核通过之后就插入数据表中，数据报表就不用审核填写了。
                $iselwsmoney = $withdrawalsmsgmodel->getWsmoneyofThisMonth($wr['monthid'],$wr['adminid'],1);//全部审核过的钱
                $w['monthid']=$wd['monthid'] = $wr['monthid'];
                $w['adminid']=$wd['adminid'] = $wr['adminid'];
                $wd['alreadysettlemoney'] = $iselwsmoney;

                if (  $settlementmsgmodel->where($w)->save($wd) !==false  ){
                    echo 1;
                }else{
                    echo 0;
                }

            }else{
                echo 0;
            }
        }else{
            //超过了
            echo 0;
        }

    }


    /*
    *
    * 申请的表单页,这个是普通用户的
    *
    * */
    public function wsdeelwithofuser(){

        $withdrawalsmsgmodel = D('withdrawalsmsg');
        $adminmodel = D('admin');
        $adminid = session('adminid');
        $where['adminid'] = $adminid;
        /*******分页************/
        //分页
        $onepagenum = 10;//每一页的数据条数
        $nowpage = I('nowpage') == ''  ? 1 : intval(I('nowpage')); // 发送过来的页码
//        $admins = $adminmodel->field('password,encrypt', true)->where($where)->select(); //view;
//        echo  $adminmodel->getLastSql();
        $allwsm = $withdrawalsmsgmodel->getAllWsmsg('','',$where);//所有的提现申请
        $allnum = count($allwsm);
        $pagecount  =  ceil(floatval($allnum)/floatval($onepagenum));//总页数

        $allwsm = $withdrawalsmsgmodel->getAllWsmsg(($nowpage-1)*$onepagenum,$onepagenum,$where ," wstime desc ");//所有的提现申请




        $this->assign('allnum',$allnum);
        $this->assign('pagecount',$pagecount);
        $this->assign('nowpage',$nowpage);


        $this->assign('allwsm',$allwsm);
        $this->display();
    }

}