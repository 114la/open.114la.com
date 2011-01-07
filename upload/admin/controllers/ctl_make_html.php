<?php
/**
 * ��վ��̬��
 *
 * @since 2009-7-9
 * @copyright http://www.114la.com
 * @version    $Id: ctl_make_html.php 1318 2009-11-30 01:05:43Z cjb $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_make_html
{
	/**
	  * ���ɾ�̬ҳ��
	  *
	  * @return viod
	  */
	public static function index()
	{
		try
		{
            app_tpl::assign( 'npa', array('��̬����', 'һ������') );
			$action = (empty($_GET['action'])) ? '' : $_GET['action'];

			if($action == 'make')
			{
			    $make = (empty($_POST['make'])) ? '' : $_POST['make'];
			    if (empty($make))
			    {
			        throw new Exception('��ѡ����Ҫ���ɾ�̬ҳ���ѡ��');
			    }
                app_tpl::$instance->compile_id = mod_config::get_one_config('yl_dirtplmain');
                app_tpl::$instance->clear_compiled_tpl("index.tpl", '', app_tpl::$instance->compile_id);
			    @ob_start();
			    function_exists('set_time_limit') && set_time_limit(600);

			    $msg = <<<BOT
			    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title></title>
<link href="static/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="static/js/common.js"></script>
</head>
<body id="main_page">
<div class="wrap">
    <div class="container">
        <div id="main" style="padding: 10px;">
BOT;
                mod_make_html::flush($msg);

			    $ok = '<span style="color: green;">�ɹ�</span><br/>';

			    mod_make_html::flush('���ڸ������л��桭��');
			    mod_cache::update_all_cache();
			    mod_make_html::flush($ok);

			    $old = $make;
			    $make = array();
			    foreach ($old as $k => $v)
			    {
			        $make[stripslashes($k)] = true;
			    }

				// ������ҳ
				if (!empty($make['index']) || !empty($make['all']))
				{
                    mod_make_html::flush('����������ҳ����');
				    mod_make_html::make_html_index();
				    mod_make_html::flush($ok);
				}


				// ���ɷ��ർ��ҳ��
				if (!empty($make['catalog']) || !empty($make['all']))
				{
				    mod_make_html::flush('�������ɷ��࡭��<br/>');
				    mod_make_html::$show_process = true;
				    mod_make_html::make_html_all_catalog();
				}

      			// ����ר��ҳ��
				if (!empty($make['zhuanti']) || !empty($make['all']))
				{
				    mod_make_html::flush('<br/>��������ר�⡭��');
				    mod_make_html::make_html_zhuanti();
				    mod_make_html::make_html_trade();
				    mod_make_html::make_html_local();
				    mod_make_html::flush($ok);
				}

				// ��������ҳ��
				if (!empty($make['other']) || !empty($make['all']))
				{
				    mod_make_html::flush('��������ҳ�桭��');
				    mod_make_html::make_html_other();
				    mod_make_html::flush($ok);
				}

				!empty($message) && $message = substr($message, 0, -2);

                mod_make_html::flush('<br/><br/><p style="color:#4D5D2C; font-size:14px;">&nbsp;&nbsp;&nbsp;<strong id="seconds" style="color:#f60;">3</strong> ��󽫷���<a style="color:#f60;" href="?c=make_html">һ������ģ��</a>�������������������ת������&nbsp;&nbsp;<a href="?c=make_html" style="color:#f60;">����</a></p>');

				$msg = '<script type="text/javascript">
						var i = 3;
						var reTime = setInterval(function(){
							i = i-1;
							if(i<0){
								
								window.location.href= "?c=make_html";
								window.clearInterval(reTime);
								return;
								
							}
							document.getElementById("seconds").innerHTML = i;
						},1000);
                    </script></div></div></div></body></html>';
				mod_make_html::flush($msg);
				//mod_login::message('�����ɹ�', '?c=make_html');
				exit;
			}
			else
			{

			}
		}
		catch(Exception $e)
		{
			app_tpl::assign('error', $e->getMessage());
		}
		app_tpl::display('make_html_all.tpl');
	}


	/**
	 * �Զ������
	 *
	 * @return void
	 */
	public static function catalog()
	{
        try
        {
            if (!isset($_POST['class_id']))
            {
                $class_id = (empty($_GET['classid'])) ? 0 : $_GET['classid'];

                app_tpl::assign('class_list', mod_class::get_cache_class_options());
                app_tpl::assign('class_id', mod_class::get_class_path($class_id));
            }
            else
            {
                $class_id = explode(',', $_POST['class_id']);
                $class_id = !empty($class_id[1]) ? $class_id[1] : $class_id[0];
                if ($class_id < 1)
                {
                    mod_login::message('����ʧ��', '?c=make_html&a=catalog');
                }

                if (true == mod_make_html::make_html_one_catalog($class_id))
                {
                    $main_class_cache = mod_class::get_cache_main_class();
                    mod_login::message($main_class_cache[$class_id]['classname'] . '�������ɳɹ�', '?c=make_html&a=catalog');
                }
                else
                {
                }
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('make_html_catalog.tpl');
	}


	/**
	 * ����
	 *
	 * @return void
	 */
	public static function set()
	{
	    try
	    {
            app_tpl::assign( 'npa', array('��̬����', '��̬��������') );
	        if (!isset($_POST['path_html']))
	        {
                app_tpl::assign('real_time', mod_config::get_one_config('yl_make_html_realtime'));
                app_tpl::assign('path_html', mod_config::get_one_config('yl_path_html'));
	        }
	        else
	        {
	            $config_key = mod_make_html::READTIME_UPDATE_KEY;

                $real_time = (int)$_POST['real_time'];
                $tmp = app_db::select('ylmf_config', '*', 'yl_name="' . $config_key . '"');
                if (empty($tmp))
                {
                    app_db::insert('ylmf_config', array('yl_name', 'yl_value'), array($config_key, $real_time));
                }
                else
                {
                    app_db::update('ylmf_config', array('yl_value' => $real_time), "yl_name = '{$config_key}'");
                }

                if( isset($_POST['path_html']) )
                {
                    $path_html = trim($_POST['path_html']);
                    if( $path_html{0} != '/')
                    {
                        $path_html = '/' . $path_html;
                    }
                    mod_config::set_configs( array('path_html' => $path_html ) );
                }
                app_tpl::assign('real_time', $real_time);
                app_tpl::assign('path_html', mod_config::get_one_config('yl_path_html'));
                mod_login::message('�����ɹ�', '?c=make_html&a=set');
	        }
	    }
	    catch (Exception $e)
	    {

	    }
	    app_tpl::display('make_html_set.tpl');
	}

	public static function pre()
    {
    }

}
