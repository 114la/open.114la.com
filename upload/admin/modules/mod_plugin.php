<?php
/**
 * Іејю№ЬАн
 * @since 2009-7-31
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_plugin
{
    public static function get_plugins_menu()
    {
        $dir = PATH_ROOT . '/tool/';
        $menu = array();

        if (is_dir($dir)) 
        {
            if ($dh = opendir($dir)) 
            {
                while (($subdir = readdir($dh)) !== false) 
                {
                    if( is_dir( $dir . $subdir) && $subdir != '.' && $subdir != '..' && file_exists( $dir.$subdir.'/function.php' ) &&  file_exists( $dir.$subdir.'/menu.php' ) )
                    {
                        require_once( $dir.$subdir.'/menu.php' );
                    }
                }
                closedir($dh);
            }
        }
        return $menu;

    }

    public static function plugin_do( $action, $plugin_name, $do )
    {
        $dir = PATH_ROOT . '/tool/' . $plugin_name;
        $func_name = $plugin_name . '_admin_' . $do . '_' . $action;
        if( is_dir( $dir ) )
        {
             require_once( $dir . '/function.php' );
             if( function_exists( $func_name ) )
             {
                 $func_name();
             }
        }
    }
}
