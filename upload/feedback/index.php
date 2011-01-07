<?php
/**
 * Òâ¼û·´À¡
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
require '../init.php';

try
{
    $dir_tpls_main = mod_config::get_one_config('yl_dirtplmain');
    empty($dir_tpls_main) && $dir_tpls_main = 'default';
    $path_tpls_main = PATH_TPLS_MAIN . '/' . $dir_tpls_main;
    app_tpl::assign('sysname', mod_config::get_one_config('yl_sysname'), $path_tpls_main);
    app_tpl::assign('icp', mod_config::get_one_config('yl_icp'), $path_tpls_main);
    app_tpl::display('feedback.tpl', $path_tpls_main);
}
catch (Exception $e)
{
}
