<?php
/**
 * 插件管理
 *
 * @since      2009-7-31
 * @copyright  http://www.114la.com
 * @package    controller
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_plugin
{
    public function index()
    {
        app_tpl::assign( 'npa', array('插件管理', '插件设置') );
    }

    public function edit()
    {
    }

    public function del()
    {
    }

    public function post()
    {
        $plugin_name = $_GET['p'];
        $do = $_GET['do'];
        $action = empty($_GET['a']) ? 'index' : trim($_GET['a']);
        mod_plugin::plugin_do( $action, $plugin_name, $do );
        $tpl_dir = PATH_ROOT . '/tool/' . $plugin_name . '/tpls/';
        $tpl = 'admin_' . $do . '_' . $action . '.tpl'; 
        app_tpl::assign( 'plugin_tpl', $tpl_dir . $tpl );
        app_tpl::display( 'plugin.tpl' );
    }
}
