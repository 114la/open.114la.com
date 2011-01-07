<?php
/**
 * 登陆
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_auth
{
/**
 *  构造函数,自动检测登陆及权限
 */
	function __construct($is_admin=true)
	{

	}


	function index()
	{
		echo '-----';
	}

	/**
	 *  退出
	 */
	public function logout()
	{
		setcookie ( AUTH_KEY . '_auth', '', time () - 35920000, '/', PATH_COOKIE );
		$this->message("已经退出!","./index.php");
	}
}
?>
