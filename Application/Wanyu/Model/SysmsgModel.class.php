<?php
namespace Wanyu\Model;
use Think\Model;

/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2016/11/2
 * Time: 23:15
 * PowerBy 万域网络技术团队
 * SysmsgModel 操作 系统说明sysmsg表的model的数据
 */
class SysmsgModel extends Model
{




    /*
     * 获得系统说明表的model的数据
     * return 数据arr
     * */
    public  function getSysmsg(){
       $sysmsg =  $this->limit(1)->select();
       return $sysmsg[0];
    }
}