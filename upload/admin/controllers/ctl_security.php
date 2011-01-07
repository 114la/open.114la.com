<?php
/**
 * 系统配置
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    control
 * @version    $Id: ctl_security.php 574 2009-11-23 13:45:52Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

/**
 * 系统设置控制器
 */
class ctl_security
{
    public static function cc()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', 'CC防护设置') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_security( $_POST['config'] );
                mod_login::message("修改成功!");
            }
            app_tpl::assign( 'option_proxy', array( 0 => '关闭', 1 => '开启') );
            app_tpl::assign( 'option_cc', array( 0 => '不使用', 1 => '普通模式', 2 => '加强模式') );
            app_tpl::assign( 'config', mod_config::get_security() );
            app_tpl::display( 'config_cc.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        } 
    }


    public static function agent()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', '基本安全设置') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_security( $_POST['config'] );
                mod_login::message("修改成功!");
            }
            app_tpl::assign( 'option_proxy', array( 0 => '关闭', 1 => '开启') );
            app_tpl::assign( 'config', mod_config::get_security() );
            app_tpl::display( 'config_agent.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        } 
    }
}
