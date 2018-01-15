<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/1/25
 * Time: 12:17
 * PowerBy 万域网络技术团队
 *
 * 关于用户的控制器，管理员控制器
 */

namespace Wanyu\Controller;


class AdminController extends CommonController
{


    /*
     * 前置操作，用来做导航active，显示当前导航
     * */
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('active', 5);
    }


    /*管理员列表页*/
    public function index()
    {
        $this->redirect('Admin/manage', '', 0, '页面跳转中...');
    }


    /*管理员列表页*/
    public function manage()
    {

        $seid = I('seid', '', 'htmlspecialchars,trim');
        $idcard = I('idcard', '', 'htmlspecialchars,trim');
        $usertype = I('usertype', '', 'htmlspecialchars,trim');
        $islock = I('islock', '', 'htmlspecialchars,trim');
        $search = I('search') ;
        if ( $search != 1) {
            //没有搜索条件
            $where = array('id' => array('GT', '0'));//大于0
        } else {
            if (!empty($seid)){
                $where = array('username' => array('like', "%$seid%"));
                $this->assign('seid',$seid);
            }

            if (!empty($idcard)){
                $where['idcard']=  array('like', "%$idcard%");
                $this->assign('idcard',$idcard);

            }

            if (!empty($usertype)){
                $where['usertype']=  $usertype;
                $this->assign('searusertype',$usertype);

            }
            if (!empty($islock)){
                $where['islock']=  $islock == 1 ? 1 : 0 ;
                $this->assign('searislock',$islock);
            }


        }

        //当成一对一来处理
       /* $count = M('admin')->field('password', true)->where($where)->count();

        $page = new \Common\Lib\Page($count, 10);
        $page->rollPage = 7;
        $page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $limit = $page->firstRow . ',' . $page->listRows;


        $list = M('admin')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集

        $show= $page->show();// 分页显示输出
        p($show);*/
        /*权限的选择，非超级管理员的要过滤*/







        $adminmodel = D('admin');
        $adminid = session(C('USER_AUTH_KEY'));

        $admin_now = $adminmodel->field('password,encrypt', true)->find($adminid);
//        p($admin_now);
//        p($admin_now['usertype']===null);
        if ($admin_now['usertype'] !== '9') {
            //如果不是超级管理员的话，只搜出自己一条信息
            $where = array_merge($where, array('id' => $adminid));
        }


        /*******分页************/
        //分页
        $onepagenum = 10;//每一页的数据条数
        $nowpage = I('nowpage') == ''  ? 1 : intval(I('nowpage')); // 发送过来的页码
        $admins = $adminmodel->field('password,encrypt', true)->where($where)->select(); //view;
//        echo  $adminmodel->getLastSql();
        $allnum = count($admins);
        $pagecount  =  ceil(floatval($allnum)/floatval($onepagenum));//总页数


        /*** 排序 ***/

        $sort  = I('sort') == '' ? 'seid' : I('sort') ;
        $sorttype  = I('sorttype') ==''  ? 'desc' :  I('sorttype') ;
        $wypage  = I('wypage') ==''  ? 0 :  I('wypage') ;//是否分页
        $issort = I('issort') ==''  ? 0 :  I('issort') ;//是否排序
        $this->assign('sort',$sort);
        $this->assign('issort',$issort);
        $this->assign('wypage',$wypage);//用来判断是否分页过
        if($wypage != 1){
            //不是分页
            $this->assign('sorttype',$sorttype == 'asc' ? 'desc' : 'asc');
        }else{
            //分页的情况是不改变的
            $this->assign('sorttype',$sorttype);
        }

        $admins = $adminmodel->field('password,encrypt', true)->where($where)->order(" $sort $sorttype ")->limit(($nowpage-1)*$onepagenum,$onepagenum)->select(); //view;
//        echo $adminmodel->_sql();
        if ($admins) {
            foreach ($admins as $k => $v) {
                $admins[$k]['pseid'] = $adminmodel->getseidByAdminid($admins[$k]['pid']) == 0 ? '公司管理员' : $adminmodel->getseidByAdminid($admins[$k]['pid']) ;
            }
        }
//        $adminmodel->checkUsertype(2);





        //    p($admins);
        $this->assign('allnum',$allnum);
        $this->assign('pagecount',$pagecount);
        $this->assign('nowpage',$nowpage);


        $this->assign('admins', $admins);
        $this->assign('user', $admins);//输出用这个

//        $this->assign('page', $show);
//        $this->assign('limit', $limit);
        $this->assign('usertype', $admin_now['usertype']);

        $this->assign('title', '管理员列表');
        $this->display();
    }

    /*
     * 进入修改账号密码页面
     *
     * */
    /*public function changepasd(){
        $adminid  = I('adminid');
//        var_dump($adminid);
        $map = array('id'=>$adminid);
        $admin = D('Admin')->where($map)->find();

        $this->assign('admin',$admin);
        $this->assign('title','修改密码');
        $this->display();
    }*/


    /*修改账号密码*/
    /*public function dochangepassd(){
        $send = I();
//        print_r($send);
//        print_r($_SESSION);
        $admin = D("Admin"); // 实例化User对象
        if (!$admin->create()){
            // 如果创建失败 表示验证没有通过 输出错误提示信息
            exit($admin->getError());
        }else{
            $admin = D('Admin');
           if($admin->checkpassd($send['hpassword'])){
              if ($admin->checkqpassd($send['password'],$send['qpassword'])){
                  $admin->changepassd($send['password']);
                    echo '修改成功';
              }else{
                    echo "确认密码和新密码不相同";
              }
           }else{
                echo "原密码填写不正确";
           }
        }

    }*/

    /*删除管理员*/
    public function deladmin()
    {
        $adminid = I('adminid');
        $batchFlag = I('get.batchFlag', 0, 'intval');
        //批量删除
        if ($batchFlag) {
            $this->deladminAll();
            return;
        }

        if (M('Admin')->delete($adminid)) {

            M('role_user')->where(array('admin_id' => $adminid))->delete();
            $this->success('删除成功', U('Admin/index'));
        } else {

            $this->error('删除失败');
        }


    }


    //指量删除用户处理
    public function deladminAll()
    {

        $idArr = I('key');
        if (isset($idArr) && !is_array($idArr)) {
            $this->error('请选择要删除的列');
        }


        if (M('admin')->where(array('id' => array('in', $idArr)))->delete()) {
            M('role_admin')->where(array('admin_id' => array('in', $idArr)))->delete();
            $this->success('删除成功', U('Admin/index'));
        } else {
            $this->error('删除成功');
        }

    }

    /*新增管理员页面*/
    /*public function addadmin(){
        $this->assign('title','新增管理员');
        $this->display();
    }*/


    /*新增管理员 我写的*/
    /*public function doaddadmin(){
        $send = I();
        $rules = array(
            array('username','','管理员名称已经存在！',0,'unique',1), // 在新增的时候验证username字段是否唯一
            array('qpassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
        );
//        var_dump($send) ;
        $admin = D("Admin");
        if (!$admin->validate($rules)->create()){
            // 如果创建失败 表示验证没有通过 输出错误提示信息
            exit($admin->getError());
        }else{
            // 验证通过 可以进行其他数据操作
//           echo GetSixRandom();
             if ( !$admin->addadmin($send['username'],$send['password'],GetSixRandom())){
                 echo '添加失败';
             }else{
                 echo '添加成功';
             }
        }
    }*/

    /*新增的用户 */
    //添加/编辑用户 借鉴
    public function addadmin()
    {

        if (IS_POST) {
            $this->addadminPost();
            exit();
        }

        $adminid = I('adminid', 0, 'intval');
        $adminmodel = D('admin');

        if ($adminid == 0) {
            /*普通的情况三个都显示*/
            $usertype = array(
                '1' => '普通代理',
                '2' => '银牌代理',
                '3' => '金牌代理',
            );


            $this->assign('usertype', $usertype);


            //添加页面
            $this->assign('title', '添加用户');
            $seids = $adminmodel->field('id,seid')->order('seid')->select();//所有代理的id 和seid
            //p($seids);
            $this->assign('seids',$seids);
            $this->assign('product', D('product')->select());//产品列表
            $this->display();



        } else {
            $seid = $adminmodel->getseidByAdminid($adminid);
            $seids = $adminmodel->field('id,seid')->order('seid')->where('seid < '.$seid)->select();//所有代理的id 和seid
            //p($seids);
            $this->assign('seids',$seids);
            $admin = M('admin')->find($adminid);
            if ($admin) {
                $admin['password'] = '';
            }



            switch ($admin['usertype']) {
                case '1' :
                    $admin['usertypename'] = '普通代理';
                    break;
                case '2' :
                    $admin['usertypename'] = '银牌代理';
                    break;
                case '3' :
                    $admin['usertypename'] = '金牌代理';
                    break;
                case '9' :
                    $admin['usertypename'] = '公司管理员';
                    break;
                default :
                    $admin['usertypename'] = '普通代理';

            }

            $usertype = $adminmodel->getUsertypelist($adminid);//获得select的list
//            p($admin);
            $this->assign('usertype', $usertype);
            $where = array('id' => $admin['pid']);
            $master = M('admin')->where($where)->field('id,seid')->find();//推荐他的人
            $admin['master'] = $master;
            /* $master Array
             (
                 [id] => 1
                 [seid] => 0
             )*/


            /*$userRote = M('role_admin')->where(array('admin_id' => $adminid))->getField('role_id', true);
            if (!is_array($userRote)) {
                $userRote = array(0);
            }
            $role = M('role')->select();
            $this->assign('userRote', $userRote);
            $this->assign('role', $role);
            */




//            p($admin);
            //修改页面
            $this->assign('title', '修改用户');
            $this->assign('adminid', $adminid);
            $this->assign('admin', $admin);

            $this->display();
        }

    }


    //添加用户处理 借鉴
    public function addadminPost()
    {

        //M验证
        $validate = array(

            array('username', '', '用户名已经存在！', 0, 'unique', 1),
            array('qpassword', 'password', '确认密码不正确', 0, 'confirm'), // 验证确认密码是否和密码一致
            array('pid','require','订单没有填写！'), // 检验订单是否填了
        );
//        $data = D('admin');
        $adminmodel = D('admin');

        $idcard = I('idcard', '', 'htmlspecialchars,trim');//身份证
      /*  if($adminmodel->isIdcardInnerSix($idcard)){
            //如果身份证没有满6次
      */
            if (!$adminmodel->validate($validate)->create()) {
                $this->error($adminmodel->getError());
            }
            $usertype = I('usertype', 0, 'intval');
            /*switch ($usertype){
                case 1:{
                    $yintime = null;
                    $jintime = null;
                    break;
                }
                case 2:{
                    $yintime = time();
                    $jintime = null;
                    break;
                }
                case 3:{
                    $yintime = null;
                    $jintime = time();
                    break;
                }
                default:{
                    $yintime = null;
                    $jintime = null;
                    break;
                }
            }*/
            $yintime = null;
            $jintime = null;

            /*找出推荐人的排序id*/
            $masterid = I('masterid', '', 'htmlspecialchars,trim');//推荐人的seid
            if (!$masterid&&$masterid!== '0') {
                $this->error('推荐人不填');
            } else {
                $seids = $adminmodel->getallseids();
                $seidarr = array();
                foreach ($seids as $s) {
                    array_push($seidarr, $s['seid']);
                }
                if (!in_array(intval($masterid), $seidarr)) {
                    $this->error('推荐人不存在');
                }//填写的推荐人必须存在
            }
            $pid = M('admin')->where(array('seid' => $masterid))->field('id')->find();
            $pid = $pid['id'];

            $passwordinfo = I('password', '', 'get_password');
            $userData = array(
                'username' => I('username', '', 'htmlspecialchars,trim'),
                'password' => $passwordinfo['password'],
                'encrypt' => $passwordinfo['encrypt'],
                'logintime' => null,

                'loginip' => get_client_ip(),
                'pid' => $pid,//推荐自己的人 的adminid
                'usertype' => $usertype,
                'yintime' => $yintime,
                'jintime' => $jintime,

                //个人资料
                'registertime' => time(),
                'realname' => I('realname', '', 'htmlspecialchars,trim'),
                'sex' => I('sex', '', 'htmlspecialchars,trim'),
                'phone' => I('phone', '', 'htmlspecialchars,trim'),
                'email' => I('email', '', 'htmlspecialchars,trim'),
                'address' => I('address', '', 'htmlspecialchars,trim'),
                'idcard'  => I('idcard', '', 'htmlspecialchars,trim'),
                'addressofcreditcard'  => I('addressofcreditcard', '', 'htmlspecialchars,trim'),
                'creditcard'  => I('creditcard', '', 'htmlspecialchars,trim')


            );

            if ($userData['username'] === '') {
                $userData['username'] = $adminmodel->getseid();//自动生成seid,作为username
            } else {
                if (is_numeric($userData['username'])) {
                    if (!in_array(intval($userData['username']), $adminmodel->getseidempty($adminmodel->createseidtree(0)))) {
                        $this->error('你添加的用户编号不符合代理网图架构');
                    }
                } else {
                    $this->error('你添加的用户编号必须数字');
                }

            }


            if ($adminid = D('admin')->addadmin($userData)) {
//                $adminmodel->checkUsertype($pid);//更新推荐自己的人的usertype
                $seid = $adminmodel->getseidByAdminid($adminid);
                /*添加订单*/
                $productmodel = D('product');
                $order['otime'] = time();
                $order['adminid'] = $adminid;
                $order['pid'] = I('pid', '', 'htmlspecialchars,trim');
                if ($order['pid'] != null){
                    $promsg = $productmodel->find($order['pid']);//相应产品的信息
                    $order['additionalpprice'] = 0;
                    $order['additionalprice'] = I('additionalprice', '', 'htmlspecialchars,trim');
                    $order['additionalprice'] = is_numeric($order['additionalprice']) ?
                        floatval($order['additionalprice']) : 0;
                    $order['price'] = $promsg['price'];
                    $order['finalprice'] = floatval($order['price']) + $order['additionalprice'] ;
                    $order['finalpprice'] = $order['pprice'] = $promsg['pprice'];
                    $order['pv'] = $promsg['pv'];
                }
//            p($send);
                $orders = D('Order');
                if ($orders->create($order)) {
                    $res = $orders->add();
                    if ($res) {

                        $this->success('添加成员成功，添加订单成功 , 成员工号为'.$seid." 密码是 ".I('password', '', 'htmlspecialchars,trim'), U('Admin/index'),40);
                    } else {
                        $this->success('添加成员成功，添加订单失败, 成员工号为'.$seid." 密码是 ".I('password', '', 'htmlspecialchars,trim'), U('Admin/index'),40);
                    }
                } else {
                    $this->success('添加成员成功，添加订单失败, 成员工号为'.$seid." 密码是 ".I('password', '', 'htmlspecialchars,trim'), U('Admin/index'),40);
                }


            } else {

                $this->error('添加成员失败，添加订单失败');
            }
        /*}else{
            //满6次就添加失败
            $this->error('同一身份证号码不能重复使用超过6次了，添加成员失败，添加订单失败');

        }*/


    }


    //修改用户处理
    public function editadmin()
    {

        if (!IS_POST) {
            $this->error('参数错误!');
        }
        //M验证
        $password = trim($_POST['password']);
        $username = I('seid', '', 'htmlspecialchars,trim');
        $adminid = I('adminid', 0, 'intval');
//        $usertype = I('usertype', 0, 'intval');
        $adminmodel = D('admin');
        $a = $adminmodel->field('yintime,jintime')->find($adminid);
        $usertype = I('usertype', 0, 'intval');
        /*switch ($usertype){
            case 1:{
                $yintime = null;
                $jintime = null;
                break;
            }
            case 2:{
                $yintime = time();
                $jintime = null;
                break;
            }
            case 3:{
                $yintime = $a['yintime'];
                $jintime = time();
                break;
            }
            default:{
                $yintime = null;
                $jintime = null;
                break;
            }
        }*/
        if (empty($username)) {
            $this->error('用户名必须填写！');
        }

        if (M('admin')->where(array('username' => $username, 'id' => array('neq', $adminid)))->find()) {
           // echo $adminmodel->_sql();
            die();
            $this->error('用户名已经存在！');
        }
        /*找出推荐人的排序id*/
        $masterid = I('masterid', '', 'htmlspecialchars,trim');//推荐人的seid
        if ($masterid === '') {
            $this->error('推荐人不填');
        } else {
            $seids = D('Admin')->getallseids();
            $seidarr = array();
            foreach ($seids as $s) {
                array_push($seidarr, $s['seid']);
            }
            if (!in_array(intval($masterid), $seidarr)) {
                $this->error('推荐人不存在');
            }//填写的推荐人必须存在
        }
        $pid = M('admin')->where(array('seid' => $masterid))->field('id')->find();
        $pid = $pid['id'];//要修改的推荐自己的人的id

        $data = array(
            'id' => $adminid,
            'username' => $username,
            'realname' => I('realname', '', 'htmlspecialchars,trim'),
//            'logintime' => null,
            'islock' => I('islock', 0, 'intval'),
            'pid' => $pid,
            'usertype' => $usertype,
            /*'yintime' => $yintime,
            'jintime' => $jintime,*/


            //个人资料
 
             
            'sex' => I('sex', '', 'htmlspecialchars,trim'),
            'phone' => I('phone', '', 'htmlspecialchars,trim'),
            'email' => I('email', '', 'htmlspecialchars,trim'),
            'address' => I('address', '', 'htmlspecialchars,trim'),
            'idcard'  => I('idcard', '', 'htmlspecialchars,trim'),
            'addressofcreditcard'  => I('addressofcreditcard', '', 'htmlspecialchars,trim'),
            'creditcard'  => I('creditcard', '', 'htmlspecialchars,trim')

        );


        //如果密码不为空，即是修改
        if (!$password == '') {
            $passwordinfo = I('password', '', 'get_password');
            $data['password'] = $passwordinfo['password'];
            $data['encrypt'] = $passwordinfo['encrypt'];
        }
        $oranalpid = $adminmodel->field('pid')->find($adminid);
        $oranalpid = $oranalpid['pid'];
        if (false !== M('admin')->save($data)) {
            $adminmodel->checkUsertype($oranalpid);//更新原来推荐自己的人的usertype
            $adminmodel->checkUsertype($pid);//更新现在推荐自己的人的usertype
             $adminmodel->checkUsertype($adminid);//更新自己的usertype
            /*$settlementmsgmodel = D('settlementmsg');
            $settlementmsgmodel->refreshmsgByAdminidAndTreepidAndPid($adminid);//刷新业绩*/
           
//            p(I());
            $this->success('修改成功', U('Admin/index'));
        } else {

            $this->error('修改失败');
        }

    }


    /*
     * 刷新数据，主要是代理类型的更新
     * 并且刷新页面
     *
     * */

    /*public function adminrefresh()
    {

        $admin = D('admin');
        $achievement = D('Achievement');
        $data = $admin->field('id,dirsalenum,usertype')->where('id <> 1')->select();
        foreach ($data as $k => $a) {
            $sao = $admin->getServeridsAndOrder($a['id']);//直推和订单情况
            $dirsalenum = $sao['sidnum'] ;//推荐的人 的数量
            $myachievement = $achievement->getbestachievement($a['id']);//自己直推的人的单pv总值，每人只有一张单
            if ($dirsalenum != $a['dirsalenum'] ){
                $data[$k]['dirsalenum'] = $dirsalenum;
            }
            if (intval($data[$k]['dirsalenum']) >= 20 && $myachievement >= 11250 ) {
                if ($data['usertype'] != 3 ) {
                    $data[$k]['usertype'] = 3;//金牌
//                    $data[$k]['yintime'] = null;
                    $data[$k]['jintime'] = time();
                }
            }
             else if (intval($data[$k]['dirsalenum']) >= 10 && $myachievement >= 3750) {
                if ($data['usertype'] < 2 ) {
                    $data[$k]['usertype'] = 2;//银牌
                    $data[$k]['yintime'] = time();
                    $data[$k]['jintime'] = null;
                }
            } else if (intval($data[$k]['dirsalenum']) < 10) {
                 if ($data['usertype'] != 1 ){
                     $data[$k]['usertype'] = 1;//普通代理
                     $data[$k]['yintime'] = null;
                     $data[$k]['jintime'] = null;
                 }

             } else {

                    $data[$k]['usertype'] = 1;//普通代理
                    $data[$k]['yintime'] = null;
                    $data[$k]['jintime'] = null;

            }
            $admin->save($data[$k]);//逐个更新数据
        }

        $this->redirect('manage');//返回列表页
    }*/
    
    
    
    /*
     * 审核员密码修改
     * 
     * */
    public function examinpasschg(){
        if (session('toexaminepass')){
            $send = I();
            $adminmodel = D('admin');
            //print_r($send);
            $exam = $adminmodel->field('encrypt,toexaminepass')->find(1);
            if (get_password($send['toexaminepass'],$exam['encrypt']) == $exam['toexaminepass']){
                //原密码相同
                if ($send['newtoexaminepass'] == $send['qnewtoexaminepass'] ){
//                    修改新审核密码
                    $data['toexaminepass'] = get_password($send['newtoexaminepass'],$exam['encrypt']);
                     
                    $data['id'] = 1;
                    if (($r = $adminmodel->save($data)) !== false ){
                        $this->success("审核密码修改成功");
                    }else{
                        $this->error("审核密码修改失败");
                    }
                }
            }else{
                $this->error('原审核密码错误');
            }
        }else{
            $this->error('你没有登录审核，请登录');
        }


        
    }




    


}