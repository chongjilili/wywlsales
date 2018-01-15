<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/11
 * Time: 17:18
 * PowerBy 万域网络技术团队
 *  操作邮箱发送的发送人的信息 ，以及stmp的信息
 */

namespace Wanyu\Controller;


class EmailController extends CommonController
{

    /*
         * 前置操作，用来做导航active，显示当前导航
         * */
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('active', 9);
    }

    /**
     * 邮箱设置
     */
    public function index()
    {
        $smtp = D('email')->getSMTP();
        $this->assign('smtp',$smtp);
        $this->assign('title','邮箱设置');
        $this->display();
    }


    public function change(){
        $smtp = I();
        $smtp['id'] = 1;
        if (D('email')->save($smtp) !== false ){
            $this->success('修改成功','index',3);
        }else{
            $this->error('修改失败');
        }
    }






}