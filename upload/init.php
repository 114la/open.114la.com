<?php
/**
 * ·����ʼ��
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
// ��վ�ľ���·�������������ļ�
defined('PATH_ROOT') || define('PATH_ROOT', rtrim(strtr(__FILE__, array('\\' => '/' , '/init.php' => '' , '\init.php' => '', '//' => '/')), '/'));
defined('ADMIN') || define('ADMIN', '/' . 'admin');
defined('PATH_ADMIN') || define('PATH_ADMIN', PATH_ROOT . ADMIN);


// ��ʼ��
require PATH_ADMIN . '/applications/app_init.php';
?>
