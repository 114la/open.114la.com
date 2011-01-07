<?php
/**
 * 系统配置
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    control
 * @version    $Id: ctl_config.php 1541 2009-12-11 07:54:41Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

/**
 * 系统设置控制器
 */
class ctl_config
{
    /**
     * ip禁止设置
     *
     * @param none
     * @return none
     * @throws none
     */
    public function ip()
    {
        try
        {
            if( ! empty( $_POST['ip_deny_list'] ) )
            {
                mod_config::set_ip_deny_list( $_POST['ip_deny_list'] );
                mod_login::message("修改成功!");
            }
            $ip_deny_list = mod_config::get_ip_deny_list();
            app_tpl::assign( 'ip_deny_list', $ip_deny_list );
            app_tpl::display( 'config_ip.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     *  基本信息设置
     */
    public static function info()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', '资料设置') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_info( $_POST['config'] );
                mod_login::message("修改成功!");
            }
            app_tpl::assign( 'config', mod_config::get_info() );
            app_tpl::display( 'config_info.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }


    public static function status()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', '状态设置') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_status( $_POST['config'] );
                mod_login::message("修改成功!");
            }
            app_tpl::assign( 'option_toggle', array( 0 => '关闭', 1 => '开启') ); //开关选项
            app_tpl::assign( 'config', mod_config::get_status() );
            app_tpl::display( 'config_status.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }


    public static function fn()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', '功能设置') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_fn( $_POST['config'] );
                mod_login::message("修改成功!");
            }
            app_tpl::assign( 'option_toggle', array( 0 => '关闭', 1 => '开启') ); //开关选项
            app_tpl::assign( 'config', mod_config::get_fn() );
            app_tpl::display( 'config_fn.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    public static function mail()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', '邮箱设置') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_mail( $_POST['config'] );
                mod_login::message("修改成功!");
            }
            app_tpl::assign( 'option_toggle', array( 0 => '关闭', 1 => '开启') ); //开关选项
            app_tpl::assign( 'option_sendmailtype', array( 0 => 'PHP mail函数发送', 1 => 'SMTP方式发送') );
            app_tpl::assign( 'config', mod_config::get_mail() );
            app_tpl::display( 'config_mail.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', '所有设置') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_all( $_POST['config'] );
                mod_login::message("修改成功!");
            }
            if( ! empty( $_POST['ip_deny_list'] ) )
            {
                mod_config::set_ip_deny_list( $_POST['ip_deny_list'] );
            }
            app_tpl::assign( 'option_toggle', array( 0 => '关闭', 1 => '开启') ); //开关选项
            app_tpl::assign( 'option_cc', array( 0 => '不使用', 1 => '普通模式', 2 => '加强模式') );
            app_tpl::assign( 'option_proxy', array( 0 => '关闭', 1 => '开启') );
            app_tpl::assign( 'option_sendmailtype', array( 0 => 'PHP mail函数发送', 1 => 'SMTP方式发送') );
            $ip_deny_list = mod_config::get_ip_deny_list();
            app_tpl::assign( 'ip_deny_list', $ip_deny_list );
            app_tpl::assign( 'config', mod_config::get_all() );
            app_tpl::display( 'config_all.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

}
?>
