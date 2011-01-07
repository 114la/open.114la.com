<?php
/**
 * ר�����
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_key
{
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
            app_tpl::assign( 'npa', array('������', '�ؼ����б�') );
            $show_type = 'default';
            // ������鿴
            // ��ʾ����վ��
            $isend = (empty($_GET['isend'])) ? false : true;
            // ��ʾ��ҳ��ʾվ��
            $inindex = (empty($_GET['inindex'])) ? false : true;

            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];

            // �����б�
            $class_list =  self::get_class_list();
            app_tpl::assign('class_list', $class_list);
            $class_list = @array_pop($class_list);
            $class_id = (empty($_GET['classid'])) ? $class_list[0]['id'] : $_GET['classid'];
            app_tpl::assign('class_id', $class_id);


            // ���
            $result = mod_zhuanti::get_list($class_id, $isend, $inindex, $start, PAGE_ROWS, 'keyword');
            if (!empty($result))
            {
                app_tpl::assign('page_url', "?c=key&classid={$class_id}&isend={$isend}&inindex={$inindex}");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
                app_tpl::assign('list', $result['data']);

                app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());

        }
        app_tpl::display('key_site_list.tpl');
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

            $site_name = (empty($_POST['site_name'])) ? '' : htmlspecialchars($_POST['site_name'], ENT_QUOTES);
            if (empty($site_name))
            {
                throw new Exception('����ʧ��', 10);
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

            $class_id = (empty($_POST['class_id'])) ? '' : $_POST['class_id'];
            if (empty($class_id))
            {
                throw new Exception('��ѡ�����', 10);
            }
            $data['class'] = $class_id;

            $order = (empty($_POST['order'])) ? 100 : $_POST['order'];
            $data['displayorder'] = $order;

            $inindex = (empty($_POST['inindex'])) ? 0 : $_POST['inindex'];
            $data['inindex'] = $inindex;

            $start_time = (empty($_POST['start_time'])) ? 0 : strtotime($_POST['start_time']);
            $data['starttime'] = $start_time;

            $end_time = (empty($_POST['end_time'])) ? 0 : strtotime($_POST['end_time']);
            if ($end_time < $start_time)
            {
                throw new Exception('����ʱ�䲻�����ڿ�ʼʱ��', 10);
            }
            $data['endtime'] = $end_time;

            $remark = (empty($_POST['remark'])) ? '' : trim($_POST['remark']);
            $data['remark'] = $remark;


            // ����
            if ($action == 'add')
            {
                $tmp = app_db::select('ylmf_tool', 'id', "(name = '{$site_name}')AND class = {$class_id}");
                if (!empty($tmp))
                {
                    throw new Exception('����վ�Ѵ���');
                }
                if (false === app_db::insert('ylmf_tool', array_keys($data), array_values($data)))
                {
                    throw new Exception('���ݿ����ʧ��', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    mod_login::message('��ӳɹ�', '?c=key');
                }

            }
            // �޸�
            elseif ($action == 'modify')
            {
                $tmp = app_db::select('ylmf_tool', 'id', "(name = '{$site_name}')AND class = {$class_id} AND id != {$id}");
                if (!empty($tmp))
                {
                    throw new Exception('����վ�Ѵ���');
                }

                if ($id < 1 || false === app_db::update('ylmf_tool', $data, "id = {$id}"))
                {
                    throw new Exception('���ݿ����ʧ��', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    mod_login::message('�޸ĳɹ�', $referer);
                }
            }
            else
            {
                mod_login::message('����ʧ��', '?c=key');
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }

        app_tpl::assign('action', $action);
        app_tpl::assign('referer', $referer);

        $_POST['name'] = $_POST['site_name'];
        $_POST['url'] = $_POST['site_url'];
        $_POST['starttime'] = $_POST['start_time'];
        $_POST['endtime'] = $_POST['end_time'];
        $_POST['displayorder'] = $_POST['order'];
        $_POST['namecolor'] = $_POST['color'];
        $_POST['remark'] = $_POST['remark'];
        $_POST['class'] = $_POST['class_id'];
        app_tpl::assign('data', $_POST);

        // �����б�
        $class_list = self::get_class_list();
        app_tpl::assign('class_list', $class_list);

        app_tpl::display('key_site_edit.tpl');
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
                app_tpl::assign( 'npa', array('������', '�༭�ؼ���') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                if ($id < 1)
                {
                    throw new Exception('����ʧ��', 10);
                }
                $id = (int)$id;

                $result = mod_zhuanti::get_one($id);
                if (empty($result))
                {
                    throw new Exception('û���ҵ�����', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
                app_tpl::assign('referer', $_SERVER['HTTP_REFERER']);
            }
            else
            {
                app_tpl::assign( 'npa', array('������', '�����ؼ���') );
                app_tpl::assign('action', 'add');
            }

            // �����б�
            $class_list = self::get_class_list();
            if (empty($class_list))
            {
                throw new Exception('û�д�������', 10);
            }
            app_tpl::assign('class_list', $class_list);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('key_site_edit.tpl');
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
            $referer = (empty($_POST['referer'])) ? '?c=key' : $_POST['referer'];
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
                    app_db::update('ylmf_tool', array('displayorder' => $val), "id = {$key}");
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
                    app_db::update('ylmf_tool', array('inindex' => 1), "id IN ($condition)");
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
                    app_db::update('ylmf_tool', array('inindex' => 0), "id IN ($condition)");
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
                        $tmp = mod_zhuanti::get_one($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '����ɾ������վ�㣺<strong>' . $name . '</strong>��ȷ��ɾ����');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=key&a=list_edit');

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
                        app_db::delete('ylmf_tool', "id IN ($condition)");
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


    /**
     * ��ȡ���� select �ķ����б�
     *
     * @return array
     */
    private function get_class_list()
    {
        $class_list = mod_zhuanti_class::get_list('keyword');
        if (!empty($class_list['data']))
        {
            $new_class_list = array();
            foreach ($class_list['data'] as $row)
            {
                 $new_class_list[$row['type_zh']][] = array('id'=>$row['id'], 'name' => $row['name']);
            }
            return (empty($new_class_list)) ? false : $new_class_list;
        }
        return false;
    }
}
?>
