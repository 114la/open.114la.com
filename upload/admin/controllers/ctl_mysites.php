<?php
/**
 * 114啦 网址导航系统
 *
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    control
 * @version    $Id: ctl_mysites.php 1574 2009-12-24 09:57:08Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class ctl_mysites
{
    public static function index()
    {
        try
        {
            ini_set('max_execution_time', 0);
            $update_ok = false;
            if( isset( $_FILES['data_file'] ) && $_FILES['data_file']['error'] === UPLOAD_ERR_OK )
            {
                $update_ok = true;
            }
            if( $update_ok )
            {
                $zip_file = PATH_DATA . '/tmp/tmp.zip';
                move_uploaded_file($_FILES['data_file']['tmp_name'], $zip_file);

                require PATH_MODULE . '/mod_pclzip.php';
                $zip = new PclZip($zip_file);
                $result = $zip->extract(PATH_DATA . '/tmp');
                if (empty($result[0]['filename']))
                {
                    app_tpl::assign( 'error', '数据导入失败 ' );
                }

                $sql_file = $result[0]['filename'];
                if (false == mod_mysites_import::data_import($sql_file))
                {
                    app_tpl::assign( 'error', '数据导入失败 ' );
                }
                mod_file::rm($sql_file);
                mod_mysites_import::data_move();
                mod_mysites_import::clean_up();
                mod_cache::update_all_cache();
                mod_cache::set_cache('cache_class_layer_4', mod_cache::get_cache('cache_class_layer_3'));
                mod_config::set_configs( array( 'yl_honghe' => 1 ) );
                mod_make_html::make_html_whole_site();
                app_tpl::assign( 'error', '数据导入成功! ' );
            }
            app_tpl::display( 'mysites.tpl' );
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
