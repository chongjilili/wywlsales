<?php

/**
 * 返回节点权限列表(多维数组)
 * @param array $node 节点数据数组
 * @param array $access 权限数据数组
 * @param integer $pid 父级id
 * @return array
 */
function node2layer($node, $access = null, $pid = 0)
{

    if ($node == '') return array();
    $arr = array();

    foreach ($node as $v) {
        if (is_array($access)) {
            $v['access'] = in_array($v['id'], $access) ? 1 : 0;
        }
        if ($v['pid'] == $pid) {
            $v['child'] = node2layer($node, $access, $v['id']);
            $arr[] = $v;
        }
    }

    return $arr;
}

/**
 * 返回自定义属性名称|值列表
 * @param integer $flag 自定义属性值
 * @param string $delimiter 分割符
 * @param boolean $iskey 是否返回key
 * @param boolean $isarray 是否返回数组
 * @return array|string
 */
//返回
function flag2Str($flag, $delimiter = ' ', $iskey = false, $isarray = false)
{
    if (empty($flag)) {
        return $isarray ? array() : '';
    }
    $flagStr = array();
    $flagtype = get_item('flagtype');//文档属性
    foreach ($flagtype as $k => $v) {
        if ($flag & $k) {
            $flagStr[] = $iskey ? $k : $v;
        }
    }
    if ($isarray) {
        return $flagStr;
    } else {
        return implode($delimiter, $flagStr);
    }

}


/**
 * 检查栏目权限
 * @param integer $catid 栏目ID
 * @param string $action 动作
 * @param integer $roleid 角色
 * @param boolean $flag 是否为管理组[0会员组,1管理员组]
 * @return boolean
 */
function check_category_access($catid, $action, $roleid, $flag = 1)
{
    $value = false;
    static $access = null;
    static $access_cid = 0;
    if (!is_array($access) || $access_cid != $catid) {
        $access = M('categoryAccess')->where(array('catid' => $catid))->select();
        if (empty($access)) {
            $access = array();
        }
        $access_cid = $catid;
    }

    foreach ($access as $v) {
        if ($v['flag'] == $flag && $v['roleid'] == $roleid && $v['action'] == $action) {
            $value = true;
            break;
        }
    }
    return $value;
}

/**
 * 返回有权限的栏目(添加文档或修改文档时)
 * @param array $cate 栏目数组
 * @param string $action 动作
 * @return array
 */
function get_category_access($cate, $action = 'add')
{
    if (empty($cate)) {
        return array();
    }
    //权限检测//超级管理员
    if (!empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
        return $cate;
    }

    $where = array('flag' => 1, 'roleid' => intval($_SESSION['yang_adm_roleid']));
    if (!empty($action)) {
        $where['action'] = $action;
    }

    $checkaccess = M('categoryAccess')->distinct(true)->where($where)->getField('catid', true);
    if (empty($checkaccess)) {
        $checkaccess = array();
    }

    $array = array();
    foreach ($cate as $v) {
        if (in_array($v['id'], $checkaccess)) {
            $array[] = $v;
        }
    }
    return $array;
}

/**
 * 快速文件数据读取和保存(原数据)-针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param string $path 缓存路径
 * @return mixed
 */
function rw_data($name, $value = '', $path = CONF_PATH)
{

    static $_cache = array();
    $filename = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name, '*') ? array_map("unlink", glob($filename)) : unlink($filename);
        } else {
            // 缓存数据
            $dir = dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir, 0755, true);
            $_cache[$name] = $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value = include $filename;
        $_cache[$name] = $value;
    } else {
        $value = false;
    }
    return $value;
}


/**
 * 返回内容中附件id数组
 * @param string $content 内容 in
 * @param string $firstpic 第一张缩略图 out
 * @param boolean $flag 是否获取第一张缩略图
 * @return mixed
 */
