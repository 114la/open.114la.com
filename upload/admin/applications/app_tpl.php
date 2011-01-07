<?php
/**
 * Smarty Ä£°åÒıÇæ
 *
 * @since 2009-7-9
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');
class app_tpl
{
	public static $instance = null;
	/**
	 * Smarty
	 *
	 * @return resource
	 */
	public static function init ($path = PATH_TPLS_ADMIN)
	{
		if (empty(self::$instance->template_dir) || $path != self::$instance->template_dir)
		{
			self::$instance = new Smarty();
			self::$instance->template_dir = path_exists($path);
			self::$instance->compile_dir = path_exists(PATH_TPLS_COMPILE);
			self::$instance->cache_dir = path_exists(PATH_TPLS_CACHE);

			self::$instance->left_delimiter = '<{';
			self::$instance->right_delimiter = '}>';
			self::$instance->caching = false;
			self::$instance->compile_check = true;
			self::$instance->security = true;
			self::$instance->security_settings['PHP_HANDLING'] = SMARTY_PHP_PASSTHRU;
			self::$instance->security_settings['ALLOW_CONSTANTS'] = true;
            
            //self::$instance->debugging = true;

       //     self::$instance->load_filter('output', 'trimwhitespace');
			self::config();

		}
		return self::$instance;
	}


	protected static function config ()
	{

		self::$instance->assign('URL', URL);
		self::$instance->assign('URL_HTML', URL_HTML);
		self::$instance->assign('ADMIN_URL', ADMIN_URL);
		self::$instance->assign('date_format', '%Y-%m-%d %H:%M');
		self::$instance->assign('date_format_ymd', '%Y-%m-%d');
	}


	public static function assign ($tpl_var, $value, $path = PATH_TPLS_ADMIN)
	{
		self::init($path);
        self::$instance->assign($tpl_var, $value);
	}



	public static function display($tpl, $path = PATH_TPLS_ADMIN)
	{
		$instance = self::init($path);
		$instance->display($tpl);
	}



	public static function fetch($tpl, $path = PATH_TPLS_ADMIN)
	{
		$instance = self::init($path);
		return $instance->fetch($tpl);
	}
}
?>
