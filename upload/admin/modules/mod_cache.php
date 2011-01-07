<?php
/**
 * 缓存管理类
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: mod_cache.php 1600 2010-04-28 02:44:59Z syh $
 */

!defined('PATH_ADMIN') &&exit('Forbidden');

class mod_cache
{
	/**
	 * 读缓存
	 *
	 * @param $cache_name string
	 * @return array
	 * @throws none
	 */
	public static function get_cache( $cache_name )
	{
		$file_path = PATH_DATA . '/cache/' . $cache_name . '.php';
		if( file_exists( $file_path ) )
		{
			return unserialize(mod_file::read( $file_path ));
		}
		return false;
	}//end function get_cache()


	/**
	 * 写缓存
	 *
	 * @param $cache_name string
	 * @param $data array
	 * @return none
	 * @throws none
	 */
	public static function set_cache( $cache_name, $data = array() )
	{
		$file_path = PATH_DATA . '/cache/' . $cache_name . '.php';
        $cache_content = str_replace(array('<?', '?>'), '  ', serialize($data));
		mod_file::write( $file_path, $cache_content );
	}//end function set_cache()


	/**
	 * 清空所有缓存
	 *
	 * @param none
	 * @return none
	 * @throws none
	 */
	public static function empty_all_cache()
	{
        if( $dh = opendir( PATH_DATA . '/cache' ) )
        {
            while( false !== ( $file = readdir() ) )
            {
                if( $file != '.' && $file != '..' && $file != '.svn' )
                {
                    $cache_content = serialize(array());
                    $file_path = PATH_DATA . '/cache/' . $file;
                    mod_file::write( $file_path, $cache_content );
                }
            }
        }
        
	}//end function empty_all_cache()


	public static function empty_some_cache( $cache_name = '' )
	{
        if( empty($cache_name) )
        {
            return false;
        }
        if( $dh = opendir( PATH_DATA . '/cache' ) )
        {
            while( false !== ( $file = readdir() ) )
            {
                if( strpos($file, $cache_name) !== false )
                {
                    $cache_content = serialize(array());
                    $file_path = PATH_DATA . '/cache/' . $file;
                    mod_file::write( $file_path, $cache_content );
                }
            }
        }
        
	}//end function empty_all_cache()

	/**
	 * 更新所有缓存
	 *
	 * @return array
	 */
	public static function update_all_cache()
	{
		mod_advert::update_cache_main_advert(); // 广告
		mod_plan::update_cache_admin_plan(); // 任务计划
		mod_class::update_cache_main_class(); //分类
		mod_advert::update_cache_advert_js(); //生成静态广告js
		mod_class::update_cache_class_tree(); //网站分类树
	}

}
?>