function get_att_content(&$content, &$firstpic = null, $flag = false)
{

    //内容中的图片
    $img_arr = array();
    $reg = "/<img[^>]*src=\"((.+)\/(.+)\.(jpg|gif|bmp|png))\"/isU";
    preg_match_all($reg, $content, $img_arr, PREG_PATTERN_ORDER);
    // 匹配出来的不重复图片
    $img_arr = array_unique($img_arr[1]);
    $attid_array = array();

    if (!empty($img_arr)) {


        $baseurl = get_url_path(get_cfg_value('CFG_UPLOAD_ROOTPATH'), true);
        $baseurl2 = get_url_path(get_cfg_value('CFG_UPLOAD_ROOTPATH'));//不带域名
        /*
        foreach ($img_arr as $k => $v) {
            $img_arr[$k] = str_replace(array($baseurl,$baseurl2), array('',''), $v);//清除域名前缀
        }
        */
        $img_arr = str_replace(array($baseurl, $baseurl2), array('', ''), $img_arr);//清除域名前缀


        $attid = M('attachment')->field('id,filepath')->where(array('filepath' => array('in', $img_arr)))->select();

        if ($attid) {

            //只有缩略图为空时,才提取第一张图片
            if ($flag && isset($firstpic)) {
                //取出本站内的第一张图
                foreach ($img_arr as $v) {
                    foreach ($attid as $v2) {
                        if ($v == $v2['filepath']) {
                            $imgtbSize = explode(',', get_cfg_value('CFG_IMGTHUMB_SIZE'));//配置缩略图第一个参数
                            $imgTSize = explode('X', $imgtbSize[0]);
                            $firstpic = get_picture($baseurl2 . $v2['filepath'], intval($imgTSize[0]), intval($imgTSize[1]));
                            break 2;
                        }
                    }
                }
            }

            //attid 数组
            foreach ($attid as $v) {
                $attid_array[] = $v['id'];
            }
        }

    }

    return $attid_array;
}

/**
 * 返回附件id数组
 * @param string|array $attachment 附件内容
 * @param boolean $flag 是否是缩略图
 * @return mixed
 */
function get_att_attachment($attachment, $flag = false)
{


    if (empty($attachment)) {
        return array();
    }
    $attid_array = array();
    $baseurl = get_url_path(get_cfg_value('CFG_UPLOAD_ROOTPATH'));

    //清除缩略图的!200X200.jpg后缀
    if ($flag) {
        $attachment = preg_replace(array('#!(\d+)X(\d+)\.jpg$#i', '#^' . $baseurl . '#i'), array('', ''), $attachment);
    } else {
        $attachment = str_replace($baseurl, '', $attachment);
    }

    $attid = M('attachment')->where(array('filepath' => array('IN', $attachment)))->getField('id', true);
    if ($attid) {
        $attid_array = $attid;
    }

    return $attid_array;
}

/**
 * 返回保存到attachmentindex表
 * @param integer|array $attid 附件id
 * @param integer $attid 附件id
 * @param integer $modelid 模型id
 * @param string $modelname 模型名称(唯一标志符)
 * @return mixed
 */
function insert_att_index($attid, $arcid, $modelid, $modelname = '')
{
    if (empty($attid) || empty($arcid)) {
        return false;
    }
    if (empty($modelid) && $modelname == '') {
        return false;
    }

    if (is_array($attid)) {
        $attid_array = array_unique($attid);
    } else {
        $attid_array = array($attid);
    }

    //mysql,支持addAll
    if (in_array(strtolower(C('DB_TYPE')), array('mysql', 'mysqli', 'mongo'))) {

        $dataAtt = array();
        foreach ($attid_array as $v) {
            if ($modelid > 0) {
                $dataAtt[] = array('attid' => $v, 'arcid' => $arcid, 'modelid' => $modelid);
            } else {
                $dataAtt[] = array('attid' => $v, 'arcid' => $arcid, 'desc' => $modelname);
            }
        }
        M('attachmentindex')->addAll($dataAtt);
    } else {

        foreach ($attid_array as $v) {
            if ($modelid > 0) {
                M('attachmentindex')->add(array('attid' => $v, 'arcid' => $arcid, 'modelid' => $modelid));
            } else {
                M('attachmentindex')->add(array('attid' => $v, 'arcid' => $arcid, 'desc' => $modelname));
            }
        }
    }


    return true;
}


