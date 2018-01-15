<?php
/**
 * Created by PhpStorm.
 * User: lili
 * Date: 2016/11/1
 * Time: 14:17
 */

namespace Wanyu\Controller;


use Think\Controller;

class LoginController extends  Controller
{
     public  function index(){
//         var_dump($_SESSION['mysqltime']) ;
         $this->display();

     }


    //登录验证
    public function login() {

         if (!IS_POST) {
            E('页面不存在');
        }

        $username = I('username', '', 'htmlspecialchars,trim');
        $password = I('password', '');
        $verify = I('code', '', 'htmlspecialchars,trim');

        if (!check_verify($verify, 'a_login_1')) {
            $this->error('验证码不正确');
        }

        if ($username == '' || $password == '') {
            $this->error('账号或密码不能为空');
        }

        $user = M('admin')->where(array('username' => $username))->find();

        if (!$user || ($user['password'] != get_password($password, $user['encrypt']))) {
            $this->error('账号或密码错误');
        }

        if (!$user['islock']&& $user['usertype']!=9 ) {
            $this->error('代理没有激活！');
        }

        //更新数据库的参数
        $data = array('id' => $user['id'], //保存时会自动为此ID的更新
            'logintime' => time(),
            'loginip' => get_client_ip(),
            'loginaddress' => GetIpLookup(get_client_ip()),
        );
       // echo json_encode($data);

        //更新数据库
        D('Admin')->save($data);
        $admin = D('Admin')->field('password,encrypt', true)->find($user['id']);
        session('usertype',$admin['usertype']);
         // $user['roleid'] = M('roleUser')->where(array('user_id' => $user['id']))->getField('role_id');
       // $user['roleid'] = empty($user['roleid']) ? 0 : $user['roleid'];

        //保存Session
        session(C('USER_AUTH_KEY'), $user['id']);
        session('adminid', $user['id']);
        session('wy_username', $user['username']);
//        session('wy_roleid', intval($user['roleid']));
        session('wy_logintime', date('Y-m-d H:i:s l', $data['logintime']));
        session('wy_loginip', $user['loginip']);
        session('wy_companyname', '分销系统');
        session('toexaminepass', false);//判断是不是有审核身份
        //超级管理员
        if (9 == $user['usertype']) {
            session(C('ADMIN_AUTH_KEY'), true);//判断是不是 9 ，9为超级管理员
        }

//        \Org\Util\Rbac::saveAccessList(); //静态方法，读取权限放到session
        if(session(C('ADMIN_AUTH_KEY'))){
            $this->success('登录成功', U('Index/companyindex'));
        }else{
            $this->success('登录成功', U('Index/index'));
        }
        //跳转


    }

    //退出
    public function logout() {

        session_unset();
        session_destroy();
        $this->redirect('Login/index');
    }

    //登录验证码
    public function verify($id = '1') {

        //ob_clean();
        $config = array(
            'fontSize' => 25,
            'length' => 4,
            'imageW' => 220,
            'imageH' => 50,
            'bg' => array(206, 233, 246),
            'useCurve' => false,
            'useNoise' => false,
        );
        $verify = new \Think\Verify($config);
        $verify->codeSet = '0123456789';
        $verify->entry($id);
    }

