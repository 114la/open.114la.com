<?php
/**
 * 路径初始化
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
// 网站的绝对路径，用于载入文件
defined('PATH_ROOT') || define('PATH_ROOT', rtrim(strtr(__FILE__, array('\\' => '/' , '/init.php' => '' , '\init.php' => '', '//' => '/')), '/'));
defined('ADMIN') || define('ADMIN', '/' . 'admin');
defined('PATH_ADMIN') || define('PATH_ADMIN', PATH_ROOT . ADMIN);


// 初始化
require PATH_ADMIN . '/applications/app_init.php';
?>
