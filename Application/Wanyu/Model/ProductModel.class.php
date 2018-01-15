<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2016/11/7
 * Time: 21:04
 * PowerBy 万域网络技术团队
 * ProductModel 有关产品的数据处理类
 */

namespace Wanyu\Model;


use Think\Model;

class ProductModel extends Model
{
    protected $_validate = array(
        array('pname','require','商品名称不能为空！'),
        array('price','require','商品价格不能为空！'),



    );


    /*
     * getprolist 获得商品列表数据，也用于分页
     * @param $start = 0
     * @param $len = 0 0代表所有 ，拿从start开始的几条数据
     * @return array
     * */

    public function getprolist($start = 0,$len = 0 ,$where=array())
    {
        
        $prolist = null ;
        
        

        if ($len == 0 ){
            $prolist = $this->where($where)->limit($start)->select();
        }else{

            $prolist = $this->where($where)->limit($start,$len)->select();
        }

        return $prolist;


    }


    /*
     * getsearprolist 获得搜索商品列表数据，也用于分页
     * @param $searpro 搜索的字符串
     * @param $start = 0
     * @param $len = 0 0代表所有 ，拿从start开始的几条数据
     * @return array
     * */

    public function getsearprolist($searpro='',$start = 0,$len = 0 ,$where=array())
    {    $searprolist = null;
        if ($searpro == ''){

            //如果搜索的内容为空就直接调用getprolist
            /*if ($len == 0 ){
                $searprolist = $this->where($where)->limit($start)->select();
            }else{

                $searprolist = $this->where($where)->limit($start,$len)->select();
            }*/
            $searprolist = $this->getprolist($start,$len,$where);


        }else{
            $map['pname'] = array('like','%'.$searpro.'%');
            $map = array_merge($map,$where);
            if ($len == 0 ){
                $searprolist = $this->where($map)->limit($start)->select();
            }else{

                $searprolist = $this->where($map)->limit($start,$len)->select();
            }

        }

        return $searprolist;
    }




    /*
     *@param pid 商品的pid byid
     *通过pid获得商品的信息
     *
     * @return array 商品的数据
     * */
    public  function getprobyid($pid = 0){

          $map['pid'] = $pid ;
          $pro = $this->where($map)->select();
          return $pro[0] ;
    }


}