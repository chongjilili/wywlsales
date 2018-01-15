<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/1/26
 * Time: 17:52
 * PowerBy 万域网络技术团队
 */

namespace Wanyu\Model;

use Think\Model;

class AdminModel extends Model
{
    protected $_validate = array(

        array('hpassword', 'require', '密码不能为空！'),
        array('password', 'require', '新密码不能为空！'),
        array('qpassword', 'require', '确认密码不能为空！'),

    );


    /*
     * 确认密码是否正确
     *
     * @param $hpassword 外部填写的原密码
     *
     * @return boolean
     * */
    public function checkpassd($hpassword)
    {
        $adminid = session('wyadm_uid');
        $map = array('id' => $adminid);
        $admin = $this->where($map)->find();
//        var_dump($admin);
        $hpassword = get_password($hpassword, $admin['encrypt']);
        if ($admin['password'] == $hpassword) {

            return true;
        } else {

            return false;
        }

    }

    /*
     * 确认新密码和确认密码是否相同
     *
     * @param $password 新密码
     * @param $qpassword 确认密码
     *
     * @return boolean
     *
     *
     * */

    public function checkqpassd($password, $qpassword)
    {
        if ($password === $qpassword) {
            return true;
        } else {
            return false;
        }
    }


    /*
     * 修改密码
     *
     * @param $password
     *
     * @return boolean
     *
     * */

    public function changepassd($password)
    {
        $adminid = session('adminid');
        $map = array('id' => $adminid);
        $admin = $this->where($map)->field('encrypt')->find();
//        var_dump($admin);
        $password = get_password($password, $admin['encrypt']);
        $data['password'] = $password;
        return $this->where($map)->save($data);

    }


    /*
     * 新增管理员
     *
     * @param $username
     * @param $password
     * @param $encrypt
     *
     * @return adminid or boolean
     *
     * */
    /* public function addadmin($username,$password,$encrypt){
         $password = get_password($password,$encrypt);
         $admin['username'] = $username;
         $admin['password'] = $password;
         $admin['encrypt'] = $encrypt;
        // echo $encrypt;
         return $this->add($admin);

     }*/

    public function addadmin($userData)
    {

        $userData['seid'] = intval($userData['username']);
        return $this->add($userData);

    }
    /*$userData     = array(
    'username'  => I('username', '', 'htmlspecialchars,trim'),
    'password'  => $passwordinfo['password'],
    'encrypt'   => $passwordinfo['encrypt'],
    'realname'  => I('realname', '', 'htmlspecialchars,trim'),
    'logintime' => time(),
    'loginip'   => get_client_ip(),
    'pid'       => $pid,
    'usertype'  => $usertype,
    );*/


    /*
     * 获得现在又要的seids，即是所有现在成员
     *
     * */
    public function getallseids()
    {
        return $this->field('seid')->select();
    }


    /*
         * 获得现在又要的ids，即是所有现在成员
         *
         * */
    public function getalladminids()
    {
        return $this->field('id')->select();
    }


    /*
     * 系统自动生成seid
     *
     *
     *************************************
     *  有三个优先级
     *  一、层数小的优先
     *  二、余数小的优先，余数为0的当做3比较
     *  三、数字小的优先
     *************************************
     *
     *
     * */
    public function getseid()
    {
        /*遍历三叉书获得seid*/
        $seid_tree = $this->createseidtree(0);//激活不激活都包括
//        p($seid_tree);
        $rightseid = $this->getseidintree($seid_tree);
//        p($rightseid);
        return $rightseid;
    }

    /*
     *@param $seid_tree seid组成的三叉树
     *返回优先添加的 seid ，作为系统生成
     *
     ************************************
     *  有三个优先级
     *  一、层数小的优先
     *  二、余数小的优先，余数为0的当做3比较
     *  三、数字小的优先
     *************************************
     *
     * */
    public function getseidintree($seid_tree)
    {
        $emyseids = array();
        $priority1 = array();//第一优先级的数组
        $priority2 = array();//第二优先级的数组
        $priority3 = -1;//第三优先级的数组

        $emyseids = $this->getseidempty($seid_tree);
//        asort($emyseids);

        /* *******************************************************
        一、找出最小的seid，并且求出其所在的层数 ，  找出该层数所有的seid，实现第一优先级
        *
        ***/
        $minseid = min($emyseids);
        $level = $this->getlevel($minseid);

        foreach ($emyseids as $seid) {
            if ($this->getlevel($seid) === $level) {
                array_push($priority1, $seid);
            }
        }


        /******************************************************
         * 二、在第一优先级的基础上，找出所有最小余3余数的seid，实现第二优先级 */
//        p($priority1);
        $priority2 = $this->getremainders2($priority1, $level);
//        p($priority2);
        /******************************************************
         * 二、在第一、二优先级的基础上，找出所有最小数的seid，实现第三优先级 */
        $priority3 = min($priority2);


        return $priority3;
    }


    /*
     * @param $nums,某一层的seids
     * @param $level 添加所在层数
     * 升级版函数
     * 递归返回数组里面除1、3、9、27、81.......3^($level-1) 余数最小的所有seids($nums)
     * 一层帅选，输出最后的数组
     * */

    public function getremainders2($nums, $level)
    {
        //$nums  = array(16,17,18,19,31);
        $l = 1;//层数
        $mod = pow(3, $level - 1);//除数1,3,9,27......
        $levelremainer = (pow(3, $level - 1) - 1) / 2; // 每一mod对应的首个余数，如1=>0,3=>1,9=>4,27=>13,81=>40;
        $priority3 = array();//率选出来的数据seid
        while ($l <= $level) {
            $priority3 = array();
            $mod = pow(3, $l - 1);//除数1,3,9,27......
            $levelremainer = (pow(3, $l - 1) - 1) / 2; // 每一mod对应的首个余数，如1=>0,3=>1,9=>4,27=>13,81=>40;
            $minremainer = $mod - 1;//最小余数
            foreach ($nums as $n) {
                //遍历所有的seid
                $r = ($n - $levelremainer) % $mod;//余数
                $minremainer = ($minremainer > $r) ? $r : $minremainer;//获取最小余数
            }

            foreach ($nums as $n) {
                //遍历所有的seid
                $r2 = ($n - $levelremainer) % $mod;//余数
                if ($r2 === $minremainer) {
                    array_push($priority3, $n);
                }
            }
//            p($priority3);
            if (count($priority3) <= 1) {
                //只剩下一个，不用继续了
                break;
            }

            $nums = $priority3;
            $l++;
        }

        return $priority3;
    }


