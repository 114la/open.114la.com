<?php
/**
 * ��½
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_auth
{
/**
 *  ���캯��,�Զ�����½��Ȩ��
 */
	function __construct($is_admin=true)
	{

	}


	function index()
	{
		echo '-----';
	}

	/**
	 *  �˳�
	 */
	public function logout()
	{
		setcookie ( AUTH_KEY . '_auth', '', time () - 35920000, '/', PATH_COOKIE );
		$this->message("�Ѿ��˳�!","./index.php");
	}
}
?>
