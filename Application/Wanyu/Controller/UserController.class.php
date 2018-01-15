<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/14
 * Time: 12:03
 * PowerBy 万域网络技术团队
 *
 * 普通代理会员的控制器
 *
 *
 */

namespace Wanyu\Controller;


class UserController extends CommonController
{
    /*
         * 前置操作，用来做导航active，显示当前导航
         * */
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('active', 4);
    }

    /*个人中心*/
    public function index()
    {

        $adminid = session('adminid');
        $username = D('admin')->getseidByAdminid($adminid);
        $admin = D('Admin')->field('id,seid,username,dirsalenum,password,usertype,realname,creditcard,addressofcreditcard,idcard')->find($adminid);

        $this->assign('username', $username);
        $this->assign('admin', $admin);
        $this->assign('adminid', $adminid);
        $this->display();
    }


    /*
     *
     * 本来是修改密码，现在家里一些信息
     *
     * */
    public function changePasswordAndMsg()
    {
        $send = I();
        $adminid = session('adminid');

        /*
         *  Array
            (
                [password] => 123456789
                [qpassword] => 123456789
                [realname] => 1
                [adminid] => 2
            )
        **/
        $data = array();
        $data['realname'] = $send['realname'];
        $data['id'] = $send['adminid'];
        $data['creditcard'] = $send['creditcard'];//卡号
        $data['addressofcreditcard'] = $send['addressofcreditcard'];//开卡户地


        if (trim($send['password']) == trim($send['qpassword'])) {
            //密码和确认密码相同的时候
            if (trim($send['password']) == '') {
                //不填密码的时候
                if ((D('Admin')->save($data)) !== false) {
                    $this->success('修改成功', 'index');
                } else {
                    $this->error('修改失败');
                }

            } else {
                $encrypt = D('Admin')->field('encrypt')->find($adminid);
                $password = get_password($send['password'], $encrypt['encrypt']);
                $data['password'] = $password;
                if ((D('Admin')->save($data)) !== false) {
                    $this->success('修改成功', 'index');
                } else {
                    $this->error('修改失败');
                }
            }

        }


    }
}