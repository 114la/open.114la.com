<?php
/**
 * �����������
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_feedback
{
    /**
     * �б�
     *
     * @return void
     */
	public static function index()
	{
	    try
	    {
            app_tpl::assign( 'npa', array('������ҳ', '�������') );
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
          //  $total = mod_feedback::get_total();

            $result = mod_feedback::get_list($start, PAGE_ROWS);
            if (!empty($result))
            {
                app_tpl::assign('list', $result['data']);
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
                app_tpl::assign('page_url', '?c=feedback');

                app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            }
	    }
	    catch (Exception $e)
	    {

	    }
        app_tpl::display('feedback_list.tpl');
	}


	/**
	 * ��ʾһ�����
	 *
	 * @return viod
	 */
	public static function show()
	{
	    try
	    {
            app_tpl::assign( 'npa', array('������ҳ', '�������') );
    	    $fid = (empty($_GET['id'])) ? 0 : (int)$_GET['id'];
    	    if ($fid < 1)
    	    {
    	    	throw new Exception('����ʧ��');
    	    }

            app_tpl::assign('data', mod_feedback::get_one($fid));
            app_tpl::assign('referer', (empty($_SERVER['HTTP_REFERER'])) ? '?c=feedback' : $_SERVER['HTTP_REFERER']);
	    }
	    catch (Exception $e)
	    {
	        app_tpl::assign('error', $e->getMessage());
	    }
	    app_tpl::display('feedback_show.tpl');
	}


	/**
	 * �б�༭
	 *
	 * @return void
	 */
	public static function list_edit()
	{
		try
		{
		    $referer = (empty($_POST['referer'])) ? '?c=feedback' : $_POST['referer'];

		    if (!empty($_POST['delete']))
		    {
                $condition = '';
                foreach ($_POST['delete'] as $key => $val)
                {
                    $key = (int)$key;
                    $condition .= (empty($condition)) ? $key : ", {$key}";
                }
                app_db::delete('ylmf_feedback', "fid IN ($condition)");

                mod_login::message('ɾ���ɹ�', $referer);
		    }
		    else
		    {
		        mod_login::message('��ѡ����Ҫɾ������', $referer);
		    }
		}
		catch (Exception $e)
		{
		}
	}
}
