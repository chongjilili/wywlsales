<?php
 
namespace Wanyu\Controller;

class RbacController extends CommonController
{

    public function index()
    {

        $keyword = I('keyword', '', 'htmlspecialchars,trim');

        if (empty($keyword)) {
            $where = array('id' => array('GT', '0'));
        } else {
            $where = array('username' => array('like', "%$keyword%"));
        }

        //当成一对一来处理
        $count = M('admin')->field('password', true)->where($where)->count();

        $page           = new \Common\Lib\Page($count, 10);
        $page->rollPage = 7;
        $page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $limit = $page->firstRow . ',' . $page->listRows;
        $user  = M('admin')->field('password', true)->where($where)->limit($limit)->select(); //view
        if ($user) {
            foreach ($user as $k => $v) {
                $user[$k]['role'] = D('RoleView')->where(array('admin_id' => $v['id']))->select();
            }
        }

        /*
        //使用关联模型(多对多),读取除password 字段外 所有字段
        //$user = D('UserRelation')->field('password', true)->relation(true)->select() ;    //relation显示关系表
        //总数
        $count = D('UserRelation')->field('password', true)->relation(true)->where($where)->count();

        $page = new \Common\Lib\Page($count, 10);
        $page->rollPage = 7;
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $limit = $page->firstRow. ',' .$page->listRows;
        $user = D('UserRelation')->field('password', true)->relation(true)->where($where)->limit($limit)->select() ;    //relation显示关系表

         */

        $this->assign('user', $user);
        $this->assign('page', $page->show());
        $this->assign('type', '系统用户列表');
        $this->assign('keyword', $keyword);
        $this->display();

    }


    //角色列表
    public function role()
    {

        $keyword = I('keyword', '', 'htmlspecialchars,trim');
        $where   = array();

        if (!empty($keyword)) {
            $where['name'] = array('like', "%$keyword%");
        }

        //总数
        $count = M('role')->where($where)->count();

        $page           = new \Common\Lib\Page($count, 10);
        $page->rollPage = 7;
        $page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $limit = $page->firstRow . ',' . $page->listRows;
        $role  = M('role')->where($where)->limit($limit)->select(); //relation显示关系表

        $this->assign('role', $role);
        $this->assign('page', $page->show());
        $this->assign('title', '系统用户组列表');
        $this->assign('keyword', $keyword);
        $this->display();
    }

    //添加角色
    public function addRole()
    {
        if (IS_POST) {
            $this->addRolePost();
            exit();
        }
        $id = I('id', 0, 'intval');
        if (!$id) {
            $title = '添加';
        } else {
            $title = '编辑';
        }
        $role = M('role')->find($id);

        $this->assign('role', $role);
        $this->assign('id', $id);
        $this->assign('title', $title);
        $this->display();
    }

    //添加角色处理
    public function addRolePost()
    {

        //M验证
        $validate = array(
            array('name', 'require', '用户组名必须填写！'),
            array('name', '', '用户组名已经存在！', 0, 'unique', 1),
        );
        $data = M('role');
        if (!$data->validate($validate)->create()) {
            $this->error($data->getError());
        }

        if (M('role')->add($_POST)) {
            $this->success('添加用户组成功', U('Rbac/role'));
        } else {
            $this->error('添加用户组失败');
        }
    }

    //修改角色处理
    public function editRole()
    {

        if (!IS_POST) {
            $this->error('参数错误');
            exit();
        }

        $data = I('post.');
        $id   = $data['id']   = I('id', 0, 'intval');
        $name = $data['name'] = trim($data['name']);
        if (empty($name)) {
            $this->error('用户组名必须填写！');
        }

        if (M('role')->where(array('name' => $name, 'id' => array('neq', $id)))->find()) {
            $this->error('用户组已经存在！');
        }

        if (false !== M('role')->save($data)) {
            $this->success('修改用户组成功', U('Rbac/role'));
        } else {
            $this->error('修改用户组失败');
        }
    }

    //删除角色
    public function delRole()
    {
        $id        = I('id', 0, 'intval');
        $batchFlag = I('get.batchFlag', 0, 'intval');
        //批量删除
        if ($batchFlag) {
            $this->delRoleAll();
            return;
        }

        if (M('role')->delete($id)) {

            $where = array('role_id' => $id);
            //角色用户中间表
            M('role_user')->where($where)->delete();
            //权限
            M('access')->where($where)->delete();
            $this->success('删除用户组成功', U('Rbac/role'));
        } else {
            $this->error('删除用户组失败');
        }
    }