/**
 * 返回保存到attachmentindex表
 * @param string $name 元素名称
 * @param integer $typeid 类型
 * @param string $tvalue 表单类型和可选值
 * @param string|integer $vaule 值
 * @return mixed
 */

function get_element_html($name, $typeid, $tvalue = '', $vaule = '')
{

    if (empty($name) || empty($typeid)) {
        return '';
    }

    switch ($typeid) {
        case 1:
            $type = 'text';
            $vaule = intval($vaule);
            break;
        case 2:
            $type = 'text';
            break;
        case 3:
            $type = 'textarea';
            break;
        case 4:
            $type = 'radio';
            $vaule = intval($vaule);
            break;
        default:
            $type = 'text';
            break;
    }


    if (!empty($tvalue)) {
        $array = explode("\n", str_replace("\r\n", "\n", trim($tvalue, "\r\n")));
        if (in_array($array[0], array('select', 'radio', 'checkbox', 'text', 'textarea'))) {
            $type = $array[0];
            unset($array[0]);
            if (strpos($tvalue, '|')) {
                $tvalue = array();
                foreach ($array as $val) {
                    list($k, $v) = explode('|', $val);
                    $tvalue[$k] = $v;
                }
            } else {
                foreach ($array as $val) {
                    $tvalue[$val] = $val;
                }
            }
        } else {

        }

    }
    $str = '';
    switch ($type) {
        case 'text':
            $str = '<input type="text"  class="form-control" name="' . $name . '" value="' . $vaule . '">';
            break;
        case 'textarea':
            $str = '<textarea name="' . $name . '" id="' . $name . '" class="form-control" rows="5">' . $vaule . '</textarea>';
            break;
        case 'radio':
            if (!is_array($tvalue)) {
                $tvalue = array(1 => '是', 0 => '否');
            }
            foreach ($tvalue as $k => $v) {
                $str .= '<label class="radio-inline"><input type="radio" name="' . $name . '" value="' . $k . '" ';
                if ($vaule == $k) {
                    $str .= 'checked="checked" ';
                }
                $str .= '/>' . $v . '</label>';
            }

            break;
        case 'checkbox':
            if (!is_array($tvalue)) {
                break;
            }
            foreach ($tvalue as $k => $v) {
                $str .= '<label class="checkbox-inline"><input type="checkbox" name="' . $name . '" value="' . $k . '" ';
                if ($vaule == $k) {
                    $str .= 'checked="checked" ';
                }
                $str .= '/>' . $v . '</label>';
            }
            break;
        case 'select':

            if (!is_array($tvalue) && false !== strpos($name, 'CFG_THEMESTYLE')) {
                $tmp = get_file_folder_List('./Public/Home/', 1);
                $tvalue = array();
                foreach ($tmp as $key => $value) {
                    $tvalue[$value] = $value;
                }
            } elseif (!is_array($tvalue) && false !== strpos($name, 'CFG_MOBILE_THEMESTYLE')) {
                $tmp = get_file_folder_List('./Public/Mobile/', 1);
                $tvalue = array();
                foreach ($tmp as $key => $value) {
                    $tvalue[$value] = $value;
                }
            }
            if (!is_array($tvalue)) {
                $tvalue = array();
            }

            $str .= '<select name="' . $name . '" class="form-control">';
            foreach ($tvalue as $k => $v) {
                $str .= '<option value="' . $k . '" ';
                if ($vaule == $k) {
                    $str .= 'selected="selected" ';
                }
                $str .= '>' . $v . '</option>';
            }

            $str .= '</select>';
            break;
        default:
            $str = '';
            break;
    }

    return $str;


}

