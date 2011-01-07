<?php
/**
 * ��վ��¼
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_url_add
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
            app_tpl::assign( 'npa', array('������ҳ', '�鿴��¼����') );
            $type = (isset($_GET['type'])) ? (int)$_GET['type'] : -1;

            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
            $result = mod_url_add::get_list($type, $start, PAGE_ROWS);

            if (!empty($result))
            {
                app_tpl::assign('page_url', "?c=url_add");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));

                app_tpl::assign('list', $result['data']);
                app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            }
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('url_add_list.tpl');
    }


	/**
     * ��ʾ������¼
     *
     * @return void
     */
    public static function show()
    {
        try
        {
            app_tpl::assign( 'npa', array('������ҳ', '��¼����') );
            $id = (empty($_GET['id']))  ? 0 : (int)$_GET['id'];
            if ($id < 1)
            {
                throw new Exception('����ʧ��', 10);
            }

            $result = mod_url_add::get_one($id);
            if (empty($result))
            {
                throw new Exception('����ʧ��', 10);
            }

            app_tpl::assign('data', $result);
            app_tpl::assign('back', (empty($_SERVER['HTTP_REFERER'])) ? '?c=add_url' : $_SERVER['HTTP_REFERER']);
            unset($result);

            app_tpl::assign( 'class_list', mod_class::get_subclass_list(0));
        }
        catch (Exception $e)
        {
            mod_login::message($e->getMessage(), '?a=add_url');
        }
        app_tpl::display('url_add_show.tpl');
    }


    /**
	 * û�о������
	 *
	 * @return void
     */
    public static function delete()
    {
        try
        {
            if (!empty($_POST['delete']))
            {
                $condition = '';
                foreach ($_POST['delete'] as $key => $val)
                {
                    $condition .= (empty($condition)) ? $key : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::delete('ylmf_urladd', "id IN ({$condition})");
                    mod_login::message('ɾ���ɹ�', (empty($_POST['referer'])) ? '?c=url_add' : $_POST['referer']);
                }
            }
            else
            {
                mod_login::message('��ѡ����Ҫɾ������', (empty($_POST['referer'])) ? '?c=url_add' : $_POST['referer']);
            }
        }
        catch (Exception $e)
        {

        }
    }


    /**
     * ͨ�����
     *
     * @return void
     */
    public static function pass()
    {
        try
        {
            $data = array();

            $id = (empty($_POST['id'])) ? '' : $_POST['id'];
            $pass = (empty($_POST['pass'])) ? '' : $_POST['pass'];
            $referer = (empty($_POST['referer'])) ? '?c=url_add' : $_POST['referer'];

            if ($pass == 'yes')
            {
                $site_name = (empty($_POST['site_name'])) ? '' : htmlspecialchars($_POST['site_name'], ENT_QUOTES);
                if (empty($site_name))
                {
                    throw new Exception('������վ������', 10);
                }
                $data['name'] = $site_name;

                $site_url = (empty($_POST['site_url'])) ? '' : $_POST['site_url'];
                if (empty($site_url) || !preg_match('#^http[s]?://#', $site_url))
                {
                    throw new Exception('��վ��ַ����Ϊ�ջ�����http://��ͷ', 10);
                }
                $data['url'] = $site_url;

                $color = (empty($_POST['color'])) ? '' : trim($_POST['color']);
                if (!empty($color) && !preg_match("/^#?([a-f]|[0-9]){3}(([a-f]|[0-9]){3})?$/i", $color))
                {
                    throw new Exception('��ɫ���벻��ȷ������ȷ��ʽ��#FF0000��', 10);
                }
                $data['namecolor'] = $color;

                $start_time = (empty($_POST['start_time'])) ? 0 : strtotime($_POST['start_time']);
                $data['starttime'] = $start_time;

                $end_time = (empty($_POST['end_time'])) ? 0 : strtotime($_POST['end_time']);
                if ($end_time < $start_time)
                {
                    throw new Exception('����ʱ�䲻�����ڿ�ʼʱ��', 10);
                }
                $data['endtime'] = $end_time;

                $class_id = (empty($_POST['classid'])) ? 0 : (
                            (false === strpos($_POST['classid'], ',')) ? $_POST['classid'] :
                                                                          substr($_POST['classid'], strrpos($_POST['classid'], ',') + 1)
                            );
                $cache_main_class = mod_class::get_class_list();
                if (!array_key_exists($class_id, $cache_main_class))
                {
                    throw new Exception('��ѡ��վ�����', 10);
                }
                if ($cache_main_class[$class_id]['parentid'] == 0 || $cache_main_class[$cache_main_class[$class_id]['parentid']]['parentid'] == 0)
                {
                    throw new Exception('������ѡ���ӷ���', 10);
                }
                if (preg_match("#^http[s]?://#", $cache_main_class[$class_id]['path']))
                {
                    throw new Exception('���������ⲿ����,�޷����!', 10);
        	    }
                $data['class'] = $class_id;

                $recommend = (empty($_POST['recommend'])) ? 0 : 1;
                $data['good'] = $recommend;

                $order = (empty($_POST['displayorder'])) ? 100 : $_POST['displayorder'];
                $data['displayorder'] = $order;

          //      $data['adduser'] = addslashes(mod_login::get_username());

                $shenhe = (empty($_POST['shenhe'])) ? '' : htmlspecialchars($_POST['shenhe'], ENT_QUOTES);

                // ����
                if (app_db::insert('ylmf_site', array_keys($data), array_values($data)))
                {
                    $type = 1;
            	    app_db::update('ylmf_urladd', array('type' => $type, 'shenhe' => $shenhe), "id = {$id}");

                    //���ɾ�̬ҳ�濪ʼ
                    mod_make_html::make_html_one_catalog($cache_main_class[$class_id]['parentid'],
                                                        $cache_main_class[$cache_main_class[$class_id]['parentid']]['classname']);
                }
                else
                {
                    throw new Exception('���ݿ����ʧ��', 10);
                }

                $old = mod_url_add::get_one($id);
                $siteinfo = $old;
                // �����ʼ�
        	    if (mod_config::get_one_config('yl_sendemail'))
        	    {
            	    $sysname = mod_config::get_one_config('yl_sysname');
            	    $subject = $sysname . ' վ����¼���֪ͨ�ʼ�';
            		$toemail = $siteinfo['email'];

                    $slclassname = $cache_main_class[$cache_main_class[$class_id]['parentid']]['classname'] .' - ' . $cache_main_class[$class_id]['classname'];
    			    $body = '����' . $sysname . '�ύ��վ����¼����ͨ��,��¼���˷���:' . $slclassname . '.(��ΪCDN�����ϵ,������Ҫ1-3����ܸ���)';

        		    mod_mail::send($toemail, '', $subject, $body, 'txt');
        	    }

                mod_login::message('�����ɹ�', $referer);
            }
            elseif ($pass == 'no')
            {
                $shenhe = (empty($_POST['shenhe'])) ? '' : htmlspecialchars($_POST['shenhe'], ENT_QUOTES);
            	$old = mod_url_add::get_one($id);
            	if (!empty($old))
            	{
            	    $siteinfo = $old;
            	    $type = 2;
            	    app_db::update('ylmf_urladd', array('type' => $type, 'shenhe' => $shenhe), "id = {$id}");

            	    // �����ʼ�
            	    if (mod_config::get_one_config('yl_sendemail') && $shenhe != '')
            	    {
                	    $sysname = mod_config::get_one_config('yl_sysname');
                	    $subject = $sysname . ' վ����¼���֪ͨ�ʼ�';
                		$toemail = $siteinfo['email'];

                		$body = '����' . $sysname . '�ύ��վ����¼���󱻾ܾ�,��������:' . $shenhe;
            		    mod_mail::send($toemail, '', $subject, $body, 'txt');
            	    }

            	    mod_login::message('�����ɹ�', $referer);
            	}
            	else
            	{
            	    throw new Exception('����ʧ��', 10);
            	}
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }

        !empty($_POST['site_name']) && $_POST['name'] = $_POST['site_name'];
        !empty($_POST['site_url']) && $_POST['siteurl'] = $_POST['site_url'];
        app_tpl::assign('data', $_POST);
        app_tpl::assign( 'class_list', mod_class::get_subclass_list(0));
        !empty($_POST['classid']) && app_tpl::assign('class_id', $_POST['classid']);
        app_tpl::display('url_add_show.tpl');
    }
}
?>