    /*
     * @param $seids
     *
     * 返回数组里面除3余数最小的所有seids($nums)
     * */

    public function getremainders($nums)
    {
        $remainder = 3;
        $res = array();
        //遍历找出最小余数
        foreach ($nums as $num) {
            $re = intval($num) % 3;
            $re = $re === 0 ? 3 : $re;
            if ($remainder > $re) {
                $remainder = $re;
            }
        }

        foreach ($nums as $n2) {
            $re = intval($n2) % 3;
            $re = $re === 0 ? 3 : $re;

            if ($remainder == $re) {
                array_push($res, $n2);

            }
        }
        return $res;
    }


    /*
     * @param $seid
     *
     * 返回该seid 的层数
     * */

    public function getlevel($seid)
    {
        if (intval($seid) <= 0) {
            return 0;
        }
        $i = 1;
        while (true) {

            if (((pow(3, $i) - 1) * 3 / 2) >= intval($seid)) {
                break;
            }
            $i++;
        }
        return $i;
    }


    /*递归找出所有有机会的seid，就是empty的数组*/

    public function getseidempty($seid_tree)
    {
        $emyseids = array();
        foreach ($seid_tree as $k => $subtree) {
            if (is_array($subtree)) {
                if (empty($subtree)) {

                    array_push($emyseids, intval($seid_tree[0]) * 3 + intval($k));
                } else {
                    $emyseids = array_merge($emyseids, $this->getseidempty($subtree));
                }
            }

        }

        return $emyseids;
    }



    /*
     *
     *
     * 获得每个月的间推的人
     *
     * */
    public function getIndirSeidsOfMonth($adminid,$firsttime = "2017-01"){
        $firsttime = strtotime($firsttime);//最早的月份的时间戳
        $monnum = 1;
        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳
        $indirpeople = array();
        $indirpeople[date('Y-m', time())] = $this->getIndirSeids($adminid,$datethismonth, $datenow);
        while (true) {


            $datemonth = date('Y-m', strtotime("-" . $monnum . " Months", $datethismonth));//从上个月开始的
            $datemonth = strtotime($datemonth);
            $edatemonth = date('Y-m', strtotime("-" . ($monnum - 1) . " Months", $datethismonth));//从上个月开始的
            $edatemonth = strtotime($edatemonth);
            if ($datemonth >= $firsttime) {
                $indirpeople[date('Y-m', strtotime("-" . $monnum . " Months", $datethismonth))] = $this->getIndirSeids($adminid,$datemonth, $edatemonth);
            } else {
                break;
            }

            $monnum++;
        }
        return $indirpeople;
    }

    /*
     *
     *
     * 获得某段时间内的间接下属
     *
     * */
    public function getIndirSeids($adminid,$starttime = '', $endtime = ''){

        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }

        
        $lma = $this->getLevelMagArr($adminid);//所有层的下属，seid
        $serverids = D('Achievement')->getseveradmins($adminid, '', '', 2);//返回的是seid
        $serverids = explode(',', $serverids);//直推过的人，数组
        $indirseids = array();

        foreach ($lma as $lmak => $lmav ){
            if (!empty($lmav)){
                foreach ($lmav as $lmavseid){
                    if (!in_array($lmavseid,$serverids )){
                        //不是直推，是间推
                        $w['seid'] = $lmavseid;
                        $registertime = $this->field('registertime')->where($w)->find();
                        if ($registertime['registertime'] >=$starttime && $registertime['registertime'] <=$endtime ){
                            array_push($indirseids, $lmavseid);
                        }
                    }
                }
            }
        }

