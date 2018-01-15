<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/4/6
 * Time: 19:39
 * PowerBy 万域网络技术团队
 *
 *  wywl_email SMTP 设置 model
 */

namespace Wanyu\Model;


use Think\Model;

class EmailModel extends Model
{


    /*
     *
     * 获得 smtp设置的信息
     *
     * */
    public function getSMTP(){
        return $this->find(1);
    }




}