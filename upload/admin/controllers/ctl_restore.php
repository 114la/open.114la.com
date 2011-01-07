<?php
/**
 * 数据恢复
 *
 * @since 2009-7-17
 * @copyright http://www.114la.com
 */

!defined('PATH_ADMIN') &&exit('Forbidden');
class ctl_restore
{
    private $base_url = '?c=restore';

    /**
     * 显示备份文件
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('数据管理', '数据库还原') );
            $list = array();
            $handle = opendir(PATH_DATA . '/backup');
            while($file = readdir($handle))
            {
                if(preg_match('#^ylmf_#i', $file) && preg_match('#\.sql$#i', $file))
                {
                    $strlen = 20;
                    $fp = fopen(PATH_DATA . "/backup/$file", 'rb');
                    $bakinfo = fread($fp, 200);
                    fclose($fp);
                    $detail = explode("\n", $bakinfo);

                    $bk = array();
                    $bk['name'] = $file;
                    $bk['version'] = substr($detail[2], 10);
                    $bk['time'] = substr($detail[3], 8);
                    $bk['pre'] = substr($file, 0, strrpos($file, '_'));
                    $bk['num'] = substr($file, strrpos($file, '_') + 1, strrpos($file, '.') - 1 - strrpos($file, '_'));
                    $list[] = $bk;
                }
            }

            app_tpl::assign('list', $list);
            app_tpl::display( 'restore.tpl' );
        }
        catch (Exception $e)
        {
            echo   $e->getMessage();
        }
    }


	/**
     * 恢复
     *
     * @return void
     */
    public static function restore()
    {
        try
        {
            function_exists('set_time_limit') && set_time_limit(100);

            $count = (empty($_GET['count'])) ? 0 : (int)$_GET['count'];
            $step = (empty($_GET['step'])) ? 0 : (int)$_GET['step'];
            $pre = (empty($_GET['pre'])) ? '' : $_GET['pre'];
            if (empty($pre))
            {
                throw new Exception('操作失败', 10);
            }

            $start = time();
            if(!$count)
            {
                $count = 0;
                $handle = opendir(PATH_DATA . '/backup');
                while($file = readdir($handle))
                {
                    if(preg_match("#^$pre#i", $file) && preg_match("#\.sql$#i", $file))
                    {
                        $count++;
                    }
                }
            }
            !$step && $step = 1;

            //echo PATH_DATA . "/backup/{$pre}_{$step}.sql";
            self::restore_data(PATH_DATA . "/backup/{$pre}_{$step}.sql");
            $i = $step;
            $step++;

            if($count > 1 && $step <= $count)
            {
                $j_url = self::$base_url . "&a=restore&step={$step}&count={$count}&pre={$pre}";

                adminmsg('bakup_in',EncodeUrl($j_url),2);
            }

            if(file_exists(PATH_DATA . '/backup/' . $pre . '_cache_famous_tab.php'))
            {
               @copy(PATH_DATA . '/backup/' . $pre . '_cache_famous_tab.php', PATH_DATA . '/cache/cache_famous_tab.php'); 
            }
            if(file_exists(PATH_DATA . '/backup/' . $pre . '_cache_index_tool.php'))
            {
               @copy(PATH_DATA . '/backup/' . $pre . '_cache_index_tool.php', PATH_DATA . '/cache/cache_index_tool.php'); 
            }
            if(file_exists(PATH_DATA . '/backup/' . $pre . '_cache_mztop.php'))
            {
               @copy(PATH_DATA . '/backup/' . $pre . '_cache_mztop.php', PATH_DATA . '/cache/cache_mztop.php'); 
            }
            if(file_exists(PATH_DATA . '/backup/' . $pre . '_cache_local_index.php'))
            {
               @copy(PATH_DATA . '/backup/' . $pre . '_cache_local_index.php', PATH_DATA . '/cache/cache_local_index.php'); 
            }

            if(file_exists(PATH_DATA . '/backup/' . $pre . '_cache_famous_loop.php'))
            {
               @copy(PATH_DATA . '/backup/' . $pre . '_cache_famous_loop.php', PATH_DATA . '/cache/cache_famous_loop.php'); 
            }
            if(file_exists(PATH_DATA . '/backup/' . $pre . '_cache_notice.php'))
            {
               @copy(PATH_DATA . '/backup/' . $pre . '_cache_notice.php', PATH_DATA . '/cache/cache_notice.php'); 
            }
            mod_cache::update_all_cache();

            //echo '<hr/>', time() - $start;
            mod_login::message("恢复成功!");
        }
        catch (Exception $e)
        {
            echo   $e->getMessage();
        }
    }


    /**
     * 确认恢复
     *
     * @return void
     */
    public static function confrim_restore()
    {
        try
        {

            app_tpl::dispaly('#');
        }
        catch (Exception $e)
        {
            echo   $e->getMessage();
        }
    }


    /**
     * 删除备份文件
     *
     * @return void
     */
    public static function delete_backup_file()
    {
        try
        {
            $file = (empty($_POST['file'])) ? '' : $_POST['file'];
            if (empty($file))
            {
                throw new Exception('请选择需要删除的备份文件', 10);
            }

            foreach ($file as $key => $value)
            {
                if(preg_match('/\.sql$/', $value))
                {
                    mod_file::rm(PATH_DATA . "/backup/{$value}");
                }
            }
            mod_login::message("删除成功!");

        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }


    /**
     * 恢复文件
     *
     * @param string $filename
     * @return boolean
     */
    private static function restore_data($filename)
    {
        if (!file_exists($filename))
        {
            throw new Exception('文件不存在', 10);
        }

        $charset = $GLOBALS ['database'] ['db_charset'];
        $sql = file($filename);
        $query = '';
        $num = 0;

        foreach($sql as $key => $value)
        {
            $value = trim($value);
            if(empty($value) || $value[0] == '#')
            {
                continue;
            }
            if(preg_match('#\;$#i', $value))
            {
                $query .= $value;
                if(preg_match("#^CREATE#i", $query))
                {
                    $extra = substr(strrchr($query, ')'), 1);
                    $tabtype = substr(strchr($extra, '='), 1);
                    $tabtype = substr($tabtype, 0, strpos($tabtype, strpos($tabtype, ' ') ? ' ' : ';'));
                    $query = str_replace($extra, ' ', $query);
                    if (app_db::server_info() > '4.1')
                    {
                        $extra = $charset ? "ENGINE={$tabtype} DEFAULT CHARSET={$charset} COLLATE=gbk_chinese_ci;" : "ENGINE={$tabtype};";
                    }
                    else
                    {
                        $extra = "TYPE={$tabtype};";
                    }
                    $query .= $extra;
                }
                elseif (preg_match("#^INSERT#i", $query))
                {
                    $query = 'REPLACE ' . substr($query, 6);
                }
                app_db::query($query);
                $query = '';
            }
            else
            {
                $query .= $value;
            }
        }
    }
}
?>
