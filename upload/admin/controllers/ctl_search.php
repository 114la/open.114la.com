<?php
/**
 * 搜索引擎管理控制器
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_search.php 2010-12-02
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_search
{
    /**
     * 显示
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign('npa', array('网址管理', '搜索引擎列表'));
            $classid = empty($_GET['classid']) ? '' : $_GET['classid'];
            //如果没有选择分类，以第一个分类
            if (empty($classid))
            {
                app_db::query("SELECT classid FROM `ylmf_searchclass`");
                $data = app_db::fetch_one();
                $classid = $data['classid'];
            }
            app_tpl::assign('classid', $classid);
            $data = mod_search::get_search_list($classid);
            app_tpl::assign('data',$data);
            $options = mod_search_class::get_search_class_options();
            app_tpl::assign('options', $options);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search',   'subform'=>'?c=search&a=search_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_list.tpl');
    }
    
    /**
     * 操作 删除 排序
     *
     * @return void
     */
    public static function search_operate()
    {
        $referer = empty($_POST['referer']) ? "?c=search" : $_POST['referer'];

        $ids = empty($_GET['id']) ? $_POST['id'] : (array)$_GET['id'];
        $classid = empty($_GET['classid']) ? $_POST['classid'] : $_GET['classid'];
        if (empty($classid))
        {
            mod_login::message('操作失败，请选择分类', $referer);
        }
        //如果传过来id不为空，做删除操作
        if (!empty($ids))
        {
            mod_search::search_delete($ids, $classid);
        }
        else
        {
            //做是否默认操作，和删除有冲突，避开
            $id = empty($_POST['is_default']) ? '' : $_POST['is_default'];
            mod_search::search_set_default($id, $classid);
        }
        
        //做排序操作
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        if ($sort)
        {
            mod_search::search_sort($sort);
        }

        //做是否显示操作
        $is_show = empty($_POST['is_show']) ? '' : $_POST['is_show'];
        if ($is_show)
        {
            mod_search::search_is_show($is_show, $classid);
        }
        
        mod_login::message('操作成功', $referer);
    }

    /**
     * 添加搜索引擎
     */
    public function search_add()
    {
        $referer = empty($_POST['referer']) ? "?c=search" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '添加搜索引擎') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_search::search_save_add( $form ))
                {
                    mod_login::message('操作成功', $referer);
                }
                else
                {
                    mod_login::message('操作失败', $referer);
                }
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search',   'subform'=>'?c=search&a=search_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_form.tpl');
    }

    /**
     * 修改搜索引擎
     */
    public function search_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=search" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '修改搜索引擎') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_search::search_save_edit( $form ))
                {
                    exit(mod_login::message('操作成功', $referer));
                }
                else
                {
                    exit(mod_login::message('操作失败', $referer));
                }
            }
            else
            {
                $id = empty($_GET['id']) ? '' : $_GET['id'];
                (!$id) && mod_login::message('请选择要修改的搜索引擎', $referer);
                $data = mod_search::get_search_info($id);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search',   'subform'=>'?c=search&a=search_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_form.tpl');
    }
}