    //js 用户名
    public function checkusername() {
        $username = I('username', '', 'htmlspecialchars,trim');
        $id = I('id', 0, 'intval');
        if (empty($username)) {
            exit(0);
        }
        $user = M('admin')->where(array('username' => $username, 'id' => array('neq', $id)))->find();
        if ($user) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /*
     * 登录审核员
     *
     *
     * */

    public function examinepasslogin(){
        $toexaminepass = I('toexaminepass', '', 'htmlspecialchars,trim');
        $adminmodel = D('admin');
        if (  session(C('ADMIN_AUTH_KEY'))  ){
            // 登录审核员
            $adminmsg = $adminmodel->field('encrypt,toexaminepass')->find(session(C('USER_AUTH_KEY')));
            $encrypt = $adminmsg['encrypt'];
//            p($encrypt);
            $toexaminepass = get_password($toexaminepass,$encrypt);//获得加密到的审核密码
            if($adminmsg['toexaminepass'] == $toexaminepass ){
                 //登录成功
                session('toexaminepass', true);//是有审核身份,设置session
                $this->success("审核身份验证成功！");
            }else{
                $this->error("审核密码错误");
            }


        }else{
            $this->error("不是公司管理员，不可以登录审核员");
        }
//        
    }


    /*
     * 退出审核员
     *
     *
     * */

    public function examinepassloginout(){
        session('toexaminepass', false);
        $this->success("退出审核员身份！");
    }








    /*
     *
     *
     * 忘记密码，进入忘记页面的页面
     *
     * */
    public function forget(){
        $this->assign('title','找回密码');
        $this->display();
    }



    /*
     *
     *
     * 忘记密码，处理页面
     *
     *
     * */

    public function doforget(){
        $adminmodel = D("admin");
        $username = I('username', '', 'htmlspecialchars,trim');
        $idcard = I('idcard', '', 'htmlspecialchars,trim');
        $email = I('email', '', 'htmlspecialchars,trim');
        $code = I('code', '', 'htmlspecialchars,trim');
        if (!check_verify($code, 'a_login_1')) {
            $this->error('验证码不正确');
        }

        if ($username == '' || $idcard == ''|| $email == '') {
            $this->error('工号或身份证或邮箱不能为空');
        }
//        p($send);
        $w['username'] = $username;
        $w['islock'] = 1;
        $user = $adminmodel->field('seid,idcard,email,realname')->where($w)->find();//搜出信息
        if (empty($user)){
            $this->error('工号不存在');
        }

        if ($idcard != $user['idcard']){
            $this->error('身份证不正确');
        }

        if ($email != $user['email']){
            $this->error('邮箱不正确');
        }
        $newpassw = get_randomstr(6);//获得新密码
        $newpassw_md5 = get_password($newpassw);//加密的密码
        $data['id'] = $adminmodel->getAdminidBySeid($username);
        $data['password'] = $newpassw_md5['password'];
        $data['encrypt'] = $newpassw_md5['encrypt'];
//        p($data['password']);
        if ($adminmodel->save($data) !== false){
            //修改密码，然后发送密码
            think_send_mail($user["email"],$user["realname"],'新生成的新密码' ,"你的新的随机密码是  ".$newpassw." ,  如要修改密码，请登录后再自行修改。");
            $this->success('新生成的随机新密码已经发送到你的邮箱里面，请登录你的邮箱查看，如要修改密码，请登录后再自行修改。','index',20);
        }else{
            $this->error('发送邮箱失败');

        }







    }

/*
    public  function test(){
        //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
        vendor('PHPMailer.class#phpmailer');
        vendor('PHPMailer.class#smtp');
//示例化PHPMailer核心类
        $mail = new \PHPMailer();

//是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 1;

//使用smtp鉴权方式发送邮件，当然你可以选择pop方式 sendmail方式等 本文不做详解
//可以参考http://phpmailer.github.io/PHPMailer/当中的详细介绍
        $mail->isSMTP();
//smtp需要鉴权 这个必须是true
        $mail->SMTPAuth=true;
//链接qq域名邮箱的服务器地址
        $mail->Host = 'smtp.qq.com';
//设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
//设置ssl连接smtp服务器的远程服务器端口号 可选465或587
        $mail->Port = 465;
//设置smtp的helo消息头 这个可有可无 内容任意
        $mail->Helo = 'Hello smtp.qq.com Server';
//设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        $mail->Hostname = 'localhost';
//设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';
//设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = 'lili在线';
//smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username ='2738805199';
//smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
        $mail->Password = 'yrtrcswhzdcrdebb';
//设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = '2738805199@qq.com';
//邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);
//设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        $mail->addAddress('1273640670@qq.com','lili在线用户');
//添加多个收件人 则多次调用方法即可
//        $mail->addAddress('xxx@163.com','晶晶在线用户');
//添加该邮件的主题
        $mail->Subject = 'PHPMailer发送邮件的示例';
//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = "这是一个<b style=\"color:red;\">PHPMailer</b>发送邮件的一个测试用例";
//为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
//        $mail->addAttachment('./d.jpg','mm.jpg');
//同样该方法可以多次调用 上传多个附件
//        $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');


//发送命令 返回布尔值
//PS：经过测试，要是收件人不存在，若不出现错误依然返回true 也就是说在发送之前 自己需要些方法实现检测该邮箱是否真实有效
        $status = $mail->send();

//简单的判断与提示信息
        if($status) {
            echo '发送邮件成功';
        }else{
            echo '发送邮件失败，错误信息未：'.$mail->ErrorInfo;
        }
    }

*/












    public function test2(){
        think_send_mail('1273640670@qq.com','lili在线用户','PHPMailer发送邮件的示例2' ,"福建省老地方就是打开链接");
    }

























}