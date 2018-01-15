<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2016/11/7
 * Time: 19:41
 * PowerBy 万域网络技术团队
 *  产品管理类 Promag 控制器
 */

namespace Wanyu\Controller;


class PromagController extends CommonController
{


    /*
     * 前置操作，用来做导航active，显示当前导航
     * */
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('active', 6);
    }


    /*
     * 商品管理起初页
     * 把数据库的数据输出
     * */
    public function index()
    {
        $adminid = session(C('USER_AUTH_KEY'));
        $product = D('Product');
        $onepagenum = 13;//每一页的数据条数
        $nowpage = I('nowpage') == '' ? 1 : intval(I('nowpage')); // 发送过来的页码
        $allnum = $product->count();//商品的总数
        $pagecount = ceil(floatval($allnum) / floatval($onepagenum));//总页数

        //设置adminid条件
        if (session(C('ADMIN_AUTH_KEY'))) {
            //如果是超级管理员
            $where = array();

        } else {
            $where = array('adminid' => $adminid);
        }


        $prolist = $product->getprolist(($nowpage - 1) * $onepagenum, $onepagenum, $where);

//         var_dump($allnum);
        $this->assign('prolist', $prolist);
        $this->assign('allnum', $allnum);
        $this->assign('pagecount', $pagecount);
        $this->assign('nowpage', $nowpage);


        $this->assign('title', '产品管理');
        $this->display();
    }


    /*
         * 商品的搜索操作
         *
         * */
    public function searchpro()
    {
        $adminid = session(C('USER_AUTH_KEY'));
        $product = D('Product');
        $searpro = I('searpro');//搜索的条件，名称搜索

        $onepagenum = 13;//每一页的数据条数
        $nowpage = I('nowpage') == '' ? 1 : intval(I('nowpage')); // 发送过来的页码
        $map['pname'] = array('like', '%' . $searpro . '%');
        $allnum = $product->where($map)->count();//商品的总数
        $pagecount = ceil(floatval($allnum) / floatval($onepagenum));//总页数

        //设置adminid条件
        if (session(C('ADMIN_AUTH_KEY'))) {
            //如果是超级管理员
            $where = array();

        } else {
            $where = array('adminid' => $adminid);
        }

        $searprolist = $product->getsearprolist($searpro, ($nowpage - 1) * $onepagenum, $onepagenum, $where);

        $this->assign('searprolist', $searprolist);
        $this->assign('allnum', $allnum);
        $this->assign('pagecount', $pagecount);
        $this->assign('nowpage', $nowpage);
        $this->assign('searpro', $searpro);

        $this->assign('title', '产品搜索');


        $this->display();
    }

    
    
    public function proadd(){


        $this->assign('title', "添加商品");
        $this->display();
    }
    
    
    /*
     * 添加商品的处理
     *
     * */

    public function doproadd()
    {
        header("Content-type: text/html; charset=utf-8");
        $newpro = I();
        $newpro['pv'] = 0.74;
//        $newpro['pprice'] = floatval($newpro['price']) * $newpro['pv'];
        $product = D('Product');

        if ($product->create($newpro)) {
            $res = $product->add();
            if ($res) {
                //返回pid
                $this->redirect('Promag/index', array(), 1, "添加成功....");
            } else {
                $this->redirect('Promag/index', array(), 1, "添加失败....");
            }
        } else {
            $this->error($product->getError());
        }
        // print_r($newpro);
    }

    /*
     * 修改商品,就如修改商品页
     * */

    public function editpro()
    {
        $send = I();
        $pid = $send['pid'];
        $product = D('Product');
        $pro = $product->getprobyid($pid);
//          print_r($pro);
        $this->assign('title', "修改商品");
        $this->assign('pid', $pid);
        $this->assign('pname', $pro['pname']);
        $this->assign('pprice', $pro['pprice']);
        $this->assign('price', $pro['price']);
        $this->assign('pv', $pro['pv']);
        $this->assign('pro', $pro);
        $this->display();

    }


    /*
     * 修改商品处理
     * */

    public function prochg()
    {

        $send = I();

//        $send['admimid'] = session(C('USER_AUTH_KEY'));
//        print_r($send);
        $product = D('Product');
        if ($product->create($send)) {
            //print_r($send);
            $res = $product->save($send);
            if ($res === false) {
                echo 0;
            } else {
                echo 1;
            }
        } else {

            echo $product->getError();
        }

    }


    /*
     * 删除商品
     * */
    public function delpro()
    {
        $send = I();
        $pid = $send['pid'];
        $product = D('Product');
        //print_r($smid);
        $dn = $product->where("pid = $pid")->delete();//返回删除的记录数
        if ($dn === false) {
            echo 0;

        } else {
            echo 1;
        }
    }


    /*
     *addmenu 添加商品套餐
     * 
     * 
     * */
    public function addmenu()
    {

        $send = I();
        $pid = $send['pid'];//产品的id
        $product = D('Product');
        $pro = $product->getprobyid($pid);

        $this->assign('pname', $pro['pname']);
        $this->assign('pid', $pid);
        $this->assign('title', '添加套餐');
        $this->display();

    }


    /*
     *doaddmenu 添加商品套餐具体处理
     *
     *
     * */
    public function doaddmenu()
    {

        $send = I();
        $pid = $send['pid'];//产品的id
        $spemenu = D('Spemenu');
        if ($spemenu->create($send)) {
            $res = $spemenu->add();
            if ($res) {
                echo '添加成功';
            } else {
                echo '添加失败';
            }
        } else {
            echo $spemenu->getError();
        }
        //echo json_encode($send) ;


    }

    /*
    *menulist  商品套餐列表页
    *
    *
    * */
    public function menulist()
    {

        $send = I();
        $pid = $send['pid'];//产品的id
        $spemenu = D('Spemenu');
        $menulist = $spemenu->getmenulist($pid);
//        var_dump($menulist);
        $this->assign('menulist', $menulist);


        $this->assign('pid', $pid);

        $this->assign('title', '套餐列表页');
        $this->display();

    }


    /*
    *menuchg  商品套餐修改页
    *
    *
    * */
    public function menuchg()
    {

        $send = I();
        $smid = $send['smid'];//产品的id
        $Spemenu = D('Spemenu');
        $spemenu = $Spemenu->getmenubypid($smid);


        $product = D('Product');
        $pro = $product->getprobyid($spemenu['pid']);

        $this->assign('pname', $pro['pname']);

        $this->assign('smname', $spemenu['smname']);
        $this->assign('smprice', $spemenu['smprice']);
        $this->assign('pid', $spemenu['pid']);
        $this->assign('smdesc', $spemenu['smdesc']);
        $this->assign('smid', $smid);
        $this->assign('title', '修改套餐');
        $this->display();

    }

    /*
     * 修改套餐属性操作
     *
     * */

    public function dochgmenu()
    {
        $send = I();
        $pid = $send['pid'];//产品的id
        $spemenu = D('Spemenu');
        if ($spemenu->create($send)) {
            $res = $spemenu->save();
            if ($res === false) {
                echo '修改失败';
            } else {
                echo '修改成功';
            }
        } else {
            echo $spemenu->getError();
        }
    }


    /*
     *删除套餐
     * */

    public function menudel()
    {
        $send = I();
        $smid = $send['smid'];
        $spemenu = D('Spemenu');
        //print_r($smid);
        $dn = $spemenu->where("smid = $smid")->delete();//返回删除的记录数
        if ($dn === false) {
            echo 0;

        } else {
            echo 1;
        }

    }


}