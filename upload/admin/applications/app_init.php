<?php
!defined('PATH_ADMIN') && exit('Forbidden');
@session_save_path(PATH_ADMIN.'/data/session');
@session_start();

//PHP错误日志
ini_set('error_log', PATH_ADMIN.'/data/log/php_error.log');// PHP错误记录日志
ini_set('log_errors', '1');

(empty($_SERVER['PHP_SELF'])) && $_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];

if(!isset($_SERVER['DOCUMENT_ROOT']))
{
    if(isset($_SERVER['SCRIPT_FILENAME']))
    {
        $_SERVER['DOCUMENT_ROOT'] = strtr(substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF'])), array('\\' => '/'));
    }
}
if(!isset($_SERVER['DOCUMENT_ROOT']))
{
    if(isset($_SERVER['PATH_TRANSLATED']))
    {
        $_SERVER['DOCUMENT_ROOT'] = strtr(substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0-strlen($_SERVER['PHP_SELF'])), array('\\' => '/'));
    }
}
$_SERVER['DOCUMENT_ROOT'] = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

//防止变量覆盖
foreach($_REQUEST as $_k=>$_v)
{
    if( strlen($_k)>0 && preg_match('/^(cfg_|GLOBALS)/i', $_k) )
    {
        exit('Request var not allow!');
    }
}

// 自动转义
if (! get_magic_quotes_gpc() && @function_exists(auto_addslashes)) 
{
	auto_addslashes($_POST);
	auto_addslashes($_GET);
	auto_addslashes($_COOKIE);
	auto_addslashes($_REQUEST);
}

// 加载常量
require PATH_ADMIN . '/config/cfg_constants.php';

require PATH_CONFIG . '/cfg_database.php';

require PATH_APPLICATION . '/app_router.php';
require PATH_APPLICATION . '/app_db.php';
require PATH_MODULE . '/smarty/Smarty.class.php';
require PATH_APPLICATION . '/app_tpl.php';
// 加载函数库
require PATH_APPLICATION . '/app_common_function.php';

//defined('DEBUG_LEVEL') || define('DEBUG_LEVEL', mod_config::get_one_config('yl_debug'));
define('DEBUG_LEVEL', true);
// 错误控制
if (defined('DEBUG_LEVEL') && DEBUG_LEVEL == true) {
	error_reporting(E_ALL ^ E_NOTICE);
} else {
	error_reporting(0);
}
//error_reporting(0);

// 设置时区
// function_exists('date_default_timezone_set') && date_default_timezone_set('Asia/Shanghai');

// 重设最大内存
ini_set('memory_limit', '32M');


// 静态 HTML 目录
defined('STATIC_HTML') || define('STATIC_HTML', mod_config::get_one_config('yl_path_html'));
// 静态 HTML
defined('HOST') || define('HOST', 'http://' . $_SERVER['HTTP_HOST']);
$path_info = pathinfo($_SERVER['PHP_SELF']);
$path_x = rtrim(strtr(dirname($path_info['dirname']), array('\\' => '/')), '/');
defined('URL') || define('URL', 'http://' . $_SERVER['HTTP_HOST'] . $path_x);
defined('ADMIN') || define('ADMIN', rtrim(dirname($_SERVER['PHP_SELF']), '/'));
defined('ADMIN_URL') || define('ADMIN_URL', rtrim(URL . ADMIN, '/'));
defined('PATH_HTML') || define('PATH_HTML', PATH_ROOT . STATIC_HTML);
defined('URL_HTML') || define('URL_HTML', rtrim(URL . STATIC_HTML, '/'));

defined('VERIFY_CODE')||define('VERIFY_CODE',mod_config::get_one_config('yl_verify_code'));
//COOKIE相关
defined('AUTH_KEY') || define('AUTH_KEY', '114la');

// 分页
defined('PAGE_ROWS') || define('PAGE_ROWS', 20);

defined('PATH_COOKIE') || define('PATH_COOKIE',  '/');
!is_dir(PATH_HTML) && mod_file::mkdir_recursive(PATH_HTML, 0777);
?>
