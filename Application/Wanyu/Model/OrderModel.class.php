<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2016/11/10
 * Time: 23:35
 * PowerBy 万域网络技术团队
 */

namespace Wanyu\Model;


use Think\Model;

class OrderModel extends Model
{
    protected $_validate = array(
        array('pid','require','产品没有被选择！'),
        array('adminid','require','代理没有被选择！'),

    );


    
    /*
     * getorderlist() 获得订单列表
     * @param $start = 0
     * @param $len = 0 0代表所有 ，拿从start开始的几条数据
     * @param $where 根据 adminid 来搜索，普通用户搜出自己的订单
     * @return array
     * */

    public function getorderlist($start = 0,$len = 0,$where = array(),$fillter = " wywl_order.ispass = 1 " ){



        $orderlist = null ;

        if ($len == 0 ){
//            $orderlist = $this->join('wywl_product ON wywl_product.pid = wywl_order.pid','LEFT')->where($where)->where($fillter)->order('orderid desc')->limit($start)->select();
            $orderlist = $this->join('wywl_product ON wywl_product.pid = wywl_order.pid','LEFT')->where($where)->where($fillter)->order('orderid desc')->limit($start)->select();
        
        }else{

            $orderlist = $this->join('wywl_product ON wywl_product.pid = wywl_order.pid','LEFT')->where($where)->where($fillter)->order('orderid desc')->limit($start,$len)->select();
        }

       // $orderlist = $this->convertorderlist($orderlist);
        return $orderlist;

    }

    /*
     * @param $orderlist
     * @return $orderlist
     * 处理订单的信息，对于一些id信息转换为具体的信息
     * */
    public function convertorderlist($orderlist){
       /* array (size=19)
      'oid' => string '5' (length=1)
      'order_sn' => string 'WO_7d3e5b' (length=9)
      'order_status' => string '0' (length=1)
      'shipping_status' => string '0' (length=1)
      'consignee' => string '丽丽' (length=6)
      'mobile' => string '13666666666' (length=11)
      'address' => string '广州' (length=6)
      'postscript' => string '很哈' (length=6)
      'order_amount' => string '1333.00' (length=7)
      'add_time' => string '1478875744' (length=10)
      'confirm_time' => string '' (length=0)
      'pay_time' => null
      'shipping_time' => null
      'adminid' => string '1' (length=1)
      'pwid' => string '2' (length=1)
      'pid' => string '1' (length=1)
      'pnum' => string '1' (length=1)
      'smid' => null
      'orderip' => null*/
        $product = D('Product');
        $payway = D('Payway');
        $spemenu  = D('Spemenu');
         foreach ($orderlist as $olk => &$olv){
             //订单的状态
             switch ($olv['order_status']){
                     case '0': $olv['order_status'] = '未确认' ;break;
                     case '1': $olv['order_status'] = '确认' ;break;
                     case '2': $olv['order_status'] = '已取消' ;break;
                     case '3': $olv['order_status'] = '无效' ;break;
                     case '4': $olv['order_status'] = '退货' ;break;
                     default : $olv['order_status'] = '未确认' ;break;
                 }
            //商品配送情况
             switch ($olv['shipping_status']){
                 case '0': $olv['shipping_status'] = '未发货' ;break;
                 case '1': $olv['shipping_status'] = '已发货' ;break;
                 case '2': $olv['shipping_status'] = '已收货' ;break;
                 case '3': $olv['shipping_status'] = '退货' ;break;

                 default : $olv['shipping_status'] = '未发货' ;break;
             }

             $pro = $product->getprobyid($olv['pid']);//获得商品信息
             $olv['pname'] =  $pro['pname'] ;
             $pw = $payway->getpaywaybyid($olv['pwid']);//获得支付方式的资料
             $olv['pwname'] =  $pw['pwname'];

             //获得套餐信息
             $sm = null;
              if($olv['smid'] != null){
                  $sm = $spemenu->getmenubysmid($olv['smid']);
                  $olv['smname'] =  $pw['smname'];
              }




         }

        return $orderlist;

    }



    /*
     *@param $oid 商品id
     *@return 返回相应商品的数据
     * 根据id来返回相应商品的数据
     * */

    public function getorderdetailbyid($oid){
        $map['oid'] = $oid;
        $order = $this->where($map)->select();
        $order = $this->convertorderlist($order);

        return $order[0];

    }