    //指量删除用户处理
    public function delRoleAll()
    {

        $idArr = I('key');
        if (isset($idArr) && !is_array($idArr)) {
            $this->error('请选择要删除的列');
        }

        if (M('role')->where(array('id' => array('in', $idArr)))->delete()) {
            $where = array('role_id' => array('in', $idArr));
            //角色用户中间表
            M('role_user')->where($where)->delete();
            //权限
            M('access')->where($where)->delete();
            $this->success('删除用户组成功', U('Rbac/role'));
        } else {
            $this->error('删除用户组失败');
        }

    }

    //配置权限
    public function access()
    {
        if (IS_POST) {
            $this->accessPost();
            exit();
        }
        $rid    = I('rid', 0, 'intval');
        $access = M('access')->where(array('role_id' => $rid))->getField('node_id', true);
        if (!$access) {
            $access = array();
        }
        $where = array('status' => 1);
        $node  = M('node')->where($where)->order('sort')->select();
        $node  = node2layer($node, $access);
//        p($node);
        $this->assign('node', $node);
        $this->assign('rid', $rid);
        $this->assign('title', '权限设置');
        $this->display();
    }

    //配置权限处理
    public function accessPost()
    {
        $rid    = I('rid', 0, 'intval');
        $access = array();
        //组合权限
        foreach (I('access', array()) as $v) {
            $tmp      = explode('_', $v);
            $access[] = array('role_id' => $rid, 'node_id' => $tmp[0], 'level' => $tmp[1]);
        }

        //清空原权限
        M('access')->where(array('role_id' => $rid))->delete();
        if (empty($access)) {
            $this->success('配置成功', U('Rbac/role'));
        }
        //插入新权限
        //mysql,支持addAll
        $ret = 0;
        if (in_array(strtolower(C('DB_TYPE')), array('mysql', 'mysqli', 'mongo'))) {
            $ret = M('access')->addAll($access);
        } else {
            foreach ($access as $v) {
                $ret = M('access')->add($v);
            }
        }

        if ($ret) {
            $this->success('配置成功', U('Rbac/role'));
        } else {
            $this->error('配置失败');
        }

    }

    //节点列表
    public function node()
    {


        $node = M('node')->order('sort')->select();
        $node = node2layer($node);

        $this->assign('node', $node);
        $this->assign('title', '节点列表');
        $this->display();

    }

    //添加节点
    public function addNode()
    {

        if (IS_POST) {
            $this->addNodePost();
            exit();
        }

        $level = I('level', 1, 'intval');
        $pid   = I('pid', 0, 'intval');

        $type = '';
        switch ($level) {
            case 1:
                $title = '应用';
                break;
            case 2:
                $title = '控制器';
                break;
            case 3:
                $title = '方法';
                break;
        }

        $this->assign('level', $level);
        $this->assign('pid', $pid);
        $this->assign('title', $title);
        $this->display();
    }

    //添加节点处理
    public function addNodePost()
    {

        $data           = I('post.', '');
        $data['name']   = trim($data['name']);
        $data['title']  = trim($data['title']);
        $data['sort']   = I('sort', 0, 'intval');
        $data['status'] = I('status', 0, 'intval');
        if (empty($data['name']) || empty($data['title'])) {
            $this->error('名称和描述不能为空');
        }

        if (M('node')->add($data)) {
            $this->success('添加成功', U('Rbac/node'));
        } else {

            $this->error('添加失败');
        }
    }

    //修改节点
    public function editNode()
    {
        
        if (IS_POST) {
            $this->editNodePost();
            exit();
        }

        $id   = I('id', 0, 'intval');
        $node = M('node')->find($id);
        if (!$node) {
            $this->error('记录不存在');
        }
        switch ($node['level']) {
            case 1:
                $title = '应用';
                break;
            case 2:
                $title = '控制器';
                break;
            case 3:
                $title = '方法';
                break;

        }

        $this->assign('id', $id);
        $this->assign('node', $node);
        $this->assign('title', $title);
        $this->display();
    }

    //修改节点处理
    public function editNodePost()
    {

        $data          = I('post.', '');
        $data['name']  = trim($data['name']);
        $data['title'] = trim($data['title']);
        if (empty($data['name']) || empty($data['title'])) {
            $this->error('名称和描述不能为空');
        }

        if (false !== M('node')->save($data)) {
            $this->success('修改成功', U('Rbac/node'));
        } else {

            $this->error('修改失败');
        }

    }

    //删除节点
    public function delNode()
    {

        $id = I('id', 0, 'intval');

        $childNode = M('node')->where(array('pid' => $id))->select();
        if ($childNode) {
            $this->error('删除失败，请先删除下面的子节点');
        }

        if (M('node')->delete($id)) {
            //权限
            M('access')->where(array('node_id' => $id))->delete();
            $this->success('删除成功', U('Rbac/node'));
        } else {

            $this->error('删除失败');
        }
    }

}
