<?php
/**
 *  搜索引擎关键字管理控制器
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_search_keyword.php 2010-12-02
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_search_keyword
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
            app_tpl::assign('npa', array('网址管理', ' 搜索引擎关键字列表'));
            $classid = empty($_GET['classid']) ? '' : $_GET['classid'];
            //如果没有选择分类，以第一个分类
            if (empty($classid))
            {
                app_db::query("SELECT classid FROM `ylmf_searchclass`");
                $data = app_db::fetch_one();
                $classid = $data['classid'];
            }
            app_tpl::assign('classid', $classid);
            $data = mod_search_keyword::get_search_keyword_list($classid);
            app_tpl::assign('data',$data);
            $options = mod_search_class::get_search_class_options();
            app_tpl::assign('options', $options);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_keyword',   'subform'=>'?c=search_keyword&a=search_keyword_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_keyword_list.tpl');
    }
    
    /**
     * 操作 删除 排序
     *
     * @return void
     */
    public static function search_keyword_operate()
    {
        $referer = empty($_POST['referer']) ? "?c=search_keyword" : $_POST['referer'];

        $ids = empty($_GET['id']) ? $_POST['id'] : (array)$_GET['id'];
        //如果传过来id不为空，做删除操作
        if (!empty($ids))
        {
            mod_search_keyword::search_keyword_delete($ids);
        }
        
        //做排序操作
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        if ($sort)
        {
            mod_search_keyword::search_keyword_sort($sort);
        }

        mod_login::message('操作成功', $referer);
    }

    /**
     * 添加 搜索引擎关键字
     */
    public function search_keyword_add()
    {
        $referer = empty($_POST['referer']) ? "?c=search_keyword" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '添加 搜索引擎关键字') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_search_keyword::search_keyword_save_add( $form ))
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
        $sys = array('goback'=>'?c=search_keyword',   'subform'=>'?c=search_keyword&a=search_keyword_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_keyword_form.tpl');
    }

    /**
     * 修改 搜索引擎关键字
     */
    public function search_keyword_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=search_keyword" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '修改 搜索引擎关键字') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_search_keyword::search_keyword_save_edit( $form ))
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
                (!$id) && mod_login::message('请选择要修改的 搜索引擎关键字', $referer);
                $data = mod_search_keyword::get_search_keyword_info($id);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_keyword',   'subform'=>'?c=search_keyword&a=search_keyword_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_keyword_form.tpl');
    }
}
