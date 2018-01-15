<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/2/7
 * Time: 23:40
 * PowerBy 万域网络技术团队
 * 前台添加订单的控制器
 */

namespace Home\Controller;


use Think\Controller;
use Wanyu\Model\OrdersModel;

class OrderController extends Controller
{

       /*
        * 添加订单
        * */
        public function addorder(){
            $send = I();
             
           /* Array
            (
                [pname] => 系统测试产品
                [smid] => 15
                [order_amount] => 1570.00
                [pwid] => 1
                [pid] => 10
                [pnum] => 2
                [consignee] => 丽丽
                        [wfmob] => 13653666666
                [province] => 吉林省
                        [city] => 松原市
                        [area] => 三岔河镇
                        [address] => 就解决
                        [wfpaybank] => ICBCB2C
                        [postscript] => 请尽快安排发货，送货之前手机联系，谢谢！
                [wfsubmit] => 立即提交订单
            )*/


            $send['order_sn'] = 'WO_'.substr(md5(time()),2,6 );
            $send['add_time'] = time();
            if( intval(trim($send['order_status'])) == 1 ){
                $send['confirm_time'] = time();
            }else{
                $send['confirm_time'] = '';
            }
            $orders = new OrdersModel();
            if ($orders->create($send)){
                $res = $orders->add();
                if($res){
                    echo 1 ;
                }else{
                    echo 0 ;
                }
            }else{
                echo $orders->getError();
            }




        }
}