<?php
/**
 * Created by PhpStorm.
 * User: lili 来自 万域网络技术团队
 * Date: 2017/3/31
 * Time: 10:45
 * PowerBy 万域网络技术团队
 */

namespace Wanyu\Controller;


class RisingsettingController extends CommonController
{


    /*
         * 前置操作，用来做导航active，显示当前导航
         * */
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('active', 8);
    }


    /*
     * 进入设置页面
     * 十一、右上角显示单量，上升率自己手动调节；然后按时间自动上升；股值，这个是固定的，手动填写
     *
     * */
    public function index()
    {
        $this->assign('title', '上升单量设置');
        $risingsetting = D('Risingsetting')->find();
        $this->assign('risingsetting', $risingsetting);
//        p($risingsetting);
       // echo date("Y-m-d h:i:s",'1483200000');

       /*  for ($i =0;$i<100;$i++){
            $data = array();
            $datethismonth = strtotime("+ $i months" ,'1483200000');//这个月1号的时间戳
            $data['month'] = $datethismonth;
            $data['monthid'] = $i+1;
            D('month')->save($data);
        }*/
        $this->display();

    }




    /*修改累计单数*/
    public function edit()
    {

        $send = I();
        $risingsettingmodel = D('Risingsetting');
        if ($send['startnum'] === '') {
            //没有填的，从目前单数开始
        } else {
            $send['nownum'] = $send['startnum'];
        }


        if ($risingsettingmodel->create($send)) {
            $res = $risingsettingmodel->save($send);
            if ($res !== false) {
                $this->success('修改成功！');
            } else {
                $this->error('修改失败');
            }

        } else {
            $this->getError();
        }
    }


    public function refresh()
    {
        $send = I();
        $risingsettingmodel = D('Risingsetting');
        $rules = array(
            array('nownum', 'require', '验证码必须！'),
        );

        if ($risingsettingmodel->validate($rules)->create($send)) {
            $res = $risingsettingmodel->save($send);
            if ($res !== false) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }


    /*
     * 业绩报表 页面
     *
     *
     *
     * */

    public function jqgrid()
    {
        $this->assign('title', '业绩报表');
        $this->display();


    }


    /*
     *
     * jqgrid的数据
     * 主页
     *
     * */

    public function jqGridjson()
    {




        $adminmodel = D('Admin');
        $achievementmodel = D('achievement');
        $risingsettingmodel = D('risingsetting');
        $settlementmsg = D('settlementmsg');
        $monthmodel  = D('month');

        //分页
        $page = $_GET['page']; // 第几页
        $limit = $_GET['rows']; // 一页的数量
        $sidx = $_GET['sidx']; // 排序字段
        $sord = $_GET['sord']; // 顺序或者倒序
        if (!$sidx) $sidx = 1;
        $adminids = $adminmodel->getadminids();// 所有代理id
        $adminids = explode(',',$adminids );
//        p($adminids);




        //搜索
        $_search = trim($_GET['_search']) == 'false' ? false : true;
        $searchField = trim($_GET['searchField']);//搜索字段
        $searchString = trim($_GET['searchString']);//搜索信息
        $searchOper = trim($_GET['searchOper']);//搜索方式
       /* searchField:shares
        searchString:5
        searchOper:eq*/

        $records = count($adminids);//代理总数
        $startnum = ($page - 1) * $limit;//开始的数量
        $totalpage = ceil($records / $limit);//总页数


        $jsonarr = array(
            "page" => $page,
            "total" => $totalpage,
            "records" => $records,
            'rows' => array()
        );

        $datethismonth = date('Y-m', time());
        $datethismontht = strtotime($datethismonth);//这个月1号的时间戳
        $nowmonthid = $monthmodel->getMonthidByTime($datethismontht);


        /**********现在是直接读取数据表的数据******/
//        D('month')->refreshmonth();
        if ($_search){
            //有搜索的条件

            $where = $settlementmsg->getsearwherearr($searchField,$searchString,$searchOper);
            $where['islock'] = 1;
            $where['_string'] =  'wywl_month.monthid = '.$nowmonthid;
            $datas = $settlementmsg->limit($startnum,$limit)
                ->join('LEFT JOIN wywl_month ON wywl_settlementmsg.monthid = wywl_month.monthid ')
                ->join('LEFT JOIN wywl_admin ON wywl_settlementmsg.adminid = wywl_admin.id ')
                ->where($where)
                ->order(" $sidx $sord ")
                ->select();//合适的分页数据

        }else{
            //没有搜索的条件
            $where['islock'] = 1;
//            $where['_string'] =  'wywl_month.monthid = '.$nowmonthid;
            $subQuery = $settlementmsg
//                ->join('LEFT JOIN wywl_month ON wywl_settlementmsg.monthid = wywl_month.monthid ')
//                ->join('LEFT JOIN wywl_admin ON wywl_settlementmsg.adminid = wywl_admin.id ')
//                ->group('wywl_settlementmsg.adminid')

//                ->having('wywl_month.monthid = max(wywl_month.monthid) ' )/*max(wywl_settlementmsg.monthid)*/

//                ->order(" $sidx $sord ")
                ->order(" wywl_settlementmsg.monthid desc ")
                ->buildSql();//合适的分页数据
            $datas = $settlementmsg->table($subQuery.' a')
                ->limit($startnum,$limit)
                ->join('LEFT JOIN wywl_month ON a.monthid = wywl_month.monthid ')
                ->join('LEFT JOIN wywl_admin ON a.adminid = wywl_admin.id ')
                ->where($where)
                ->group('adminid')
                ->order(" $sidx $sord ")
                ->select();
        }

//        var_dump($settlementmsg->getLastSql());
        $rows = array();//
        foreach ($datas as $dv){
            $row = array();//记录每一行的信息
            $row['id'] = $dv['seid'];
            $row['cell'] = array(
                $dv['seid'],
                $dv['monthstr'],
                $dv['dirbonkus'],
//                $dv['encbonus'],
                $dv['indirbonkus'],
                $dv['averagebonus'],
                $dv['pvtotal'],
                $dv['truebonus'],
                $dv['alreadysettlemoney'],
                $dv['leftsettlemoney'],
                $dv['biyudou'],
                $dv['issettlement'],

            );
            array_push($rows, $row);
        }

        $jsonarr['rows'] = $rows;

        /**********现在是直接读取数据表的数据******/




        /*******  这里是直接计算的现在换成直接读取表里面的数据***********/
       /* ******************************************************************
        $index = 1;//计数
       foreach ($adminids as $ak => $av) {
//            $adminids[$ak] = $av['id'];
            if (($_search&&$risingsettingmodel->isrowsearch($av,$searchField,$searchString,$searchOper)) || (!$_search) ){

                //如果search 为 false ，全部遍历，如果是true，符合条件才遍历

                if ($index >= $startnum && $index <= $startnum + $limit) {
                    $row = array();//记录每一行的信息
                    //遍历所有的

                    $encbonus = $achievementmodel->getencbonus($av, $datethismontht, time());//Array ( [encbonus] => 28.71 ) 激励奖金
                    $dirbonkus = $achievementmodel->getdirbonkus($av, $datethismontht, time());//直接开拓奖金
                    $indirbonkus = $achievementmodel->getindirbonus($av, $datethismontht, time());//间接开拓奖金
                    $averagebonus = $achievementmodel->getAverageBonus($av, $datethismontht, time());

                    $row['id'] = $adminmodel->getseidByAdminid($av);//seid
                    $issettle = $settlementmsg->issettle($av,$datethismontht);
                    $alreadysettlemoney = $settlementmsg->getAlreadySettleMoney($av,$datethismontht);//已经结算提现的钱
//                    $alreadysettlemoney = floatval(trim($alreadysettlemoney));
                    $row['cell'] = array(
                        $row['id'],
                        $datethismonth,
                        $dirbonkus,
                        $encbonus,
                        $indirbonkus,
                        $averagebonus,
                        $dirbonkus + $encbonus + $indirbonkus+$averagebonus,//总pv
                        ($dirbonkus + $encbonus + $indirbonkus+$averagebonus)*0.80,
                        $alreadysettlemoney,//已提现金额
                        ($dirbonkus + $encbonus + $indirbonkus+$averagebonus)*0.80-$alreadysettlemoney,//可提金额
                        ($dirbonkus + $encbonus + $indirbonkus+$averagebonus)*0.20,//碧玉豆
                        $issettle//是否结算
                    );
                    array_push($jsonarr['rows'], $row);
                }

                $index++;
            }



        }
       //排序
//        $jsonarr = $risingsettingmodel->rowsort($jsonarr, $sidx, $sord);
       ******************************************************************************/












        $jsonstr = json_encode($jsonarr);
        echo $jsonstr;


    }


    /*
     * 字表单的显示
     *
     * */
    public function jqSubGridjson()
    {
        $send = I();
//        print_r($send);
        /*Array
        (
                [q] => 2
                [id] => 16
                [_search] => false
                [nd] => 1491401722157
                [rows] => 20
                [page] => 1
                [sidx] => num
                [sord] => asc
        )*/

        $adminmodel = D('Admin');
        $achievementmodel = D('achievement');
        $risingsettingmodel = D('risingsetting');
        $settlementmsg = D('settlementmsg');
        $monthmodel  = D('month');
        //分页
        $page = $_GET['page']; // 第几页
        $limit = $_GET['rows']; // 一页的数量
        $sidx = $_GET['sidx']; // 排序字段
        $sord = $_GET['sord']; // 顺序或者倒序
        $seid = $send['id'];
        $adminid = $adminmodel->getAdminidBySeid($seid);
        if (!$sidx) $sidx = 1;

        //搜索
        $_search = trim($_GET['_search']) == 'false' ? false : true;
        $searchField = trim($_GET['searchField']);//搜索字段
        $searchString = trim($_GET['searchString']);//搜索信息
        $searchOper = trim($_GET['searchOper']);//搜索方式

        



        //所有月份的业绩,键是月份
//        $allMonthperformance = $achievementmodel->getachievementmsgofallmonth($adminid);
        $w['adminid'] = $adminid;
        $allMonthperformance = $settlementmsg->where($w)->select();//所有数据
        $records = count($allMonthperformance);//代理总数
        $startnum = ($page - 1) * $limit;//开始的数量
        $totalpage = ceil($records / $limit);//总页数


        $jsonarr = array(
            "page" => $page,
            "total" => $totalpage,
            "records" => $records,
            'rows' => array()
        );


        $datethismonth = date('Y-m', time());
        $datethismontht = strtotime($datethismonth);//这个月1号的时间戳
//        $nowmonthid = $monthmodel->getMonthidByTime($datethismontht);


        /**********现在是直接读取数据表的数据******/
//        D('month')->refreshmonth();
        if ($_search){
            //有搜索的条件

            $where = $settlementmsg->getsearwherearr($searchField,$searchString,$searchOper);
            $where['islock'] = 1;
            $where['adminid'] = $adminid;
            $datas = $settlementmsg->limit($startnum,$limit)
                ->join('LEFT JOIN wywl_month ON wywl_settlementmsg.monthid = wywl_month.monthid ')
                ->join('LEFT JOIN wywl_admin ON wywl_settlementmsg.adminid = wywl_admin.id ')
                ->where($where)
                ->order(" $sidx $sord ")
                ->select();//合适的分页数据

        }else{
            //没有搜索的条件
            $where['islock'] = 1;
            $where['adminid'] = $adminid;
            $datas = $settlementmsg->limit($startnum,$limit)
                ->join('LEFT JOIN wywl_month ON wywl_settlementmsg.monthid = wywl_month.monthid ')
                ->join('LEFT JOIN wywl_admin ON wywl_settlementmsg.adminid = wywl_admin.id ')
                ->where($where)
                ->order(" $sidx $sord ")
                ->select();//合适的分页数据
        }

//        var_dump($settlementmsg->getLastSql());
        $rows = array();//
        foreach ($datas as $dk => $dv){
            $row = array();//记录每一行的信息
            $row['id'] = $dk+1;//行数
            $row['cell'] = array(
                $dv['seid'],
                $dv['monthstr'],
                $dv['dirbonkus'],
//                $dv['encbonus'],
                $dv['indirbonkus'],
                $dv['averagebonus'],
                $dv['pvtotal'],
                $dv['truebonus'],
                $dv['alreadysettlemoney'],
                $dv['leftsettlemoney'],
                $dv['biyudou'],
                $dv['issettlement'],

            );
            array_push($rows, $row);
        }

        $jsonarr['rows'] = $rows;

        /**********现在是直接读取数据表的数据******/





       /*****************************************************************
         $index=1;
        //键是月份，值是三金
        foreach ($allMonthperformance as $apfk => $apfv){
            $issettle = $settlementmsg->issettle($adminid, strtotime($apfk));//是否结算
            $alreadysettlemoney = $settlementmsg->getAlreadySettleMoney($adminid, strtotime($apfk));//已经结算提现的钱
            $alreadysettlemoney = floatval($alreadysettlemoney);
            if (($_search&&$risingsettingmodel->issubrowsearch($apfk,$apfv,$searchField,$searchString,$searchOper,$issettle)) || (!$_search) ) {

                if ($index >= $startnum && $index <= $startnum + $limit) {
                    $row = array();
                    $row['id'] = $index;//行id
                    $issettle = $settlementmsg->issettle($adminid, strtotime($apfk));
                    $row['cell'] = array(
                        $seid,
                        $apfk,
                        $apfv['dirbonkus'],
                        $apfv['encbonus'],
                        $apfv['indirbonkus'],
                        $apfv['averagebonus'],
                        $apfv['dirbonkus'] + $apfv['encbonus'] + $apfv['indirbonkus']+$apfv['averagebonus'],
                        ($apfv['dirbonkus'] + $apfv['encbonus'] + $apfv['indirbonkus']+$apfv['averagebonus'])*0.80,//实际奖金
                        $alreadysettlemoney,//已提现金额
                        ($apfv['dirbonkus'] + $apfv['encbonus'] + $apfv['indirbonkus']+$apfv['averagebonus'])*0.80-$alreadysettlemoney,//可提金额，
                        ($apfv['dirbonkus'] + $apfv['encbonus'] + $apfv['indirbonkus']+$apfv['averagebonus'])*0.20,//碧玉豆
                        $issettle//是否结算
                    );
                    array_push($jsonarr['rows'], $row);
                }

                $index++;

            }
        }


        $jsonarr = $risingsettingmodel->rowsort($jsonarr, $sidx, $sord);
        *************************************************************************/





        $jsonstr = json_encode($jsonarr);
        echo $jsonstr;

    }





    /*
     * 结算交替操作
     *
     * */
    
    public function settletoggle(){
        $send = I();
        $settlementmodel = D('settlementmsg');
        $adminmodel = D('admin');
        $adminid =$adminmodel->getAdminidBySeid($send['seid']);
        $monthtime = $send['monthtime'];
        $issettle = $send['issettle'];
        echo $settlementmodel->setsettle($adminid,$monthtime,$issettle);
    }



    /*
     * 编辑报表的数据
     *
     * */
    public function settleEdit(){
        $send = I();
//        $send['monthtime'] = date('Y-m-d',$send['monthtime']);
        /*Array
        (
            [alreadysettlemoney] => 542
            [oper] => edit
            [id] => 4
            [seid] => 4
            [monthtime] => 1490976000
        )*/
//        print_r($send);

        $settlementmodel = D('settlementmsg');
        $adminmodel = D('admin');
        $adminid =$adminmodel->getAdminidBySeid($send['seid']);
        $monthtime = $send['monthtime'];
        
        $alreadysettlemoney = $send['alreadysettlemoney'];//要修改的值，已结算的钱
        echo $settlementmodel->setAlreadySettleMoney($adminid,$monthtime,$alreadysettlemoney);

    }


    







}