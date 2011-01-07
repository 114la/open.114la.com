<?php
/**
 * 优化表
 *
 * @since 2009-7-14
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_repair
{
    /**
     * 显示所有表
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('数据管理', '数据库优化修复') );
            if (file_exists(PATH_DATA . '/lang/cp_lang_table.php'))
            {
                require PATH_DATA . '/lang/cp_lang_table.php';
                $totalsize = 0;
                app_db::query("SHOW TABLE STATUS ");

                $table_pre = $GLOBALS ['database'] ['table_prefix'];

                $table_list = array();
                while ($table = app_db::fetch_one())
                {
                    if (!in_array(preg_replace("#^{$table_pre}#", 'ylmf_', $table['Name']), array_keys($table_use)))
                    {
                        continue;
                    }

                    $table['zh_name'] = $table_use[preg_replace("#^{$table_pre}#", 'ylmf_', $table['Name'])];
                	$table['size'] = bytes_to_string($table['Data_length'] + $table['Index_length']);
                    $totalsize += $table['Data_length'] + $table['Index_length'];
                    $table['Data_length'] = bytes_to_string($table['Data_length']);
                    $table['Index_length'] = bytes_to_string($table['Index_length']);
                    $table_list[] = $table;
                }
                app_tpl::assign('total_size', bytes_to_string($totalsize)); //数据库大小
                app_tpl::assign('list', $table_list);
            }
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('repair.tpl');
    }


    public static function doit()
    {
        try
        {
            if (!empty($_POST['table_list']) && !empty($_POST['do']))
            {
               $table = implode(',', $_POST['table_list']);

                if ($_POST['do'] == 'repair')
                {
                    $query = app_db::query("REPAIR TABLE {$table} ");
                }
                elseif ($_POST['do'] == 'optimize')
                {
                    $query = app_db::query("OPTIMIZE TABLE $table");
                }

                $msg_list = '';
                while($rt = app_db::fetch_one())
                {
                    $rt['Table'] = substr(strrchr($rt['Table'] , '.'), 1);
                    $msg_list .= '<strong>' . $rt['Table'] . '</strong>: ' . $rt['Msg_text'] . '<br/>';
                }
                mod_login::message($msg_list, '?c=repair', 10000);
            }
            else
            {
                throw new Exception('请选择表');
            }

        }
        catch (Exception $e)
        {
            mod_login::message($e->getMessage(), '?c=repair');
        }
    }
}
?>
