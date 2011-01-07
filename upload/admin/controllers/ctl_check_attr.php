<?php
/**
 * 文件属性检查
 *
 * @since 2009-7-16
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_check_attr
{
/**
	 * 文件属性检查
	 *
	 * @return viod
	 */
	public static function index()
	{
		require PATH_DATA . '/conf/filepath.php';

		$filemode = array();
		foreach ($filepath as $key => $value)
		{
			if (!file_exists($value))
			{
				$attr = 1;
			}
			elseif (!is_writable($value))
			{
				$attr = 2;
			}
			else
			{
				$attr = 0;
			}
			$filemode[$key]['file'] = $value;
			$filemode[$key]['attr'] = $attr;
		}
	//	var_dump($filemode);
	}
}
?>