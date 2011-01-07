<?php
/**
 * 首页广告
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_advise_index
{
/**
 * 返回的消息
 * @var string
 */
		private static $message = '';

    public function index()
    {
        app_tpl::assign( 'npa', array('广告管理', '首页广告管理') );
        $this->advise_index_list();
    }
    /**
     * 显示
     *
     * @return viod
     */

    public function advise_index_list()
    {
        try
        {
            $data = mod_advise_index::advise_index_list();
            app_tpl::assign('data', $data);

        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys=array('goback'=>'?c=famous_nav',   'subform'=>'?c=advise_index&a=advise_index_submit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('advise_index.tpl');//更改模板
    }

    /**
     * 添加和编辑
     */
    public function advise_index_add()
    {
        try
        {
            app_tpl::assign( 'npa', array('广告管理', '添加首页广告') );
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($step==2)
            {
                $data=$_POST;
                mod_advise_index::advise_index_add($data);                
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                mod_advert::update_cache_main_advert();
                mod_make_html::auto_update('index');
                mod_login::message("添加广告成功.",'?c=advise_index&action='.$action);
                exit;
            }
            else
            {
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                $sys=array('goback'=>'?c=advise_index&action='.$action,   'subform'=>'?c=advise_index&a=advise_index_add&action='.$action);
                app_tpl::assign('sys', $sys);
            }
        }
        catch (Exception $e)
        {
            $data=(!isset($_POST))?'':$_POST;
            app_tpl::assign('data', $data);
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('advise_index_add.tpl');
    }

    /**
     * 保存信息
     */
    public function advise_index_save()
    {
        try
        {
            app_tpl::assign( 'npa', array('广告管理', '编辑首页广告') );
            $data=array();
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($step==2)
            {
                $data=$_POST;
                mod_advise_index::advise_index_save($data,'save');
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                mod_advert::update_cache_main_advert();
                mod_make_html::auto_update('index');
                mod_login::message("修改数据成功.",'?c=advise_index&action='.$action);
                exit;
            }
            else
            {
                $data['id']=(empty($_GET['id']))?'':$_GET['id'];
                $data=mod_advise_index::advise_index_save($data,'select');
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                $sys=array('goback'=>'?c=advise_index&action='.$action,   'subform'=>'?c=advise_index&a=advise_index_save');
                app_tpl::assign('sys', $sys);
                app_tpl::assign('data',$data);
                app_tpl::display('advise_index_add.tpl');//更改模板,分割   点击的膜拜 .......  advise_index 可以参考此类  同一模板
                exit;
            }
        }
        catch (Exception $e)
        {
            $data=(!isset($_POST))?'':$_POST;
            app_tpl::assign('data', $data);
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('advise_index_add.tpl');//更改模板
    }

    /**
     * 启用,删除
     */
    public function advise_index_submit()
    {
        try
        {
            $subaction=(empty($_POST['subaction']))?'':$_POST['subaction'];
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($subaction=='display')
            {
                $this->advise_index_display();
            }
            elseif($subaction=='delete')
            {
                $this->advise_index_delete();
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
        $this->advise_index_list();
    }

    /**
     * 启用
     */
    public function advise_index_display()
    {
            $applyid=(!is_array($_POST['applyid']))?array():$_POST['applyid'];
            $select_id_all=(!is_array($_POST['select_id_all']))?array():$_POST['select_id_all'];
            $data = mod_advise_index::advise_index_display($applyid,$select_id_all);
            $action=(empty($_REQUEST['action']))?'header_1':$_REQUEST['action'];
            mod_login::message("显示设置成功.",'?c=advise_index&action='.$action);
            exit;
    }

    /**
     * 删除
     */
    public function advise_index_delete()
    {
        $applyid='';
        $data=(empty($_POST['id']))?array():$_POST['id'];
        $data = mod_advise_index::advise_index_delete($data);
        mod_advert::update_cache_main_advert();
        mod_make_html::auto_update('index');
        $action=(empty($_REQUEST['action']))?'header_1':$_REQUEST['action'];
        mod_login::message("删除数据成功.",'?c=advise_index&action='.$action);
        exit;
    }


}
?>
