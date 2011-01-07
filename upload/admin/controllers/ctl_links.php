<?php
/**
 * 友情链接管理控制器
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_links.php 2010-11-29 09:08:41 yzt $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_links
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
            app_tpl::assign('npa', array('网址管理', '友情链接列表'));
            $data = mod_links::get_links_list();
            app_tpl::assign('data',$data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=links',   'subform'=>'?c=links&a=links_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('links_list.tpl');
    }
    
    /**
     * 操作 删除 排序
     *
     * @return void
     */
    public static function links_operate()
    {
        $ids = empty($_GET['id']) ? $_POST['id'] : (array)$_GET['id'];
        //如果传过来id不为空，做删除操作
        if (!empty($ids))
        {
            mod_links::links_delete($ids);
        }

        //做排序操作
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        mod_links::links_sort($sort);

        //做是否显示操作
        $is_show = empty($_POST['is_show']) ? '' : $_POST['is_show'];
        mod_links::links_is_show($is_show);
        
        mod_links::update_cache_links_js(); //更新缓存
        $referer = empty($_POST['referer']) ? "?c=links" : $_POST['referer'];
        mod_login::message('操作成功', $referer);
    }

    /**
     * 添加友情链接
     */
    public function links_add()
    {
        $referer = empty($_POST['referer']) ? "?c=links" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '添加友情链接') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_links::links_save_add( $form ))
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
        $sys = array('goback'=>'?c=links',   'subform'=>'?c=links&a=links_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('links_form.tpl');
    }

    /**
     * 修改友情链接
     */
    public function links_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=links" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '修改友情链接') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //防止出错之前填的数据丢失
                $form = $_POST['form'];
                if (mod_links::links_save_edit( $form ))
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
                (!$id) && mod_login::message('请选择要修改的友情连接', $referer);
                $data = mod_links::get_links_info($id);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=links',   'subform'=>'?c=links&a=links_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('links_form.tpl');
    }
}
