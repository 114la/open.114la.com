<?php
/**
 * 配置信息管理类
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: mod_config.php 68 2009-11-05 08:58:46Z syh $
 */

/**
 * 系统设置类
 */
 !defined('PATH_ADMIN') &&exit('Forbidden');
class mod_config
{
	/**
	 * 获取某个配置信息
	 */
	public static function get_one_config($key)
	{
		if (empty($key)) return false;
		$key = addslashes($key);

		$data = app_db::select('ylmf_config', 'yl_value', "yl_name = '{$key}'");
		return (empty($data)) ? false : $data[0]['yl_value'];
	}


	/**
	 * 读配置
	 *
	 * @param  array
	 * @return array
	 * @throws none
	 */
	public static function get_configs( $keys = array() )
	{
		$values = array ();

		foreach( $keys as $current_key )
		{
			app_db::query("select yl_value from `ylmf_config` where `yl_name` = '" . $current_key . "'");
			$current_row = app_db::fetch_one();
			$values[$current_key] = $current_row['yl_value'];
		}

		return $values;
	}


	/**
	 * 写配置
	 *
	 * @param  array
	 * @return none
	 * @throws none
	 */
	public static function set_configs( $configs = array() )
	{
		foreach( $configs as $current_key => $current_value )
		{
			if( false === strpos( $current_key, 'yl_' ) )
			{
				$current_key = 'yl_' . $current_key;
			}
			app_db::query("replace `ylmf_config` set `yl_value` = '" . $current_value . "', `yl_name` = '" . $current_key . "'");
		}
	}


	/**
	 * 获取基本设置
	 *
	 * @param  none
	 * @return array
	 * @throws none
	 */
	public static function get_basic()
	{
		$basic_keys = array ( 'yl_sysopen', 'yl_debug', 'yl_sysname', 'yl_sysurl', 'yl_path_html', 'yl_ceoconnect', 'yl_ceoemail', 'yl_icp', 'yl_icpurl', 'yl_ipstat', 'yl_lp', 'yl_obstart', 'yl_cvtime', 'yl_timedf', 'yl_datefm', 'yl_ifjump', 'yl_refreshtime', 'yl_ckpath', 'yl_ckdomain', 'yl_footertime', 'yl_metakeyword', 'yl_metadescrip', 'yl_mulindex', 'yl_ipstates', 'yl_isp', 'yl_enmemcache', 'yl_memcacheserver', 'yl_memcacheport', 'yl_sendemail', 'yl_sendemailtype', 'yl_formemail', 'yl_smtpserver', 'yl_smtpport', 'yl_smtpssl', 'yl_smtpauth', 'yl_smtpid', 'yl_smtppass', 'yl_display_update_info');
		return self::get_configs( $basic_keys );
	}
 

	/**
	 * 设置基本设置
	 *
	 * @param  array
	 * @return boolean
	 * @throws none
	 */
	public static function set_basic( $config )
	{
		self::set_configs( $config );
	}

	public static function get_info()
	{
		$basic_keys = array (  'yl_sysname', 'yl_sysurl', 'yl_ceoconnect', 'yl_ceoemail', 'yl_icp', 'yl_icpurl', 'yl_title', 'yl_metakeyword', 'yl_metadescrip', 'yl_ipstat' );
		return self::get_configs( $basic_keys );
	}

	public static function set_info( $config )
	{
		self::set_configs( $config );
	}

	public static function get_status()
	{
		$basic_keys = array ( 'yl_sysopen', 'yl_debug','yl_display_update_info' );
		return self::get_configs( $basic_keys );
	}

	public static function set_status( $config )
	{
		self::set_configs( $config );
	}

	public static function get_fn()
	{
		$basic_keys = array ( 'yl_lp', 'yl_obstart','yl_refreshtime', 'yl_ckpath', 'yl_ckdomain', 'yl_footertime', 'yl_display_update_info', 'yl_verify_code' );
		return self::get_configs( $basic_keys );
	}

	public static function set_fn( $config )
	{
		self::set_configs( $config );
	}

	public static function set_stat( $config )
	{
		self::set_configs( $config );
	}

	public static function get_mail()
	{
		$basic_keys = array ( 'yl_sendemail', 'yl_sendemailtype', 'yl_fromemail', 'yl_smtpserver', 'yl_smtpport', 'yl_smtpssl', 'yl_smtpauth', 'yl_smtpid', 'yl_smtppass');
		return self::get_configs( $basic_keys );
	}

	public static function set_mail( $config )
	{
		self::set_configs( $config );
	}

	public static function get_all( )
	{
		$basic_keys = array (  'yl_sysopen', 'yl_debug', 'yl_sysname', 'yl_sysurl', 'yl_path_html', 'yl_ceoconnect', 'yl_ceoemail', 'yl_icp', 'yl_icpurl', 'yl_ipstat', 'yl_lp', 'yl_obstart', 'yl_cvtime', 'yl_timedf', 'yl_datefm', 'yl_ifjump', 'yl_refreshtime', 'yl_ckpath', 'yl_ckdomain', 'yl_footertime', 'yl_title', 'yl_metakeyword', 'yl_metadescrip', 'yl_mulindex', 'yl_ipstates', 'yl_isp', 'yl_enmemcache', 'yl_memcacheserver', 'yl_memcacheport', 'yl_sendemail', 'yl_sendemailtype', 'yl_fromemail', 'yl_smtpserver', 'yl_smtpport', 'yl_smtpssl', 'yl_smtpauth', 'yl_smtpid', 'yl_smtppass', 'yl_display_update_info', 'yl_proxy', 'yl_loadavg', 'yl_cc', 'yl_verify_code');
		return self::get_configs( $basic_keys );
	}

	public static function set_all( $config )
	{
		self::set_configs( $config );
	}

	public static function set_cc( $config )
	{
		self::set_configs( $config );
	}
	/**
	 * 获取ip禁止列表
	 *
	 * @param  none
	 * @return string
	 * @throws none
	 */
	public static function get_ip_deny_list()
	{
		$configs = self::get_configs( array('yl_ipban') );
		$ip_deny_list = str_replace( ",", "\n", $configs['yl_ipban'] );
		return $ip_deny_list;
	}


	/**
	 * 设置ip禁止列表
	 *
	 * @param  string
	 * @return boolean
	 * @throws none
	 */
	public static function set_ip_deny_list( $ip_deny_list)
	{
		$ip_deny_list = str_replace( array("\r\n", "\n", "\r"), ",", $ip_deny_list );
		self::set_configs( array( 'yl_ipban' => $ip_deny_list) );
	}


	/**
	 * 获取安全设置
	 *
	 * @param  none
	 * @return array
	 * @throws none
	 */
	public static function get_security()
	{
		$security_keys = array ( 'yl_proxy', 'yl_loadavg', 'yl_cc' );
		return self::get_configs( $security_keys );
	}


	/**
	 * 设置安全设置
	 *
	 * @param  array
	 * @return boolean
	 * @throws none
	 */
	public static function set_security( $config )
	{
		self::set_configs( $config );
	}
}
?>
