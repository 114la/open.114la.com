<?php
/**
 * �ؼ��ַ������
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_keyword_class
{
    /**
     * ��ʾ��Ϣ
     * @var string
     */
    private static $message = '';

    /**
     * ����
     *
     * @return void
     */
    public static function search()
    {
        try
        {
            $_GET['keyword'] = 'www';


            $keyword = (empty($_GET['keyword'])) ? '' : $_GET['keyword'];
            if (empty($keyword))
            {
                throw new Exception('������ؼ���', 10);
            }

            // ����
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
            $result = mod_zhuanti::search($keyword, $start, PAGE_ROWS);
            if (empty($result))
            {
                throw new Exception('û���ҵ����', 20);
            }

        }
        catch (Exception $e)
        {
            $message = $e->getMessage();
            $code = $e->getCode();

            echo $message;
        }

    }


    /**
     * ��ʾ
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('������', '�ؼ��ʷ����б�') );
            // ���
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];

            $result = mod_zhuanti_class::get_list('keyword');

            app_tpl::assign('list', $result['data']);

            app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            app_tpl::assign('key', $type);
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('keyword_class_list.tpl');
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
            $referer = (!empty($_POST['referer'])) ? $_POST['referer'] : '?c=key';
            if ($action != 'add' && $action != 'modify')
            {
                throw new Exception('����ʧ��', 10);
            }
            $data = array();

            $id = (empty($_POST['id'])) ? '' : $_POST['id'];
            $name = (empty($_POST['name'])) ? '' : $_POST['name'];
            $type = 'keyword';

            $data['type'] = $type;
            $data['name'] = $name;

            // ����
            if ($action == 'add')
            {
                $tmp = app_db::select('ylmf_toolclass', '*', "type = '{$type}' AND name = '{$name}'");
                if (!empty($tmp))
                {
                    throw new Exception('�÷��������Ѵ���', 10);
                }

                if (false === app_db::insert('ylmf_toolclass', array_keys($data), array_values($data)))
                {
                    throw new Exception('���ݿ����ʧ��', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    //mod_make_html::auto_update('zhuanti', $type);
                    mod_login::message('��ӳɹ�', '?c=keyword_class&type=' . $type);
                }

            }
            // �޸�
            elseif ($action == 'modify')
            {
                $tmp = app_db::select('ylmf_toolclass', '*', "type = '{$type}' AND name = '{$name}' AND id != {$id}");
                if (!empty($tmp))
                {
                    throw new Exception('�÷��������Ѵ���', 10);
                }

                $old = app_db::select('ylmf_toolclass', 'type', "id = {$id}");
                if ($id < 1 || false === app_db::update('ylmf_toolclass', $data, "id = {$id}"))
                {
                    throw new Exception('���ݿ����ʧ��', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    //mod_make_html::auto_update('zhuanti', $type);
                    if (!empty($old[0]['type']))
                    {
                        //mod_make_html::auto_update('zhuanti', $old[0]['type']);
                    }

                    mod_login::message('�޸ĳɹ�', '?c=keyword_class&type=' . $type);
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

        // �����б�
        app_tpl::display('keyword_class_edit.tpl');
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
            $referer = (empty($_POST['referer'])) ? '?c=keyword_class' : $_POST['referer'];
            // ����
            if (!empty($_POST['order']))
            {
                foreach ($_POST['order'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1)
                    {
                        continue;
                    }
                    $key = (int)$key;
                    $val = (empty($val)) ? 100 : (int)$val;
                    app_db::update('ylmf_toolclass', array('displayorder' => $val), "id = {$key}");
                }
            }

            // ��ҳ��ʾ
            if (!empty($_POST['inindex']))
            {
                $condition = '';
                foreach ($_POST['inindex'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1)
                    {
                        continue;
                    }
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::update('ylmf_toolclass', array('inindex' => 1), "id IN ($condition)");
                }
            }
            if (!empty($_POST['noindex']))
            {
                $condition = '';
                foreach ($_POST['noindex'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1 || $val != 1)
                    {
                        continue;
                    }
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::update('ylmf_toolclass', array('inindex' => 0), "id IN ($condition)");
                }
            }

            // ɾ��
            if (!empty($_POST['delete']))
            {
                if (empty($_POST['step']))
                {
                    $name = '';
                    $delete = array();
                    foreach ($_POST['delete'] as $key => $val)
                    {
                        $key = (int)$key;
                        $delete[] = $key;
                        $tmp = mod_zhuanti_class::get_one($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '����ɾ�����з��ࣺ<strong>' . $name . '</strong>��ȷ��ɾ����');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=keyword_class&a=list_edit');

                    app_tpl::display('confirm.tpl');
                    exit;
                }
                else
                {
                    $condition = '';
                    $_POST['delete'] = explode(',', $_POST['delete']);
                    foreach ($_POST['delete'] as $key => $val)
                    {
                        $val = (int)$val;
                        $condition .= (empty($condition)) ? "{$val}" : ", {$val}";
                    }
                    if (!empty($condition))
                    {
                        app_db::delete('ylmf_toolclass', "id IN ($condition)");
                    }
                }
            }
            mod_make_html::auto_update('index');
            mod_make_html::auto_update('zhuanti');

            mod_login::message('�����ɹ�', $referer);
        }
        catch (Exception $e)
        {

        }
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
            $referer = (empty($_SERVER['HTTP_REFERER'])) ? '?c=zhuant_clas' : $_SERVER['HTTP_REFERER'];
            if (empty($action) || ($action != 'modify' && $action != 'add'))
            {
                throw new Exception('����ʧ��', 10);
            }

            if ($action == 'modify')
            {
                app_tpl::assign( 'npa', array('������', '�༭�ؼ��ʷ���') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                if ($id < 1)
                {
                    throw new Exception('����ʧ��', 10);
                }
                $id = (int)$id;

                $result = mod_zhuanti_class::get_one($id);
                if (empty($result))
                {
                    throw new Exception('û���ҵ�����', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
            }
            else
            {
                app_tpl::assign( 'npa', array('������', '�����ؼ��ʷ���') );
                app_tpl::assign('action', 'add');
            }

            app_tpl::assign('referer', $referer);

            require PATH_DATA . '/conf/zhuantidb.php';
            app_tpl::assign('class_list', $zhuantidb);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('keyword_class_edit.tpl');
    }
}
?>
