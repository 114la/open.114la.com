<?php
/**
 * 名站导航
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_famous_nav
{
/**
 * 返回的消息
 * @var string
 */
    private static $message = '';

    public function index()
    {
        app_tpl::assign( 'npa', array('网址管理', '名站网址列表') );
        $this->famous_nav_list();
    }

    /**
     * 名站导航
     * 显示列表
     */
    public function famous_nav_list()
    {
        try
        {
            $data = mod_famous_nav::famous_nav_list();
            app_tpl::assign('data',$data);
        }
        catch (Exception $e)
        {
						;
        }
        $sys=array('goback'=>'?c=famous_nav',   'subform'=>'?c=famous_nav&a=famous_nav_submit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('famous_nav_list.tpl');//更改模板
    }

    /**
     * 添加信息
     */
    public function famous_nav_add()
    {
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '添加名站') );
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($step==2)//save  反向,为了测试

            {
                $data=$_POST;
                mod_famous_nav::famous_nav_add($data);
                mod_make_html::auto_update('index');
                mod_login::message("添加数据成功!",'?c=famous_nav');
                exit;
            }
        }
        catch (Exception $e)
        {
            if($step==2)
            {
                app_tpl::assign('data', $_POST);
            }
            app_tpl::assign('error', $e->getMessage());
        }
        $sys=array('goback'=>'?c=famous_nav',   'subform'=>'?c=famous_nav&a=famous_nav_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('famous_nav_add.tpl');//更改模板
    }

    /**
     * 删除信息
     */
    public function famous_nav_delete()
    {
        $data=(!is_array($_POST['id']))?array():$_POST['id'];
        $data = mod_famous_nav::famous_nav_delete($data);
        mod_make_html::auto_update('index');
        mod_login::message("删除数据成功.",'?c=famous_nav');
        exit;
    }
    
    /**
     * 保存信息
     */
    public function famous_nav_save()
    {
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '编辑名站') );
            $data=array();
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($step==2)//save
            {
                $data=$_POST;
                mod_famous_nav::famous_nav_save($data,'save');
                mod_make_html::auto_update('index');
                mod_login::message("修改数据成功!",'?c=famous_nav');
                exit;
            }
            else//select

            {
                $data['id']=(empty($_GET['id']))?'':$_GET['id'];
                $data=mod_famous_nav::famous_nav_save($data,'select');
                mod_make_html::auto_update('index');
                app_tpl::assign('data',$data);
            }

        }
        catch (Exception $e)
        {
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($step==2)
            {
                app_tpl::assign('data', $_POST);
            }
            app_tpl::assign('error', $e->getMessage());
        }
        $sys=array('goback'=>'?c=famous_nav',   'subform'=>'?c=famous_nav&a=famous_nav_save');
        app_tpl::assign('sys', $sys);
        app_tpl::display('famous_nav_add.tpl');//更改模板
    }

    /**
     * 排序,删除
     */
    public function famous_nav_submit()
    {
        try
        {
            $action=(empty($_POST['action']))?'':$_POST['action'];
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($action=='order')
            {
                $this->famous_nav_order();
            }
            elseif($action=='delete')
            {
                $this->famous_nav_delete();
            }
            elseif($step==2)
            {
                throw new Exception("没有您执行的动作");
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $this->famous_nav_list();
    }
    /**
     * 排序信息
     */
    public function famous_nav_order()
    {
            $data=(!is_array($_POST['orderby']))?array():$_POST['orderby'];
            $data = mod_famous_nav::famous_nav_order($data);
            mod_make_html::auto_update('index');
            mod_login::message("排序设置成功.",'?c=famous_nav');
            exit;
    }




}
?>
