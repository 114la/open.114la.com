<?php
/**
 * �ط�������ҳվ�������
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 * @version    $Id: ctl_local_index.php 559 2009-11-23 13:11:30Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_local_index
{
    /**
     * ��ʾ��Ϣ
     * @var string
     */
    private static $message = '';

    /**
     * ��ʾ
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('ר�����', '�ط�������ҳվ���б�') );
            $result = mod_local_index::get_local_index_list();
            if (!empty($result))
            {
                app_tpl::assign('list', $result);
            }
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('local_index_list.tpl');
    }


	/**
     * �༭
     *
     * @return void
     */
    public static function edit()
    {
        try
        {
            $action = (empty($_GET['action'])) ? '' : $_GET['action'];
            if (empty($action) || ($action != 'modify' && $action != 'add'))
            {
                throw new Exception('����ʧ��', 10);
            }

            if ($action == 'modify')
            {
                app_tpl::assign( 'npa', array('ר�����', '�༭�ط�������ҳվ��') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                $id = (int)$id;

                $result = mod_local_index::get_local_index($id);
                if (empty($result))
                {
                    throw new Exception('û���ҵ�����', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
                app_tpl::assign('id', $id);
                app_tpl::assign('referer', (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '');
            }
            else
            {
                app_tpl::assign( 'npa', array('ר�����', '�����ط�������ҳվ��') );
                app_tpl::assign('action', 'add');
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('local_index_edit.tpl');
    }


    /**
     * ����
     *
     * @return void
     */
    public static function save()
    {
        try
        {
            $action = (empty($_POST['action'])) ? '' : $_POST['action'];
            $referer = (empty($_POST['referer'])) ? '' : $_POST['referer'];
            if ($action != 'add' && $action != 'modify')
            {
                throw new Exception('����ʧ��', 10);
            }
            $data = array();

            $id = (int)$_POST['id'];

            $site_name = (empty($_POST['name'])) ? '' : htmlspecialchars($_POST['name'], ENT_QUOTES);
            if (empty($site_name))
            {
                throw new Exception('����ʧ��', 10);
            }
            $data['name'] = $site_name;

            $site_url = (empty($_POST['url'])) ? '' : $_POST['url'];
            if (empty($site_url) || !preg_match('#^http[s]?://#', $site_url))
            {
                throw new Exception('��վ��ַ����Ϊ�ջ�����http://��ͷ', 10);
            }
            $data['url'] = $site_url;
            $order = (empty($_POST['order'])) ? 100 : $_POST['order'];
            $data['order'] = $order;
            $data['color'] = $_POST['color'];

            // ����
            if ($action == 'add')
            {

                if (false === mod_local_index::add_local_index($data))
                {
                    throw new Exception('����ʧ��', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');

                    mod_login::message('��ӳɹ�', '?c=local_index');
                }

            }
            // �޸�
            elseif ($action == 'modify')
            {
                if ($id < 0 || false === mod_local_index::edit_local_index($id, $data))
                {
                    throw new Exception('����ʧ��', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');

                    mod_login::message('�޸ĳɹ�', '?c=local_index');
                }
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::assign('action', $action);
        app_tpl::assign('referer', $referer);
        app_tpl::assign('data', $_POST);
        app_tpl::display('local_index_edit.tpl');
    }


    /**
     * �б����
     *
     * @return void
     */
    public static function list_edit()
    {
        try
        {
            $referer = (empty($_POST['referer'])) ? '?c=local_index' : $_POST['referer'];
            // ����
            if (!empty($_POST['order']))
            {
                mod_local_index::order_local_index($_POST['order']);
            }

            // ɾ��
            if (isset($_POST['delete']))
            {
                if (empty($_POST['step']))
                {
                    $name = '';
                    $delete = array();
                    foreach ($_POST['delete'] as $key => $val)
                    {
                        $key = (int)$key;
                        $delete[] = $key;
                        $tmp = mod_local_index::get_local_index($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '����ɾ�����б�ǩ��<strong>' . $name . '</strong>��ȷ��ɾ����');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=local_index&a=list_edit');

                    app_tpl::display('confirm.tpl');
                    exit;
                }
                else
                {
                    $delete_id = explode(',', $_POST['delete']);
                    if (!empty($delete_id))
                    {
                        mod_local_index::delete_local_index($delete_id);
                    }
                }
            }
            //mod_make_html::auto_update('index');

            mod_login::message('�����ɹ�', $referer);
        }
        catch (Exception $e)
        {

        }
    }

}
?>
