<?php
/**
 * 酷站分类管理控制器
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: ctl_cool_class.php 539 2009-11-23 12:19:37Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_cool_class
{
    /**
     * 分类列表
     */
    public function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '酷站分类列表') );
            if( isset($_POST['commit']) && $_POST['commit'] == 1)
            {
                mod_cool_class::update_class( $_POST,  $_POST['action'] );
                mod_login::message("保存成功!");
            }
            $class_id =  isset($_GET['classid']) ? $_GET['classid'] : '';

            $class_list = mod_cool_class::get_class_list();

            app_tpl::assign( 'classid', $class_id );
            app_tpl::assign( 'class_list', $class_list );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }

    }

    /**
     * 添加分类
     */
    public function add()
    {
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '新增酷站分类') );
            if(isset($_POST['classnewname']))
            {
                mod_cool_class::add_class( $_POST );
                if(!empty($_POST['mkhtml']))
                {
                    //同时生成页面
                }
            }
            app_tpl::assign( 'action', 'add' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * 修改分类
     */
    public function edit()
    {
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '编辑酷站分类') );
            $id = isset($_GET['id']) ? intval($_GET['id']) : '';
            if( $_POST )
            {
                mod_cool_class::edit_class( $_POST );
                if(!empty($_POST['mkhtml']))
                {
                    //同时生成页面
                }
            }

            app_tpl::assign( 'action', 'edit' );
            app_tpl::assign( 'info', mod_cool_class::get_a_class($id) );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * 删除分类
     */
    public function del()
    {
        try
        {
            if( !isset($_GET['id']) )
            {
                throw new Exception('id不能为空');
            }
            mod_class::delete_class_and_update_cache( intval($_GET['id']) );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * 搜索分类
     */
    public function search()
    {
        try
        {
            if( isset($_GET['k']) )
            {
                header("Content-type: text/html; charset=gbk");
                echo iconv('utf-8', 'gbk', json_encode(mod_cool_class::search_class($_GET['k'])) );
            }
            exit;
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * post钩子方法
     */
    public function post()
    {
        try
        {
            app_tpl::display( 'cool_class.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }
}
?>
