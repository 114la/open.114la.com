<?php
/**
 * 网站分类管理控制器
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: ctl_class.php 1541 2009-12-11 07:54:41Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_class
{
    /**
     * 分类列表
     */
    public function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '分类列表') );
            if( isset($_POST['commit']) && $_POST['commit'] == 1)
            {
                mod_class::update_class( $_POST,  $_POST['action'] );
                mod_login::message("保存成功!");
            }
            $class_id =  isset($_GET['classid']) ? $_GET['classid'] : '';

            $class_list = mod_class::get_subclass_list(0);

            app_tpl::assign( 'classid', $class_id );
            app_tpl::assign( 'class_list', $class_list );
            app_tpl::assign( 'option_toggle', array( 0 => '否', 1 => '是' ) );
            $_GET['np'] = "网址管理,分类管理,分类列表";
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
            app_tpl::assign( 'npa', array('网址管理', '添加分类') );
            if(isset($_POST['classnewname']))
            {
                mod_class::add_class( $_POST );
            }
            $class_list = mod_class::get_subclass_list(0);
            app_tpl::assign( 'class_list', $class_list );
            app_tpl::assign( 'action', 'add' );
            $_GET['np'] = "网址管理,分类管理,新增分类";
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
            app_tpl::assign( 'npa', array('网址管理', '编辑分类') );
            $id = isset($_GET['id']) ? intval($_GET['id']) : '';

            // 生成 HTML
            if(!empty($_GET['mkhtml']))
            {
                // 同时生成页面
                $class_id = $id;
                if ($class_id < 1)
                {
                    mod_login::message('操作失败', '?c=class&a=index');
                }

                $msg = <<<BOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title></title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="static/js/common.js"></script>
</head>
<body id="main_page">
<div class="wrap">
    <div class="container">
        <div id="main" style="padding: 10px;">
BOT;
                mod_make_html::flush($msg);

                if (true == mod_make_html::make_html_one_catalog($class_id))
                {
                    mod_make_html::flush('<br/><br/><h2>&nbsp;&nbsp;&nbsp;操作完成</h2>');
    				$msg = '<script type="text/javascript">
                        /*setTimeout("window.location.href= \'?c=make_html\' ", 1000);*/
                        </script></div></div></div></body></html>';
    				mod_make_html::flush($msg);
    				exit;

    				//$main_class_cache = mod_class::get_class_list();
                    //mod_login::message($main_class_cache[$class_id]['classname'] . '分类生成成功', '?c=class&a=index');
                }
                else
                {
                    mod_make_html::flush('<br/><br/><h2>&nbsp;&nbsp;&nbsp;静态页面生成失败</h2>');
    				$msg = '<script type="text/javascript">
                        /*setTimeout("window.location.href= \'?c=make_html\' ", 1000);*/
                        </script></div></div></div></body></html>';
    				mod_make_html::flush($msg);
    				exit;
                }
            }

            if( $_POST )
            {
                mod_class::edit_class( $_POST );
                $_GET['classid'] =  isset($_POST['classid']) ? $_POST['classid'] : '';
            }

            $class_list = mod_class::get_subclass_list(0);
            app_tpl::assign( 'class_list', $class_list );
            app_tpl::assign( 'action', 'edit' );
            app_tpl::assign( 'classid', $_GET['classid']);
            app_tpl::assign( 'returnid', $_GET['classid'] );
            app_tpl::assign( 'info', mod_class::get_a_class( $id ) );
            $_GET['np'] = "网址管理,分类管理,修改分类";
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
                echo iconv('utf-8', 'gbk', json_encode(mod_class::search_class($_GET['k'])) );
            }
            exit;
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * ajax获取分类列表
     */
    public function ajax_get_list()
    {
        if( isset($_GET['id']) )
        {
            $id = intval($_GET['id']);
            header("Content-type: text/html; charset=gbk");
            $result = mod_class::get_subclass_list($_GET['id']);
            if(empty($result))
            {
                echo iconv('utf-8', 'gbk', json_encode($result));
                exit;
            }
            foreach($result as &$tmp)
            {
                $tmp['classname'] = iconv('gbk', 'utf-8//IGNORE', $tmp['classname']);
            }
            echo iconv('utf-8', 'gbk', json_encode($result));
        }
        exit;
    }

    /**
     * post钩子方法
     */
    public function post()
    {
        try
        {
            app_tpl::display( 'class_list.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }
}
?>
