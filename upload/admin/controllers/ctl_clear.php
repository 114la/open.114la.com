<?php
/**
 * ������ݿ�
 *
 * @since 2009-7-15
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_clear
{
    /**
     * ȷ�ϲ���
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('���ݹ���', '�����������') );
            app_tpl::display('clear_confirm.tpl');
        }
        catch (Exception $e)
        {
        }
    }


    /**
     * ɾ��
     *
     * @return void
     */
	public static function delete()
	{
	    try
	    {
	        if (empty($_POST['action']) || $_POST['action'] != 'delete')
	        {
	            throw new Exception('ɾ��ʧ��', 10);
	        }

	        /**
	         * ɾ�����о�̬ HTML
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
             * ɾ����ҳ
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
             * ɾ��������
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
                    // ���ñ���û���ɾ��
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
             * ɾ���ǳ�������Ա
             */
            app_db::delete('ylmf_admin_user', 'level = 0');

            /*
             * ɾ����վ�ֲ�
             */
            /*
            mod_file::rm(PATH_DATA . '/db/' . mod_famous_loop_play::DB_FILENAME);
            */


	    	// �������(������վ���У���վͷ����ǩ����ҳ���Ͻǹ��ߣ��ط�������ҳվ������)
	    	mod_cache::empty_all_cache();

            mod_login::message('ɾ���ɹ�', '?c=clear');
	    }
	    catch (Exception $e)
	    {
            mod_login::message($e->getMessage(), '?c=clear');
	    }
	}
}
?>
