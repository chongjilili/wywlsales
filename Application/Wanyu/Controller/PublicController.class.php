<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 2016/11/1
 * Time: 22:44
 *
 * 公共系统信息处理器
 */

namespace Wanyu\Controller;


use Think\Controller;



class PublicController extends CommonController
{
    /*网站头部访问*/
     public  function header(){

          $this->display();
     }

    /*网站左侧访问*/
     public  function left(){

        $this->display();
     }

    /*系统信息访问*/
     public function sysmain(){
         $title = "网站首页";
         $paneltil = "系统信息";
         $sysmsg = D('Sysmsg')->getSysmsg();
         
//         print_r($sysmsg);
         $this->assign('sysmsg',$sysmsg);
         $this->assign('paneltil',$paneltil);
         $this->assign('title',$title);
          
         $this->display();
     }



    public function downloadexcel(){
//        define('APP_DEBUG',false);
        
      /*  $order = D('Order');
         $orderlist = $order->select();*/
        $tablehtml  =  I('tablehtml', '', 'htmlspecialchars_decode,trim');
        $tid  =  I('tid', '', 'htmlspecialchars,trim');
        //echo   iconv("UTF-8", "GB2312", $tablehtml);
        exportexcel($tablehtml,$tid);


    }
}