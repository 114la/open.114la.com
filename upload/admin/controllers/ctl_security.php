<?php
/**
 * ϵͳ����
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    control
 * @version    $Id: ctl_security.php 574 2009-11-23 13:45:52Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

/**
 * ϵͳ���ÿ�����
 */
class ctl_security
{
    public static function cc()
    {
        try
        {
            app_tpl::assign( 'npa', array('ϵͳ����', 'CC��������') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_security( $_POST['config'] );
                mod_login::message("�޸ĳɹ�!");
            }
            app_tpl::assign( 'option_proxy', array( 0 => '�ر�', 1 => '����') );
            app_tpl::assign( 'option_cc', array( 0 => '��ʹ��', 1 => '��ͨģʽ', 2 => '��ǿģʽ') );
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
            app_tpl::assign( 'npa', array('ϵͳ����', '������ȫ����') );
            if( ! empty( $_POST['config'] ) )
            {
                mod_config::set_security( $_POST['config'] );
                mod_login::message("�޸ĳɹ�!");
            }
            app_tpl::assign( 'option_proxy', array( 0 => '�ر�', 1 => '����') );
            app_tpl::assign( 'config', mod_config::get_security() );
            app_tpl::display( 'config_agent.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        } 
    }
}