/**
 * 返回文档url,主要针对模型下的文章[或者必须有flag,jumpurl字段的文档]
 * @param array $arc 文档内容
 * @param integer $typeid 类型
 * @param string $tvalue 表单类型和可选值
 * @param string|integer $vaule 值
 * @return mixed
 */

function view_url($arc, $act = 'Show/index')
{
    if (($arc['flag'] & B_JUMP) && !empty($arc['jumpurl'])) {
        $url = go_link($arc['jumpurl']);
    } else {
        $url = go_link(C('DEFAULT_MODULE') . '/' . $act . '?cid=' . $arc['cid'] . '&id=' . $arc['id'], 1);
    }
    return $url;
}


/**********************************************/


/*
 * 格式化订单号
 * @$orderid 订单主键
 * return $order_sn 订单号 如 w_01 w_02 w_03 w_15
 * 
 *
 * */

function getorder_sn($orderid)
{
    $order_sn = 'W_';
    if (intval($orderid) < 10) {
        $order_sn = $order_sn . '0' . $orderid;
    } else {
        $order_sn = $order_sn . '' . $orderid;
    }
    return $order_sn;
}


/*
 * 获得第6层最大的seid
 * @param $seid 输入的seid
 * return $biggestseid
 *
 * */

function getTheSixthBiggestSeid($seid,$rank=1)
{
    /*   1——100            （首单）    => $rank = 1
     *   101——300          （复消1单） => $rank = 2
     *   301——600        	（复消2单）=> $rank = 3
     *   601——1092			（复消3单）=> $rank = 4
     *
     * */
     
    switch ($rank){
        case 1 :{
            $biggestseid = (((($seid*3+1)*3+1)*3+1)*3+1) + 60 ;//第四次层 第61个 100位 = ( 3 + 9 + 27 )+ 61
            break;
        }
        case 2 :{
            $biggestseid = ((((($seid*3+1)*3+1)*3+1)*3+1)*3+1) + 179  ; //第五次层 第180个 300位 = ( 3 + 9 + 27 + 81  )+  179
            break;
        }
        case 3 :{
            $biggestseid =  (((((($seid*3+1)*3+1)*3+1)*3+1)*3+1)*3+1) +236  ; //第六次层 第237个 600位 = ( 3 + 9 + 27 + 81 + 243 )+  236
            break;
        }
        case 4 :{
            $biggestseid = (((((($seid + 1) * 3 + 1) * 3 + 1) * 3 + 1) * 3 + 1) * 3 + 1) * 3;
            break;
        }
        default :{
            $biggestseid = (((($seid*3+1)*3+1)*3+1)*3+1) + 60 ;//第四次层 第61个 100位 = ( 3 + 9 + 27 )+ 61

            break;
        }
    }

//    $biggestseid = (((((($seid + 1) * 3 + 1) * 3 + 1) * 3 + 1) * 3 + 1) * 3 + 1) * 3;
    return $biggestseid;
}

/*删除索引数组的一个指定元素
 *
 * */
function array_remove(&$arr, $offset)
{
    array_splice($arr, $offset, 1);
}


/**
 * 导出数据为excel表格
 * @param $data    一个二维数组,结构如同从数据库查出来的数组
 * @param $title   excel的第一行标题,一个数组,如果为空则没有标题
 * @param $filename 下载的文件名
 * @examlpe
$stu = M ('User');
 * $arr = $stu -> select();
 * exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
 */