        return $indirseids;


    }
















        /*
         * 处理汇总层信息，
         * 直推的人，间推的人，总的人
         *
         * @param $adminid
         * @param $levelmsg 每层的seid  getLevelMagArr返回的
         *
         * return $Layermsg
         *   Array
         *       (
         *           [1] => Array
         *               (
         *                   [allnum] => 3
         *                   [dirnum] => 2
         *                   [indirnum] => 1
         *               )
         *
         *           [2] => Array
         *               (
         *                   [allnum] => 0
         *                   [dirnum] => 0
         *                   [indirnum] => 0
         *               )
         *
         *       )
         * */






    public function gatherLayernummsg($adminid, $levelmsg)
    {
        $Layermsg = array();
        $serverids = D('Achievement')->getseveradmins($adminid, '', '', 2);//返回的是seid
        $serverids = explode(',', $serverids);//直推过的人，数组
        foreach ($levelmsg as $level => $lseidarr) {
            $Layermsg[$level] = array();
            $Layermsg[$level]['allnum'] = count($lseidarr);//总数
            $dirnum = 0;
            foreach ($lseidarr as $lseid) {
                if (in_array($lseid, $serverids)) {
                    $dirnum++;
                }
            }
            $Layermsg[$level]['dirnum'] = $dirnum;//直推的人数
            $Layermsg[$level]['indirnum'] = $Layermsg[$level]['allnum'] - $Layermsg[$level]['dirnum'];
        }
//        p($levelmsg);
        return $Layermsg;


    }


    /*
     *
     * @param $adminid
     * @param $levelmsg 每层的seid  getLevelMagArr返回的
     *
     *
     * */
    public function gatherLayerDetailMsg($adminid, $levelmsg)
    {
        $Layermsg = array();
        $serverids = D('Achievement')->getseveradmins($adminid, '', '', 2);//返回的是seid
        $serverids = explode(',', $serverids);//直推过的人，数组
        foreach ($levelmsg as $level => $lseidarr) {

            $Layermsg[$level] = array();
            $Layermsg[$level]['dir'] = array();//直推的人的数据
            $Layermsg[$level]['indir'] = array();//间推的人的数据
            $Layermsg[$level]['dirnum'] = 0;
            $Layermsg[$level]['indirnum'] = 0;
            $Layermsg[$level]['dir']['普通代理'] = $Layermsg[$level]['dir']['银牌代理'] = $Layermsg[$level]['dir']['金牌代理'] = array();
            $Layermsg[$level]['indir']['普通代理'] = $Layermsg[$level]['indir']['银牌代理'] = $Layermsg[$level]['indir']['金牌代理'] = array();
            $Layermsg[$level]['dir']['newputongnum'] = $Layermsg[$level]['dir']['newyinnum'] = $Layermsg[$level]['dir']['newjinnum'] = 0;
            $Layermsg[$level]['indir']['newputongnum'] = $Layermsg[$level]['indir']['newyinnum'] = $Layermsg[$level]['indir']['newjinnum'] = 0;
            $Layermsg[$level]['dir']['newputongarr'] = $Layermsg[$level]['dir']['newyinarr'] =  $Layermsg[$level]['dir']['newjinarr'] = array();
            $Layermsg[$level]['indir']['newputongarr'] = $Layermsg[$level]['indir']['newyinarr'] =  $Layermsg[$level]['indir']['newjinarr'] = array();
            foreach ($lseidarr as $lseid) {
                //遍历每一层的seid，并且获得每一个人
                if (in_array($lseid, $serverids)) {
                    $Layermsg[$level]['dirnum']++;//直推的人数
                    $dirserver = $this->field('id,seid,usertype')->where('seid = ' . $lseid)->find();//其中一个直推的人的信息
                    switch ($dirserver['usertype']) {
                        case 1 :
                            $dirserver['usertype'] = '普通代理';
                            array_push($Layermsg[$level]['dir']['普通代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['dir']['newputongnum']++;
                                array_push($Layermsg[$level]['dir']['newputongarr'], $lseid);
                            }
                            break;
                        case 2 :
                            $dirserver['usertype'] = '银牌代理';
                            array_push($Layermsg[$level]['dir']['银牌代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['dir']['newyinnum']++;
                                array_push($Layermsg[$level]['dir']['newyinarr'], $lseid);
                            }
                            break;
                        case 3 :
                            $dirserver['usertype'] = '金牌代理';
                            array_push($Layermsg[$level]['dir']['金牌代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['dir']['newjinnum']++;
                                array_push($Layermsg[$level]['dir']['newyinarr'], $lseid);
                            }
                            break;
                        case 9 :
                            $dirserver['usertype'] = '公司管理员';
                            break;
                        default :
                            $dirserver['usertype'] = '普通代理';
                            array_push($Layermsg[$level]['dir']['普通代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['dir']['newputongnum']++;
                                array_push($Layermsg[$level]['dir']['newputongarr'], $lseid);
                            }
                    }
                    array_push($Layermsg[$level]['dir'], $dirserver);


                } else {
                    $Layermsg[$level]['indirnum']++;
                    $dirserver = $this->field('id,seid,usertype')->where('seid = ' . $lseid)->find();//其中一个直推的人的信息
                    switch ($dirserver['usertype']) {
                        case 1 :
                            $dirserver['usertype'] = '普通代理';
                            array_push($Layermsg[$level]['indir']['普通代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['indir']['newputongnum']++;
                                array_push($Layermsg[$level]['indir']['newputongarr'], $lseid);
                            }

                            break;
                        case 2 :
                            $dirserver['usertype'] = '银牌代理';
                            array_push($Layermsg[$level]['indir']['银牌代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['indir']['newyinnum']++;
                                array_push($Layermsg[$level]['indir']['newyinarr'], $lseid);
                            }

                            break;
                        case 3 :
                            $dirserver['usertype'] = '金牌代理';
                            array_push($Layermsg[$level]['indir']['金牌代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['indir']['newjinnum']++;
                                array_push($Layermsg[$level]['indir']['newjinarr'], $lseid);
                            }
                            break;
                        case 9 :
                            $dirserver['usertype'] = '公司管理员';
                            break;
                        default :
                            $dirserver['usertype'] = '普通代理';
                            array_push($Layermsg[$level]['indir']['普通代理'], $lseid);

                            if ($this->isThisMonthAddOfSeid($lseid)) {
                                $Layermsg[$level]['indir']['newputongnum']++;
                                array_push($Layermsg[$level]['indir']['newputongarr'], $lseid);
                            }

                    }
                    array_push($Layermsg[$level]['indir'], $dirserver);
                }
            }


            $Layermsg[$level]['dir']['newyinarr'] = implode(',',$Layermsg[$level]['dir']['newyinarr'] );
            $Layermsg[$level]['dir']['newjinarr'] = implode(',',$Layermsg[$level]['dir']['newjinarr'] );
            $Layermsg[$level]['dir']['newputongarr'] = implode(',',$Layermsg[$level]['dir']['newputongarr'] );

            $Layermsg[$level]['indir']['newyinarr'] = implode(',',$Layermsg[$level]['indir']['newyinarr'] );
            $Layermsg[$level]['indir']['newjinarr'] = implode(',',$Layermsg[$level]['indir']['newjinarr'] );
            $Layermsg[$level]['indir']['newputongarr'] = implode(',',$Layermsg[$level]['indir']['newputongarr'] );
            $Layermsg[$level]['allnum'] = $Layermsg[$level]['dirnum'] + $Layermsg[$level]['indirnum'];
        }
//        p($Layermsg);
        return $Layermsg;
    }


    /*
     * @param $adminid
     *
     * @param $fillter 1要过滤没有激活的，默认为1
     * 获得某seid树下的每一层的情况，
     * 返回每层的seid
     * return $levelmsg
     *  Array
     *  (
     *      [1] => Array
     *         (
     *               [0] => 1
     *               [1] => 2
     *               [2] => 3
     *         )
     *
     *      [2] => Array
     *          (
     *             [0] => 4
    **             [1] => 5
     **            [2] => 6
      *             [3] => 7
      *            [4] => 10
      *         )
     **
      **         [3] => Array
       *         (
      *         )
      *
      *     )
     * */
    public function getLevelMagArr($adminid, $json_arr = array(), &$levelmsg = array(),$fillter=1)
    {

        if (empty($json_arr)) {
            //获得组织图的结构树图
//            p($this->findSeidtreeByadminid($this->createseidtree(), $adminid));
            $this->convertToRightJsonarr2($this->findSeidtreeByadminid($this->createseidtree(), $adminid), $json_arr);

        }

        /*[name] => 5
          [size] => 2
          [children] => Array
              (
                  [0] => Array
                      (
                          [name] =>
                          [size] => 3
                      )

                  [1] => Array
                      (
                          [name] =>
                          [size] => 3
                      )

                  [2] => Array
                      (
                          [name] =>
                          [size] => 3
                      )

              )*/

        if (!empty($json_arr['children'])) {

            foreach ($json_arr['children'] as $k => $child) {

                if (!is_array($levelmsg[$child['size']])) {
                    $levelmsg[$child['size']] = array();


                }
                //var_dump($child['name']);
                if ($child['name'] != ' ') {
                    if ($fillter == 1){
                        if ($this->isislock($this->getAdminidBySeid(intval($child['name'])))){
                            //要激活的push
                            array_push($levelmsg[$child['size']], $child['name']);
                        }
                    }else{
                        //不用过滤
                        array_push($levelmsg[$child['size']], $child['name']);
                    }


                }

                $this->getLevelMagArr($adminid, $child, $levelmsg);
            }
        }

        //p($levelmsg);
        return $levelmsg;


    }


    /*
     *
     * @param $adminid
     *
     * 转换成适合的d3组织树图的数组结构，转换成json，
     * 并且写入seidtree.json文件
     *
     *
     *
     **/
    public function picjson($adminid = 1)
    {
        $adminid = intval($adminid);
        $seidtree = $this->createseidtree();
        $json_arr = array();


        // p($seidtree);

        if ($adminid > 1) {
            $seidtree = $this->findSeidtreeByadminid($seidtree, $adminid);//返回子树
        }


        $this->convertToRightJsonarr($seidtree, $json_arr,1, $adminid);
        //p($json_arr);

        $json_str = json_encode($json_arr);//转回json


        $myfile = fopen(APP_PATH . "/Wanyu/View/public/js/seidtree.json", "w") or die("找不到资源文件！");

        fwrite($myfile, $json_str);

        fclose($myfile);

        return $json_arr;
    }


    /*转换成适合的d3组织树图的数组结构，空白不留空
     * @param 我写的数组树
     * @$json_arr 返回的数组
     * @param $size 层数，一开始默认为1
     * $adminid 不是1的话最多只能看6层
     * return array
     * */

    public function convertToRightJsonarr($seidtree, &$json_arr, $size = 1, $adminid = 1,$name=0)
    {

        if (empty($seidtree)) {
            //为空，配一个空节点
            $json_arr = array(
                "name" => $name,
                "size" => $size - 1,
                "pseid"=> '无'
            );
        } else {
//            getUsertypeBySeid
            $json_arr["name"] = ($seidtree[0] == 0 ? '公司管理员' : $seidtree[0]);//seid
            $json_arr["usertype"] = $this->getUsertypeBySeid($seidtree[0]);

            $json_arr["pseid"] = $this->getParentSeidBySeid($json_arr["name"]);
            $json_arr["pseid"] = $json_arr["pseid"] == 0 ? '公司管理员' : $json_arr["pseid"];
            if ($size != 7 || $adminid == 1) {
                $json_arr["children"] = array(
                    array("name" => $seidtree[0]*3+1, "size" => $size),
                    array("name" => $seidtree[0]*3+2, "size" => $size),
                    array("name" => $seidtree[0]*3+3, "size" => $size)
                );
                $this->convertToRightJsonarr($seidtree[1], $json_arr["children"][0], $size + 1, $adminid,$seidtree[0]*3+1);
                $this->convertToRightJsonarr($seidtree[2], $json_arr["children"][1], $size + 1, $adminid,$seidtree[0]*3+2);
                $this->convertToRightJsonarr($seidtree[3], $json_arr["children"][2], $size + 1, $adminid,$seidtree[0]*3+3);
            }

        }

    }




    /*转换成适合的d3组织树图的数组结构,空白留空
     * @param 我写的数组树
     * @$json_arr 返回的数组
     * @param $size 层数，一开始默认为1
     * $adminid 不是1的话最多只能看6层
     * return array
     * */

    public function convertToRightJsonarr2($seidtree, &$json_arr, $size = 1, $adminid = 1)
    {

        if (empty($seidtree)) {
            //为空，配一个空节点
            $json_arr = array(
                "name" => " ",
                "size" => $size - 1,
                "pseid"=> '无'
            );
        } else {
//            getUsertypeBySeid
            $json_arr["name"] = ($seidtree[0] == 0 ? '公司管理员' : $seidtree[0]);//seid
            $json_arr["usertype"] = $this->getUsertypeBySeid($seidtree[0]);

            $json_arr["pseid"] = $this->getParentSeidBySeid($json_arr["name"]);
            $json_arr["pseid"] = $json_arr["pseid"] == 0 ? '公司管理员' : $json_arr["pseid"];
            if ($size != 7 || $adminid == 1) {
                $json_arr["children"] = array(
                    array("name" => ' ', "size" => $size),
                    array("name" => ' ', "size" => $size),
                    array("name" => ' ', "size" => $size)
                );
                $this->convertToRightJsonarr2($seidtree[1], $json_arr["children"][0], $size + 1);
                $this->convertToRightJsonarr2($seidtree[2], $json_arr["children"][1], $size + 1);
                $this->convertToRightJsonarr2($seidtree[3], $json_arr["children"][2], $size + 1);
            }

        }





        /*foreach ($seidtree as $k => $t ){
        }*/


    }


    /*
     * 通过adminid 来返回子树
     * @$adminid id
     * @$seid_tree 原树
     *
     * return $sunseid_tree
     * */
    public function findSeidtreeByadminid($seid_tree, $adminid)
    {
        if ($adminid == 1) {
            return $seid_tree;
        }
        $subseid_tree = array();

        $seidarr = D('Admin')->field('id,seid')->find($adminid);
        $seid = $seidarr['seid'];
        $subseid_tree = $this->findSeidtreeBySeid($seid_tree, $seid);

        return $subseid_tree;

    }


    /*
     *通过 $seid 来返回子树
     * @$seid id
     * @$seid_tree 原树
     *
     * return $sunseid_tree
     * */
    public function findSeidtreeBySeid($seid_tree, $seid)
    {
        $rsubseid_tree = array();
        foreach ($seid_tree as $subseid_tree) {

            if (is_array($subseid_tree) && (!empty($subseid_tree))) {

                if ($subseid_tree[0] == $seid) {

                    $rsubseid_tree = $subseid_tree;
                    break;
                } else {
                    $rsubseid_tree = $this->findSeidtreeBySeid($subseid_tree, $seid);
                    if (!empty($rsubseid_tree)) {
                        break;
                    }
                }
            }
        }
        return $rsubseid_tree;

    }


    /*
     *根据seid生成树状数组
     * $islock = 1 默认，是否激活
     * */
    public function createseidtree($islock = 1)
    {
        $w['islock'] = $islock == 1 ? 1 : array('in','1,0');
        $seids = $this->field('seid')->where($w)->select();
        $seids = getarraycolumn($seids, 'seid');
        asort($seids);//升序排序
        $seid_tree = $this->createtree($seids);

        return $seid_tree;

        /* Array
         (
             [0] => 0
             [1] => Array
         (
             [0] => 1
             [1] => Array
         (
             [0] => 4
                  [1] => Array
                 (
                 )

                 [2] => Array
                 (
                 )

                 [3] => Array
                 (
                 )

                 )

             [2] => Array
          (
                [0] => 5
                    [1] => Array
                 (
                 )

                 [2] => Array
                 (
                 )

                 [3] => Array
                 (
                 )

                 )

             [3] => Array
         (
                [0] => 6
                [1] => Array
                 (
                 )

                 [2] => Array
                 (
                 )

                 [3] => Array
                 (
                 )

            )

         )

             [2] => Array
                 (
                     [0] => 2
                     [1] => Array
                 (
                 )

                 [2] => Array
                 (
                 )

                 [3] => Array
                 (
                 )

                 )

             [3] => Array
                 (
                     [0] => 3
                     [1] => Array
                 (
                 )

                 [2] => Array
                 (
                 )

                 [3] => Array
                 (
                 )

                 )

         )*/

    }



    /*
     *
     * 
     *
     * */


    /*
     * @param seids 有序的ids
     * */
    public function createtree($seids)
    {
        /* $str = "\$v = \$seid_tree['3']['1'];";
           eval($str);*/

        $seid_tree = array(0, array(), array(), array());
        foreach ($seids as $k => $seidval) {

            $indexs = $this->getindexsbyseidvalue($seidval);//获得该seid 的下标
            if ($indexs != null) {
                //数组不为空就执行
                $strind = "[";
                foreach ($indexs as $ind) {
                    $strind = $strind . $ind . "][";
                }
                $strind = substr($strind, 0, strripos($strind, "]") + 1);
                /* $strind 下标的字符串 ，如
                *['1']
                 ['2']
                 ['3']
                 ['1']['1']
                 ['1']['2']
                 ['1']['3']*/

//                $str = "  &\$seid_tree".$strind.";" ;

                $str = "if ( empty(\$seid_tree" . $strind . ")  ){" .
                    " \$seid_tree" . $strind . "[0] = \$seidval;" .
                    "\$seid_tree" . $strind . "[1] = array();" .
                    " \$seid_tree" . $strind . "[2] = array();" .
                    " \$seid_tree" . $strind . "[3] = array();" .
                    "}else if(\$seid_tree" . $strind . " ===null){" .
                    "  \$seid_tree" . $strind . " = array();" .
                    "  \$seid_tree" . $strind . "[0] = \$seidval;" .
                    "  \$seid_tree" . $strind . "[1] = array();" .
                    "  \$seid_tree" . $strind . "[2] = array();" .
                    "  \$seid_tree" . $strind . "[3] = array();" .
                    " };";

                eval($str);


            }

        }

        return $seid_tree;
    }


    /* //通过seid的值求出数组中的下标
          * 算法*******
          * 父亲seid = （seid -1）/3
          * 当前下标  = seid%3 等0是为3 ，等1和2为1和2
          * 递归合并每一项的下标，返回数组
          * */
    public function getindexsbyseidvalue($seidval)
    {

        if (intval($seidval) <= 0) {
            return array();
        }
        $indexs = array();
        $seidval = intval($seidval);
        $ind = $seidval % 3;
        $ind = $ind === 0 ? 3 : $ind;

        $childseidval = floor(($seidval - 1) / 3);
        if ($childseidval <= 0) {
            array_push($indexs, $ind);
            return $indexs;
        } else {
            $indexs = $this->getindexsbyseidvalue($childseidval);
            array_push($indexs, $ind);

            return $indexs;
        }
        /* Array
         (
             [0] => 1
             [1] => 1
             [2] => 1
             [3] => 3
         )*/

    }


    /*
     * 获得代理的类型，返回usertype，1为普通代理，2为银牌，3为金牌
     * @param $adminid
     * return 
     * */
    public function getUserType($adminid)
    {
        return $this->field('usertype')->find($adminid);
    }

    /*
     * 根据adminid 得到 seid
     * @param $adminid
     * return seid
     * */
    public function getseidByAdminid($adminid)
    {
        $seidarr = $this->field('id,seid')->find($adminid);
        /* p($res);
         Array
         (
             [id] => 2
             [seid] => 1
         )*/
        return $seidarr['seid'];
    }


    /*
     * 根据 seid得到 adminid
     * @param seid
     * return $adminid
     * */
    public function getAdminidBySeid($seid)
    {
        $seidarr = $this->field('id,seid')->where('seid = ' . $seid)->find();
        /* p($res);
         Array
         (
             [id] => 2
             [seid] => 1
         )*/
        return $seidarr['id'];
    }


    /*
     * 检测是否是这个月新增的用户
     *
     * */
    public function isThisMonthAddOfSeid($seid)
    {
        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳
        $map['registertime'] = array(array('gt', $datethismonth), array('lt', $datenow));
        $res = $this->where('seid = ' . $seid)->where($map)->find();
        return !(empty($res));
    }


    /*
     * 更新代理身份的函数，
     * 判断是否升级为金银代理
     *
     * */

    public function checkUsertype($adminid)
    {
        if ($adminid != 1){
            $achievement = D('Achievement');
            $order = D('order');
            $countafteryin = $count = 0;
            //$count = $order->where('adminid = ' . $adminid." AND ispass = 1 ")->count();//审核过的订单数量
            $serverids = $achievement->getseveradmins($adminid);//推荐过的人

            $count += count(explode(',', $serverids));//业绩直推数量



            $myachievement = $achievement->getbestachievement($adminid);//自己直推的人的单pv总值，每人只有一张单


            /*
             *
             *
             *   成为代理的条件：消费首单；
             *    成为银牌的条件：（同时满足）
             *    1、单量够10单；
             *    2、消费总pv值3750（人民币5000）；
             *    成为金牌的条件：（同时满足）
             *    1、再新增十单；
             *    2、再新增单总pv值7500（人民币10000）
             */
            $usertyped = $this->field('usertype,yintime')->find($adminid);
            $usertype = intval($usertyped['usertype']);

            if ($usertype == 2 ){
                //银牌的话
                $serveridsafteryin = $achievement->getseveradmins($adminid,$usertyped['yintime']);//推荐过的人
                $countafteryin += count(explode(',', $serveridsafteryin));//业绩直推数量
            }

            if ( (  $countafteryin >= 10 ||  $count >=20 )  && $myachievement >=7500 ) {
                //金牌

                if ($usertype != 3 ) {
                    $w['usertype'] = 3;
                    $w['jintime'] = time();
                    $w['id'] = $adminid;
                    $w['dirsalenum'] = $count;//推荐的人数量
                    $this->save($w);
                }
            }
             else if ($count >= 10 && $myachievement >=3750 ) {
                 //银牌

                 if ($usertype < 2 ) {
                     $w['usertype'] = 2;
                     $w['yintime'] = time();
                     $w['jintime'] = null;
                     $w['id'] = $adminid;
                     $w['dirsalenum'] = $count;//推荐的人数量，
                     $this->save($w);
                 }

             }   else {

                 /*if ($usertype != 1 ) {
                     $w['usertype'] = 1;
                     $w['yintime'] = null;
                     $w['jintime'] = null;
                     $w['id'] = $adminid;
                     $w['dirsalenum'] = $count;//推荐的人数量
                     $this->save($w);
                 }*/
            }
        }

    }





    /*
     *
     * 获得usertypelist，作为选择select使用
     * 单量达到什么样的水平就显示什么样的列表，只能在允许之上
     * @param $adminid
     *
     *
     *
     *
     * */

    public function getUsertypelist($adminid)
    {
        if ($adminid != 1){
            $achievement = D('Achievement');
            $order = D('order');
            $count = 0;
            //$count = $order->where('adminid = ' . $adminid." AND ispass = 1 ")->count();//审核过的订单数量
            $serverids = $achievement->getseveradmins($adminid);//推荐过的人

            $count += count(explode(',', $serverids));//业绩直推数量

            $myachievement = $achievement->getbestachievement($adminid);//自己直推的人的单pv总值，每人只有一张单


            if ($count >= 20 && $myachievement >=11250 ) {
                //金牌
                $usertype = array(
                    '3' => '金牌代理',
                );

            }
            else if ($count >= 10 && $myachievement >=3750 ) {
                //银牌
                $usertype = array(
                    '2' => '银牌代理',
                    '3' => '金牌代理',
                );

            }else {
                //普通用户
                $usertype = array(
                    '1' => '普通代理',
                    '2' => '银牌代理',
                    '3' => '金牌代理',
                );
            }
        }

        return $usertype;

    }
    /*
     * 获得新增的人，晋升金银代理的人seid
     *
     *
     *
     * */

    public function getNewPeople($starttime = '', $endtime = '')
    {
        if ($starttime == '') {
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime == '') {
            $endtime = time();
        }
        /*****新注册的人*****/
        $newpeople = array();
        $map1['registertime'] = array(array('gt', $starttime), array('lt', $endtime));
        $regt = $this->field('id,seid')->where($map1)->where('id <> 1 AND islock = 1 ')->select();
        foreach ($regt as $rk => $rv) {
            $regt[$rk] = $rv['seid'];
        }
        $newpeople['newregt'] = array();
        $newpeople['newregt']['nrnum'] = count($regt);//新注册的人的数量
        $regt = implode(',', $regt);//新注册的人的seid
        $newpeople['newregt']['regt'] = $regt;//


        /*****新晋级银牌的人*****/
        $map2['yintime'] = array(array('gt', $starttime), array('lt', $endtime));
        $yin = $this->field('id,seid')->where($map2)->where('id <> 1 AND islock = 1 ')->select();
//        echo $this->getLastSql();
        foreach ($yin as $yk => $yv) {
            $yin[$yk] = $yv['seid'];
        }
        $newpeople['newyin'] = array();
        $newpeople['newyin']['nynum'] = count($yin);//新注册的人的数量
        $yin = implode(',', $yin);//新注册的人的seid
        $newpeople['newyin']['yin'] = $yin;//


        /*****新晋级金牌的人*****/

        $map3['jintime'] = array(array('gt', $starttime), array('lt', $endtime));
        $jin = $this->field('id,seid')->where($map3)->where('id <> 1 AND islock = 1 ')->select();
        foreach ($jin as $jk => $jv) {
            $jin[$jk] = $jv['seid'];
        }
        $newpeople['newjin'] = array();
        $newpeople['newjin']['njnum'] = count($jin);//新注册的人的数量
        $jin = implode(',', $jin);//新注册的人的seid
        $newpeople['newjin']['jin'] = $jin;//

        return $newpeople;
    }


    public function getNewPeopleOfAllTime($firsttime = "2017-01")
    {
        $firsttime = strtotime($firsttime);//最早的月份的时间戳
        $monnum = 1;
        $datethismonth = date('Y-m', time());
        $datethismonth = strtotime($datethismonth);//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳
        $newpeople = array();
        $newpeople[date('Y-m', time())] = $this->getNewPeople($datethismonth, $datenow);
        while (true) {


            $datemonth = date('Y-m', strtotime("-" . $monnum . " Months", $datethismonth));//从上个月开始的
            $datemonth = strtotime($datemonth);
            $edatemonth = date('Y-m', strtotime("-" . ($monnum - 1) . " Months", $datethismonth));//从上个月开始的
            $edatemonth = strtotime($edatemonth);
            if ($datemonth >= $firsttime) {
                $newpeople[date('Y-m', strtotime("-" . $monnum . " Months", $datethismonth))] = $this->getNewPeople($datemonth, $edatemonth);
            } else {
                break;
            }

            $monnum++;
        }
        return $newpeople;

    }


    /*
     * 获得代理类型
     * @param $seid
     * return usertype
     * */
    public function getUsertypeBySeid($seid)
    {
        $usertype = $this->field('usertype')->where('seid = ' . $seid)->find();
        return intval($usertype['usertype']);
    }


    /*
     * 获得推荐人
     *@param $seid
     * return $pseid
     * */

    public function getParentSeidBySeid($seid)
    {
        $pid = $this->field('pid')->where('seid = ' . $seid)->find();
        $pid = intval($pid['pid']);
        $pseid = $this->getseidByAdminid($pid);
        return intval($pseid);
    }


    /*
     * 获得金牌数，总银牌数，总普通代理
     * return array
     *
     *
     * */

    public function getMenberGroupBytype()
    {
        $usual = $this->field('seid')->where('usertype = 1 AND islock = 1 ')->select();
        $yin = $this->field('seid')->where('usertype = 2  AND islock = 1 ')->select();
        $jin = $this->field('seid')->where('usertype = 3  AND islock = 1 ')->select();
        foreach ($usual as $uk => $u) {
            $usual[$uk] = $u['seid'];
        }
        foreach ($yin as $yk => $y) {
            $yin[$yk] = $y['seid'];
        }
        foreach ($jin as $jk => $j) {
            $jin[$jk] = $j['seid'];
        }

        $m_account['usual'] = $usual;
        $m_account['yin'] = $yin;
        $m_account['jin'] = $jin;
        $m_account['count'] = count($usual) + count($yin) + count($jin);

        return $m_account;
    }


    /*
     * 获得个人的直推人和自己的订单
     * $adminid
     *
     * */

    public function getServeridsAndOrder($adminid)
    {
        $sao = array();
        $serverids = D('Achievement')->getseveradmins($adminid, '', '', 2);
        $sao['serverids'] = $serverids;

        $sao['sidnum'] = $serverids === '' ? 0 : count(explode(',', $serverids));//推荐的人数量
        $sao['ordernum'] = D('order')->where('adminid = ' . $adminid . " AND ispass = 1 ")->count();//自己的订单数，只能是1
        $seid = $this->getseidByAdminid($adminid);
        $pseid = $this->getParentSeidBySeid($seid);
        $sao['pseid'] = $pseid == 0 ? '公司管理员' : $pseid;//推荐自己的人
        return $sao;
    }











    /*
     * 获得个人的直推人和自己的订单 某个时间段的情况
     * $adminid
     *
     * */

    public function getServeridsAndOrderOfTime($adminid,$starttime = '', $endtime = '')
    {

        if ($starttime==''){
            $starttime = strtotime('1970-01-02');
        }
        if ($endtime==''){
            $endtime = time();
        }


        $saooftime = array();
        $serverids = D('Achievement')->getseveradmins($adminid, $starttime, $endtime, 2);
        $saooftime['serverids'] = $serverids == '' ? '无' : $serverids ;

        $saooftime['sidnum'] = $serverids === '' ? 0 : count(explode(',', $serverids));//推荐的人数量
        $saooftime['ordernum'] = D('order')->
                                where("adminid = " . $adminid . " AND ispass = 1 AND otime < ".$endtime." AND  otime > ".$starttime )->
                                count();//自己的订单数，只能是1,时间不在的话可以为0

        /*$seid = $this->getseidByAdminid($adminid);
        $pseid = $this->getParentSeidBySeid($seid);
        $saooftime['pseid'] = $pseid == 0 ? '公司管理员' : $pseid;//推荐自己的人*/

        return $saooftime;
    }



    /*
     * 获得个人的直推人和自己的订单 某个时间段的情况
     * $adminid
     * $firsttime 默认的最早的时间
     * */

    public function getServeridsAndOrderOfMonth($adminid,$firsttime = "2017-01")
    {
        $saoofMonth = array();
        $firsttime = strtotime($firsttime);//最早的月份的时间戳
        $monnum = 1;//计算月份的计数器
        $datethismonth =  date('Y-m',time());
        $datethismonth =  strtotime($datethismonth)   ;//这个月1号的时间戳
//            echo $datethismonth;
        $datenow = time();//现在的时间戳

        $saoofMonth[date('Y-m',time())] = $this->getServeridsAndOrderOfTime($adminid,$datethismonth,$datenow);//这个月的直推人

        while (true){


            $datemonth =  date('Y-m',strtotime("-".$monnum." Months",$datethismonth));//从上个月开始的
            // p(date('Y-m-d h:i:s',strtotime("-".$monnum." Months")));
            $datemonth =  strtotime($datemonth);
            $edatemonth =  date('Y-m',strtotime("-".($monnum-1)." Months",$datethismonth));//从上个月开始的
            $edatemonth =  strtotime($edatemonth);
            if ($datemonth>=$firsttime){
                $saoofMonth[date('Y-m',strtotime("-".$monnum." Months",$datethismonth))] = $this->getServeridsAndOrderOfTime($adminid,$datemonth,$edatemonth);
            }else{
                break;
            }

            $monnum++;
        }


        


        return $saoofMonth;
    }


    /*
     * 过滤超过6层的孩子，间推没有提成
     * 一、工牌激活：（复消包括自己消费或者直推别人）
     *   1——100            （首单）
     *   101——300          （复消1单）
     *   301——600        	（复消2单）
     *   601——1092			（复消3单）
     *   1单就激活1-100工牌，再复消1单就激活101-300，再复消2单激活301-600，再复消3单激活601-1092；激活工牌的作用就是可以拿到间推的提成7%；
     *
     *
     * @param $seid 顶级的seid
     * @$childrenids 所有子孙的adminid
     * return $newchildrenids 过滤后的adminid
     * */

    public function filterChildren($seid, $childrenids)
    {
        $newchildrenids = array();
        $rank = $this->getRankBySeid($seid);//间推的分红的等级

        foreach ($childrenids as $k => $cid) {
            $cseid = $this->getseidByAdminid($cid);//获得seid
            if (intval($cseid) <= getTheSixthBiggestSeid($seid,$rank)) {
                array_push($newchildrenids, $cid);
            }
        }

        return $newchildrenids;
    }


    /*
     *
     * 获得间接提成的等级
     *   1——100            （首单）    => $rank = 1
     *   101——300          （复消1单） => $rank = 2
     *   301——600        	（复消2单）=> $rank = 3
     *   601——1092			（复消3单）=> $rank = 4
     *
     *
     * */
    public function getRankBySeid($seid){
        $ordermodel = D('order');
        $achievement = D('Achievement');
        $adminid = $this->getAdminidBySeid($seid);
        $rank = 1;
       if ($ordermodel->ishaveorder($adminid,1)) {
           $rank = 1 ;
       }

        $serverids = $achievement->getseveradmins($adminid);//推荐过的人
        if ($serverids == ''){
            $serveridnum = 0;
        }else{
            $serveridnum = count(explode(',',$serverids ));//推荐过的人数，有订单并且审核过的
        }

        //var_dump($serveridnum);
         switch ($serveridnum){
             case 0 :{

                 break;
             }
             case 1 : {
                 $rank = 2 ;
                 break;
             }
             case 2 : {
                 $rank = 3 ;
                 break;
             }
             case 3 : {
                 $rank = 4 ;
                 break;
             }
             default :{
                 $rank=4;
             }
         }

        return $rank;


    }


    /*
     * 获得数的子孙数量
     * $json_arr 树，已经转换成json格式的数
     * */
    public function getChildrenNum($json_arr, &$childrennum = 0)
    {

        foreach ($json_arr['children'] as $c) {
            if ($c['name'] !== ' ') {
//                var_dump($c['name']);
                $childrennum++;
                $this->getChildrenNum($c, $childrennum);
            }
        }
        return $childrennum;
    }


    /*
     * 判断身份证是否超过6张，最多六个同样的工号
     * $idcard 身份证号码
     * @return Boolean
     * */
    public function isIdcardInnerSix($idcard)
    {
        $idcardnum = $this->where("idcard = '$idcard'  ")->count();
        //echo $this->getLastSql();
        //echo  $idcardnum;
        if ($idcardnum >= 6) {
            return false;
        } else {
            return true;
        }
    }


    /*
     * 获得推荐自己的人 的adminid
     * */
    public  function getpid($adminid){
       $pid = $this->field('pid')->find($adminid);
        $pid = $pid['pid'];
        return $pid;
    }


    /*
     *
     * 获得得到自己间接奖金的人adminid，就是获得tree里面的6位祖先adminid
     * */
    public function getTreeSixPid($adminid){
        $treepadminid = array();
        $seid = $this->getseidByAdminid($adminid);//当前的seid

        for ( $i = 0 ; $i < 6 ; $i++) {
            $tpseid = $this->getTreepid($seid);//各级父亲的seid
            if ($tpseid == 0 ){
                //已经到了顶层
                break;//退出循环
            }
            array_push($treepadminid, $this->getAdminidBySeid($tpseid));//转换成adminid，放进treepid
            $seid = $tpseid;
        }

        return $treepadminid;
    }


    /*
     *
     * 获得tree里面的父亲
     * @param $seid
     * */
    public function getTreepid($seid){

        $tpid = floor((floatval($seid)-1)/3);

        return $tpid;

    }




    /*
     * 获得银牌的数量
     *
     * */
    public function getYinNum($starttime='',$endtime=''){
        if ($starttime == ''){
            $datethismontht = date('Y-m', time());
            $datethismonth = strtotime($datethismontht);//这个月1号的时间戳
            $starttime = $datethismonth;
        }

        if ($endtime == ''){
            $endtime = time();
        }
        $w['usertype'] = array('egt',2);
        $w['islock'] = 1  ;
        $w['yintime'] = array('elt',$endtime)  ;

        /*jintime 为空就不搜，不为空 ，jintime > endtime */

        /*$w2['jintime'] = array('exp',' is null ')  ;//要么为空，要么>$endtime
        $w2['jintime'] = array('gt',$endtime)  ;
        $w2['_logic'] = 'or';*/

        $w['_string'] = ' `jintime` IS NULL  OR  `jintime` >=  '.$endtime;

//        $w['_complex'] = $w2;
        return $this->where($w)->count();
    }


    /*
     * 获得金牌的数量
     *
     * */
    public function getJinNum($starttime='',$endtime=''){
        if ($starttime == ''){
            $datethismontht = date('Y-m', time());
            $datethismonth = strtotime($datethismontht);//这个月1号的时间戳
            $starttime = $datethismonth;
        }

        if ($endtime == ''){
            $endtime = time();
        }
        $w['usertype'] = 3;
        $w['islock'] = 1  ;
        $w['jintime'] = array('elt',$endtime)  ;
        return $this->where($w)->count();
    }

    /*
     * 获得银牌的adminid
     *
     * */
    public function getYinAdminids(){
        $yinadminis = $this->field('id')->where('usertype = 2 AND islock = 1 ')->select();//所有银牌的Adminid


        foreach ($yinadminis as $yak => $yav ){
            $yinadminis[$yak] = $yav['id'];
        }

        return $yinadminis;
    }


    /*
     * 获得金牌的adminid
     *
     * */
    public function getJinAdminids(){
        $jinadminids = $this->field('id')->where('usertype = 3 AND islock = 1 ')->select();

        foreach ($jinadminids as $jak => $jav ){
            $jinadminids[$jak] = $jav['id'];
        }

        return $jinadminids;
    }







    
    
    /*
     * 获得注册时间戳
     * @param $adminid 
     * 
     * */
    public function getRegistertime($adminid){
        $a = $this->field('registertime')->find($adminid);
        return $a['registertime'];//时间戳
    }







    /*
     *
     *
     *@param $f=1 默认为1，1代表要过滤，0就显示所有adminid,1是显示有激活的用户islock = 1
     *
     *
     */
    public function getadminids($f = 1){
        $adminids = array();
        if ($f == 1){
            $w['islock'] = 1;
            $w['id'] = array('neq',1);
            $ra = $this->field('id')->where($w)->select();

            foreach ($ra as $rav){
                $adminids =  array_merge_recursive($adminids, $rav);
            }
        }
//        p($adminids);
       return implode(',',$adminids['id'] );

    }


    /*
     *
     * 判断是否已经激活，
     * islock 为1就激活，0就没有激活
     * @param $adminid
     * */
     public function isislock($adminid){
         $islock = $this->field('islock')->find($adminid);
         if (!empty($islock)){
             $islock = $islock['islock'];
             return $islock == 1 ? true : false;
         }
         return false;
     }


    /*
     *
     * 判断usertype,判断时段里面admin是否升级,返回时间段里面的usertype,没有激活返回FALSE
     * @param $adminid
     * @param $starttime
     * @param $endtime
     *
     *
     */
    public function usertypeofrighttime($adminid,$starttime,$endtime){
        $usertype = 1;
        $usertypetime = $this->field('registertime,yintime,jintime,usertype,islock')->find($adminid);//usertype 的时间数组
        if ($usertypetime['islock'] != 1){
            //没有激活，直接false
            return false;
        }else{
            switch ($usertypetime['usertype']){
                case 1 : {
                    //从来没有胜过级，直接等于1
                    $usertype = 1;
                    break;
                }
                case 2 : {
                    //判断升级银牌的时间
                    if ($usertypetime['yintime'] < $endtime ){
                        $usertype = 2;
                    }else{
                        $usertype = 1;
                    }
                    break;

                }
                case 3 :{
                    //判断升级银牌金牌时间
                    if ($usertypetime['yintime'] < $endtime ){
                        $usertype = 2;
                        if ($usertypetime['jintime'] < $endtime ){
                            $usertype = 3;
                        }else{
                            $usertype = 2;
                        }
                    }else{
                        $usertype = 1;
                    }

                    break;
                }
                default :{
                    $usertype = 1;
                    break;
                }

            }


            return $usertype;
        }


    }





}