    /*
     * @param $seararr 搜索的字段信息
     * @return $orderlist
     * 
     * 
     * 
     * */
    public function getsearorderlist($seararr,$start = 0,$len = 0,$where = array()){
        /* var_dump($send);

       array (size=6)
         'ordsear' => string '荣耀8' (length=7)
         'starttime' => string '2016-11-09' (length=10)
         'endtime' => string '2016-11-26' (length=10)
         'pwid' => string '1' (length=1)
         'shipping_status' => string '0' (length=1)
         'order_status' => string '0' (length=1)

      */

        /*
          select * from wywl_orders where add_time
         between  UNIX_TIMESTAMP('2013-05-01 00:00:00')
         and
         UNIX_TIMESTAMP('2017-05-10 00:00:00');
        */


        $map =array();//搜索的条件
        if($seararr === null){
            $map = array();
        }

        if ($seararr['ordsear'] !=='' && $seararr['ordsear'] !== null){
            $where['order_sn']  = array('like', '%'.$seararr['ordsear'].'%');
            $where['pname']  = array('like','%'.$seararr['ordsear'].'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
        }

        if ( ($seararr['starttime'] !=='' && $seararr['starttime'] !== null ) ||  ($seararr['endtime'] !=='' && $seararr['endtime'] !==null )  ){
           if ( ( $seararr['starttime'] ===''|| $seararr['starttime'] ===null ) && ($seararr['endtime'] !==''&&$seararr['endtime'] !==null ) ){
               $map['add_time'] = array('elt',strtotime($seararr['endtime']) );
           }elseif ( ($seararr['starttime'] !=='' && $seararr['starttime'] !==null) && ($seararr['endtime'] ===''||$seararr['endtime'] ===null)){
               $map['add_time'] = array('egt',strtotime($seararr['starttime']));
           }elseif ( $seararr['starttime'] !==''&&$seararr['starttime'] !==null && $seararr['endtime'] !==''&&$seararr['endtime'] !==null){
               $map['add_time'] = array('between' , array(strtotime($seararr['starttime']),strtotime($seararr['endtime'])  ) ) ;
           }
        }

        if ($seararr['pwid'] !==''&&$seararr['pwid'] !==null){
            $map['pwid'] = $seararr['pwid'];
        }

        if ($seararr['shipping_status'] !==''&&$seararr['shipping_status'] !==null){
            $map['shipping_status'] = $seararr['shipping_status'];
        }

        if ($seararr['order_status'] !==''&&$seararr['order_status'] !==null){
            $map['order_status'] = $seararr['order_status'];
        }

        if ($seararr['adminid'] !==''&&$seararr['adminid'] !==null){
            //超级管理员才有
             $admstr = C('DB_PREFIX').'orders.adminid = '.$seararr['adminid'];

        }

//        $map = array_merge($map,$where);
//        p($map);
        if($where != null){
            //普通管理员才有
            $admstr = C('DB_PREFIX').'orders.adminid = '.$where['adminid'];
             
        }
        $orderlist = null ;

        if ($len == 0 ){
            $orderlist = $this
                ->join('LEFT JOIN '.C('DB_PREFIX').'product as p ON '.C('DB_PREFIX').'orders.pid = p.pid' )
                ->where($map)
                ->where($admstr)
                ->where(" wywl_order.ispass = 1 ")
                ->limit($start)
                ->select();
        }else{

            $orderlist = $this
                ->join('LEFT JOIN '.C('DB_PREFIX').'product as p ON '.C('DB_PREFIX').'orders.pid = p.pid' )
                ->where($map)
                ->where($admstr)
                ->where(" wywl_order.ispass = 1 ")
                ->limit($start,$len)
                ->select();
        }

        $orderlist = $this->convertorderlist($orderlist);
        return $orderlist;
      }



    /*
     * 通过订单来获取adminid
     * @param $orderid
     * */
    public function getadminidByOrderid($orderid){
        $adminid = $this->field('adminid')->find($orderid);
        return $adminid['adminid'];
    }





    /*
     *
     * 判断是否订单已经审核过
     * @param $orderid 订单主键
     * @return boolean
     * */
    public function getispass($orderid){
        $order =  $this->find($orderid);
        return $order['ispass'] == 1 ? true : false;
    }


    /*
     *
     * 判断是否拥有订单
     * @param $adminid
     * @param $ispass 默认为-1，1为有审核，0为没审核
     * @return boolean
     * */

    public function ishaveorder($adminid,$ispass=-1){
        if ($ispass==-1){
            $orders =  $this->where('adminid = '.$adminid)->find();
        }else if ($ispass==1){
            $orders =  $this->where('adminid = '.$adminid.' AND ispass = 1')->find();
        }else if ($ispass===0||$ispass==='0'){
            $orders =  $this->where('adminid = '.$adminid.' AND ispass = 0')->find();
        }else{
            $orders =  $this->where('adminid = '.$adminid)->find();
        }

        $ordernum = count($orders);
        if ($ordernum >= 1 ){
            return true;
        }else{
            return false;
        }
    }



    
}