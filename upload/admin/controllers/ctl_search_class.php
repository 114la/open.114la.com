<?php
/**
 * 搜索引擎分类管理控制器
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_search_class.php 2010-12-02
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_search_class
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
            app_tpl::assign('npa', array('网址管理', '搜索引擎分类列表'));
            $data = mod_search_class::get_search_class_list();
            app_tpl::assign('data',$data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_class',   'subform'=>'?c=search_class&a=search_class_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_class_list.tpl');
    }
    
    /**
     * 操作 删除 排序
     *
     * @return void
     */
    public static function search_class_operate()
    {
        $ids = empty($_GET['classid']) ? $_POST['classid'] : (array)$_GET['classid'];
        //如果传过来id不为空，做删除操作
        if (!empty($ids))
        {
            mod_search_class::search_class_delete($ids);
        }
        //如果为空，做排序和设默认操作
        else
        {
            //做是否默认操作，和删除有冲突，避开
            $classid = empty($_POST['is_default']) ? '' : $_POST['is_default'];
            mod_search_class::search_class_set_default($classid);
        }
        
        //做排序操作
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        mod_search_class::search_class_sort($sort);

        $referer = empty($_POST['referer']) ? "?c=search_class" : $_POST['referer'];
        mod_login::message('操作成功', $referer);
    }

    /**
     * 添加搜索引擎分类
     */
    public function search_class_add()
    {
        $referer = empty($_POST['referer']) ? "?c=search_class" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '添加搜索引擎分类') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_search_class::search_class_save_add( $form ))
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
        $sys = array('goback'=>'?c=search_class',   'subform'=>'?c=search_class&a=search_class_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_class_form.tpl');
    }

    /**
     * 修改搜索引擎分类
     */
    public function search_class_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=search_class" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '修改搜索引擎分类') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_search_class::search_class_save_edit( $form ))
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
                $classid = empty($_GET['classid']) ? '' : $_GET['classid'];
                (!$classid) && mod_login::message('请选择要修改的搜索引擎分类', $referer);
                $data = mod_search_class::get_search_class_info($classid);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_class',   'subform'=>'?c=search_class&a=search_class_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_class_form.tpl');
    }
}
