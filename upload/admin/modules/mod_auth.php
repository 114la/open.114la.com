<?php

/**
 * Ȩ�޿���
 * @desc
 *          1.smarty���ñ���
 *          2.Ȩ�޿���,��½���,POST��֤
 *
 */
 !defined('PATH_ADMIN') &&exit('Forbidden');
class mod_auth
{
	public static $instance=null;
	function __construct()
	{
		$auth = mod_login::instance();
		if(!$auth->is_login())//���Զ���ת

		{
			header("location: ./index.php?c=login");
		}
	}
	public static function instance()
	{
		if(self::$instance===null)
		{
			self::$instance=new mod_auth;
//                        $main_menu=mod_login::main_header();
//                        app_tpl::assign('menu_main', $main_menu);
		}
		return self::$instance;
	}

}








?>