<?php
/**
 * 备份
 *
 * @since 2009-7-14
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_backup
{
    /**
     * 分卷大小
     * @var int
     */
    private static $size_limit = 4096;

    /**
     * 文件名前缀
     * @var int
     */
    private static $pre = '';

    /**
     * 开始备份的记录数
     * @var int
     */
    private static $start_row = 0;
    private static $start = 0;
    private static $start_from = 0;
    private static $step = 0;
    private static $table_id = 0;
    private static $stop = 0;
    private static $rows = 0;

    /**
     * URL(用于跳转)
     * @var unknown_type
     */
    private static $base_url = '?c=backup';


    /**
     * 显示需要备份的表
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('数据管理', '数据库备份') );
        	$output = array();
            $total_size = 0;
            $query = app_db::query('SHOW TABLE STATUS');

            $table_pre = $GLOBALS ['database'] ['table_prefix'];
            if (file_exists(PATH_DATA . '/lang/cp_lang_table.php'))
            {
                require PATH_DATA . '/lang/cp_lang_table.php';
                while ($table = app_db::fetch_one($query))
                {
                    if (!in_array(preg_replace("#^{$table_pre}#", 'ylmf_', $table['Name']), array_keys($table_use)))
                    {
                        continue;
                    }
                    $tmp = array();
                    $tmp['table_name'] = $table['Name'];
                    $tmp['zh_name'] = $table_use[preg_replace("#^{$table_pre}#", 'ylmf_', $table['Name'])];

                    $tmp['size'] = bytes_to_string($table['Data_length'] + $table['Index_length']);
                    $total_size += $table['Data_length'] + $table['Index_length'];
                    $output[] = $tmp;
                }
                $total_size = bytes_to_string($total_size); //数据库大小
                app_tpl::assign('list', $output);
                app_tpl::assign('total_size', $total_size);
            }
            app_tpl::display( 'backup.tpl' );
        }
        catch (Exception $e)
        {
            echo $e->Message();
        }
    }


    /**
     * 备份
     *
     * @return void
     */
	public static function backup()
	{
	    try
	    {
	        function_exists('set_time_limit') && set_time_limit(100);
	        $s = time();

    		$bak = "#\n# YLMF DVD bakfile\n" .
    		       "# Version:" . mod_config::get_one_config('yl_version') . "\n" .
                   "# Time: " .  get_date(time(), 'Y-m-d H:i') . "\n" .
                   "# Type: \n" .
                   "# YLMF: http://www.ylmf.com\n" .
    		       "# --------------------------------------------------------\n\n\n";

    		app_db::query("SET SQL_QUOTE_SHOW_CREATE = 0");

    		self::$start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
            $table_list = (empty($_POST['table_list'])) ? '' : $_POST['table_list'];
            $table_sel = (empty($_GET['table_sel'])) ? '' : $_GET['table_sel'];

            require PATH_DATA . '/lang/cp_lang_table.php';
            if (empty($table_list) && empty($table_sel))
            {
                throw new Exception('请选择需要备份的表', 10);
            }
            if (empty($table_list))
            {
                $table_list = explode('|', $table_sel);
            }

            if (empty($table_list))
            {
                throw new Exception('请选择需要备份的表', 10);
            }

            self::$size_limit = (empty($_REQUEST['size_limit'])) ? 0 : (int)$_REQUEST['size_limit'];
            self::$step = (empty($_GET['step'])) ? 0 : (int)$_GET['step'];

            self::$table_id = (empty($_GET['table_id'])) ? 0 : $_GET['table_id'];

            !self::$step && self::$size_limit /= 2;

            self::$pre = 'ylmf_' . get_date(time(), 'md') . '_' . randstr(10) . '_';

            // 备份非数据库的数据
            self::bakup_cache();

            // 备份表里的数据
            $bakup_data = self::bakup_data($table_list);

            // 备份表结构
            if (!self::$step)
            {
                $table_sel = implode('|', $table_list);
                self::$step = 1;
                self::$start = 0;
                $pre = self::$pre;
                $bakup_table = self::bakup_table($table_list);
            }
            $f_num = ceil(self::$step / 2);
            $filename = $pre . $f_num . '.sql';

            self::$step++;
            $write_data = (!empty($bakup_table)) ? $bakup_table . $bakup_data : $bakup_data;

         // $t_name = $table_list[self::$table_id - 1];
         // $c_n = $start_from;

            $filename = PATH_DATA . '/backup/' . $filename;
            if (self::$stop == 1)
            {
                $files = self::$step - 1;
                trim($write_data) && mod_file::write($filename, $bak . $write_data, 'ab');
                $j_url = self::$base_url . "a=backup&start=" . self::$start_from . "&table_id=" . self::$table_id .
                         "&size_limit=".self::$size_limit."&step=" . self::$step .
                         "&pre={$pre}&table_sel={$table_sel}&rows=" . self::$rows;

                mod_login::message('操作成功', $j_url);
          //      adminmsg('bakup_step', EncodeUrl($j_url),2);
            }
            else
            {
                trim($write_data) && mod_file::write($filename, $bak . $write_data, 'ab');
                $backup_file = '';
                if(self::$step > 1)
                {
                    for($i = 1; $i <= $f_num; $i++)
                    {
                        $backup_file .= '<a href ="' . ADMIN_URL . '/data/backup/' . $pre . $i . '.sql">' . $pre . $i . '.sql</a><br>';
                    }
                }
                mod_login::message('操作成功<br/>' . $backup_file, '?c=restore');
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }


    /**
     * 备份数据
     *
     * @param array $table_list
     * @param int $start
     * @return string
     */
    private static function bakup_data($table_list)
    {
        try
        {
            if (empty($table_list))
            {
                throw new Exception('请选择需要备份的表', 10);
            }

            self::$table_id = self::$table_id ? self::$table_id - 1 : 0;
            self::$stop = 0;

            $output = '';

            $table_count = count($table_list);
            for($i = self::$table_id; $i < $table_count; $i++)
            {
                // 表记录数
                $ts = app_db::query("SHOW TABLE STATUS LIKE '{$table_list[$i]}'");
                self::$rows = $ts['Rows'];

                $query = app_db::query("SELECT * FROM {$table_list[$i]} LIMIT " . self::$start . ', 100000');
                $num_field = mysql_num_fields($query);

                while ($data = mysql_fetch_row($query))
                {
                    self::$start++;
                    $output .= "INSERT INTO {$table_list[$i]} VALUES(" . "'" . mysql_escape_string($data[0]) . "'";

                    // 备份每个字段
                    $tempdb = '';
                    for ($j = 1; $j < $num_field; $j++)
                    {
                        $tempdb .= ",'" . mysql_escape_string($data[$j]) . "'";
                    }
                    $output .= $tempdb. ");\n";

                    if(self::$size_limit && strlen($output) > self::$size_limit * 1000)
                    {
                        break;
                    }
                }

                if(self::$start >= self::$rows)
                {
                    self::$start = 0;
                    self::$rows = 0;
                }

                $output .= "\n";
                if(self::$size_limit && strlen($output) > self::$size_limit * 1000)
                {
                    self::$start == 0 && $i++;
                    self::$stop = 1;
                    break;
                }
                self::$start = 0;
            }

            if(self::$stop == 1)
            {
                $i++;
                self::$table_id = $i;
                self::$start_from = self::$start;
                self::$start = 0;
            }
            return $output;
        }
        catch (Exception $e)
        {
            $message = $e->getMessage();

            return false;
        }

    }


    /**
     * 获取创建表的 SQL
     *
     * @param array $table_list
     * @return void
     */
    private static function bakup_table($table_list)
    {
        $output = '';
        if (!is_array($table_list) || empty($table_list))
        {
            return false;
        }
        foreach($table_list as $key => $table)
        {
            $output .= "DROP TABLE IF EXISTS {$table};\n";
            $tmp = app_db::query("SHOW CREATE TABLE {$table}");
            $tmp = app_db::fetch_one();
            $tmp['Create Table'] = str_replace($tmp['Table'], $table, $tmp['Create Table']);
            $output .= $tmp['Create Table'] . " COLLATE=gbk_chinese_ci;\n\n";
        }
        return $output;
    }

    /**
     * 备份非数据库数据
     * 
     * @param  void
     * @return void
     */
    private static function bakup_cache()
    {
        $pre = self::$pre;
        if(file_exists(PATH_DATA . '/cache/cache_famous_tab.php'))
        {
           @copy(PATH_DATA . '/cache/cache_famous_tab.php', PATH_DATA . '/backup/' . $pre . 'cache_famous_tab.php'); 
        }
        if(file_exists(PATH_DATA . '/cache/cache_index_tool.php'))
        {
           @copy(PATH_DATA . '/cache/cache_index_tool.php', PATH_DATA . '/backup/' . $pre . 'cache_index_tool.php'); 
        }
        if(file_exists(PATH_DATA . '/cache/cache_mztop.php'))
        {
           @copy(PATH_DATA . '/cache/cache_mztop.php', PATH_DATA . '/backup/' . $pre . 'cache_mztop.php'); 
        }
        if(file_exists(PATH_DATA . '/cache/cache_local_index.php'))
        {
           @copy(PATH_DATA . '/cache/cache_local_index.php', PATH_DATA . '/backup/' . $pre . 'cache_local_index.php'); 
        }
        if(file_exists(PATH_DATA . '/cache/cache_famous_loop.php'))
        {
           @copy(PATH_DATA . '/cache/cache_famous_loop.php', PATH_DATA . '/backup/' . $pre . 'cache_famous_loop.php'); 
        }
        if(file_exists(PATH_DATA . '/cache/cache_notice.php'))
        {
           @copy(PATH_DATA . '/cache/cache_notice.php', PATH_DATA . '/backup/' . $pre . 'cache_notice.php'); 
        }
    }
}
?>
