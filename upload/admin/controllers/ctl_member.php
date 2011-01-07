<?php
/**
 * 管理员管理
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_member
{
    public function index()
    {
        app_tpl::assign( 'npa', array('管理首页', '管理员管理') );
        $this->member_list();
    }

    /**
     * 管理员列表
     */
    public function member_list()
    {
        try
        {
            $data=mod_member::member_list();
            app_tpl::assign('data', $data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
            app_tpl::assign('login', $login_data);
        }
        $sys=array('formurl'=>'?c=member&a=member_delete',  );
        app_tpl::assign('sys', $sys);
        app_tpl::display('member_list.tpl');
    }

    /*
     * 编辑权限和密码
     */
    public function member_edit()
    {
        app_tpl::assign( 'npa', array('管理首页', '权限管理') );
        $step=(empty($_POST['step']))?'':$_POST['step'];
        if(2==$step)//save it
        {
            try
            {
                $name=(empty($_POST['name']))?'':$_POST['name'];
                $password=(empty($_POST['password']))?'':$_POST['password'];
                $rightdb=(empty($_POST['auth']))?'':$_POST['auth'];
                mod_member::member_save($name, $password, $rightdb);
                mod_login::message('修改资料成功.',"?c=member&a=member_list&name=$name");// go on
                exit;
            }
            catch (Exception $e)
            {
                app_tpl::assign('error', $e->getMessage());
            //返回错误信息以及数据,
            }
                app_tpl::display('member_list.tpl');
            }
        else//read it
        {
            try
            {
                $name=(empty($_GET['name']))?'':$_GET['name'];
                $data=mod_member::member_edit($name);
                app_tpl::assign('data',$data);
                $sys=array('goback'=>'?c=member',   'subform'=>'?c=member&a=member_edit');
                app_tpl::assign('sys', $sys);
                $right=mod_login::P_unserialize($data['adminright']);
                app_tpl::assign('auth',$right);//模板权限
            }
            catch (Exception $e)
            {
                app_tpl::assign('error', $e->getMessage());
            }
            app_tpl::display('member_edit.tpl');
        }
    }

    /*
     * 添加用户,添加成功后,跳转到编辑页面.设定权限.
     */
    public function member_add()
    {
        try
        {
            app_tpl::assign( 'npa', array('管理首页', '新增管理员') );
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if(2==$step)
            {
                $name=(empty($_POST['name']))?'':$_POST['name'];
                $password=(empty($_POST['password']))?'':$_POST['password'];
                $data=mod_member::member_add($name, $password);
                mod_login::message('添加用户成功,进入设置改用户权限!',"?c=member&a=member_edit&name=$name");
                exit;
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
            app_tpl::assign('data', $_POST);
        }
        $sys=array('goback'=>'?c=member',   'subform'=>'?c=member&a=member_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('member_add.tpl');
    }


    public function member_delete()
    {
        try
        {
            $name=(empty($_REQUEST['id']))?'':$_REQUEST['id'];
            mod_member::member_delete($name);
            mod_login::message("用户删除成功!", '?c=member');
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $this->member_list();
    }


    public function member_password()//change password
    {
        try
        {
            app_tpl::assign( 'npa', array('管理首页', '重设密码') );
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if(2==$step)
            {
                $name=(empty($_POST['name']))?'':$_POST['name'];
                $password=(empty($_POST['password']))?'':$_POST['password'];
                if(1==If_manager)
                {
                    mod_member::member_password($name, $password,2);//超级管理员修改密码
                }
                else
                {
                    mod_member::member_password($name, $password);
                }
                mod_login::message('添加用户成功,进入设置改用户权限!',"?c=member&a=member_edit&name=$name");
                exit;
                app_tpl::display('member_list');
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('name',$_POST['name']);
            app_tpl::assign('error', $e->getMessage());
        }
        $sys=array('goback'=>'?c=member',   'subform'=>'?c=member&a=member_password');
        app_tpl::assign('sys', $sys);
        app_tpl::display('member_password.tpl');
    }



}