function exportexcel($data = '', $filename = 'report')
{

    ob_end_clean();
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel;charset=utf-8");
    header("Content-Disposition:attachment;filename=" . $filename . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");


    /*$str =  "<table  >
                <thead>
                <tr>
                    <th  >月份</th>
                    <th >总业绩</th>
                    <th>总净利润</th>
                </tr>
                </thead>
                <tbody>
                

                    <tr>
                        <td>2017-03</td>
                        <td>10860.00</td>
                        <td>9951.576</td>
                    </tr>

               <tr>
                        <td>2017-03</td>
                        <td>10860.00</td>
                        <td>9951.576</td>
                    </tr>
                     <tr>
                        <td>2017-03</td>
                        <td>10860.00</td>
                        <td>9951.576</td>
                    </tr>
                <tr>
                    <td>总业绩（历史以来）</td>
                    <td>10860</td>
                    <td>9951.576</td>
                </tr>
                
                </tbody>
            </table>";*/

    /*  if (function_exists("iconv")) {
       die('chng');
   }else{
       die('cuowu');
   }*/
    $str = iconv("UTF-8", "GB2312", $data);
    echo  $str;
}


/*
 *
 *
 *
 * 把二维数组求和，相当于求和合并，二维变一维数组
 *
 *
 * */

function array_merge_sum($arr){
    $resultarr = array();

    foreach ($arr as $arrv){
        $resultarr = array_merge_recursive($resultarr, $arrv);
    }

    foreach ($resultarr as $rak => $rav){
        $resultarr[$rak] = number_format(array_sum($rav),2,'.','');
    }
//    p($resultarr);
    return $resultarr;

}



/*
 *
 * 获得输入时间戳的，获得当月1号的时间戳
 * @param $datestr
 *
 *
 * */

function getFirstDaytime($datestr){
    $dateym = date('Y-m',$datestr);//一号的格式化时间
    return strtotime($dateym);//一号时间戳
}


/*
 * 避免数字小于零，如果小于零就等于1，分页用
 *
 * @param $num
 *
 * */
function advoidnegative($num){
    $num = $num<=0 ? 1 : $num;
    return $num;
}

/*
 * 避免数字大于确定的数字，分页用
 *
 * @param $num
 * @param $biggest 最大的数字，不可以比他大
 *
 * */
function advoidTranscend($num,$biggest){
    $num = $num>=$biggest ? $biggest : $num;
    return $num;
}



//array_search,这种方法亦有弊端，array_search搜索到一个合适的值时便返回，所以在数组存在多个相关的值这种方法不适用）
function delByValue($arr, $value){
    $key = array_search($value,$arr);
    if(isset($key)){
        unset($arr[$key]);
    }
    return $arr;
}



/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null) {
//    $config = C('THINK_EMAIL');//<span style="white-space:pre">     </span>//提取上面的配置
    $config = D('email')->find(1);
    vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件，vendor是thinkphp中引用扩展的//方法
    vendor('PHPMailer.class#smtp');

    $mail = new PHPMailer(); //PHPMailer对象
    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();  // 设定使用SMTP服务
    $mail->SMTPDebug = 0
    ;
    // $mail->SMTPDebug = 1;                     // 关闭SMTP调试功能
    // 1 = errors and messages
    // 2 = messages only
    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true);
    $mail->SMTPAuth = true;                  // 启用 SMTP 验证功能
    //$mail->SMTPAuth = false;                  // 启用 SMTP 验证功能 如果为false则不用填写用户名密码也可以发送Email
    $mail->SMTPSecure = 'ssl';                 // 使用安全协议,,很重要
    $mail->Host = $config['host'];  // SMTP 服务器
    $mail->Port = $config['port'];  // SMTP服务器的端口号
    $mail->Username = $config['username'];  // SMTP服务器用户名
    $mail->Password = $config['password'];  // SMTP服务器密码

//    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);

    $mail->FromName = $config['fromname'];
    $mail->From = $config['fromemail'];

    /*
      //添加邮件回复
      $replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
      $replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
      $mail->AddReplyTo($replyEmail, $replyName);
     */

    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->AddAddress($to, $name);

    /*
      if(is_array($attachment)){ // 添加附件
      foreach ($attachment as $file){
      is_file($file) && $mail->AddAttachment($file);
      }
      }
     */
    $status = $mail->send();

//简单的判断与提示信息
    if($status) {
        return '发送邮件成功';
    }else{
        return '发送邮件失败，错误信息未：'.$mail->ErrorInfo;
    }
//    return $status;
}





?>