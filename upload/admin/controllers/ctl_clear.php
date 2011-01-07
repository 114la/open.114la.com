<?php
/**
 * 清空数据库
 *
 * @since 2009-7-15
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_clear
{
    /**
     * 确认操作
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('数据管理', '清空所有数据') );
            app_tpl::display('clear_confirm.tpl');
        }
        catch (Exception $e)
        {
        }
    }


    /**
     * 删除
     *
     * @return void
     */
	public static function delete()
	{
	    try
	    {
	        if (empty($_POST['action']) || $_POST['action'] != 'delete')
	        {
	            throw new Exception('删除失败', 10);
	        }

	        /**
	         * 删除所有静态 HTML
	         */
    	    $rt = app_db::select('ylmf_class', 'classid', 'parentid = 0');
    		if (!empty($rt))
    		{
        		$pid = '';
        	    foreach ($rt as $row)
        	    {
        	        $pid .= $row['classid'] . ',';
        	    }
        	    unset($rt);
        	    $pid = substr($pid, 0, -1);

        	    $rs = app_db::select('ylmf_class', 'path', "parentid IN ({$pid})");
        	    if (!empty($rs))
        	    {
                    foreach ($rs as $class)
                    {
                        if(file_exists(PATH_HTML . '/' . $class['path']))
                        {
                            mod_file::rm_recurse(PATH_HTML . '/' . $class['path']);
                        }
                    }
        	    }
    		}
            if (file_exists(PATH_HTML . '/catalog'))
            {
                mod_file::rm(PATH_HTML . '/catalog');
            }
            if (file_exists(PATH_HTML . '/local'))
            {
                mod_file::rm(PATH_HTML . '/local');
            }
            if (file_exists(PATH_HTML . '/trade_sites.htm'))
            {
                mod_file::rm(PATH_HTML . '/trade_sites.htm');
            }

            /*
             * 删除首页
             */
	        $yl_mulindex = mod_config::get_one_config('yl_mulindex');
        	if (!empty($yl_mulindex))
        	{
        		foreach (explode('|',$yl_mulindex) as $indexname)
        		{
        		    if (file_exists(PATH_ROOT . '/' . $indexname))
        		    {
        			    mod_file::rm(PATH_ROOT . '/' . $indexname);
        		    }
        		}
        	}
            if (is_writable(PATH_ROOT))
            {
                if (file_exists(PATH_ROOT . '/index.html'))
                {
                    mod_file::rm(PATH_ROOT . '/index.html');
                }
                if (file_exists(PATH_ROOT . '/index.htm'))
                {
                    mod_file::rm(PATH_ROOT . '/index.htm');
                }
            }

            if (file_exists(PATH_ROOT . '/static/js'))
            {
                mod_file::rm(PATH_ROOT . '/static/js');
            }
           

            /*
             * 删除表数据
             */
            $table_pre = $GLOBALS['database']['table_prefix'];
            $query = app_db::query("SHOW TABLE STATUS ");
            $table = array();

            if (!empty($query))
            {
                while ($rt = app_db::fetch_one($query))
                {
                    if (!preg_match("#^{$table_pre}#", trim($rt['Name'])))
                    {
                        continue;
                    }
                    // 配置表和用户表不删除
                    if (trim($rt['Name']) == $table_pre . 'config' || trim($rt['Name']) == $table_pre . 'admin_user')
                    {
                        continue;
                    }

                    $table = $rt['Name'];
                    if ($table == $table_pre . 'toolclass')
                    {
                        app_db::delete($table, "`type` != 'keyword'");
                    }
                    else
                    {
                        app_db::delete($table, '1');
                    }
                }
            }

            /**
             * 删除非超级管理员
             */
            app_db::delete('ylmf_admin_user', 'level = 0');

            /*
             * 删除名站轮播
             */
            /*
            mod_file::rm(PATH_DATA . '/db/' . mod_famous_loop_play::DB_FILENAME);
            */


	    	// 清除缓存(包括名站首行，名站头部标签，首页右上角工具，地方服务首页站点数据)
	    	mod_cache::empty_all_cache();

            mod_login::message('删除成功', '?c=clear');
	    }
	    catch (Exception $e)
	    {
            mod_login::message($e->getMessage(), '?c=clear');
	    }
	}
}
?>
