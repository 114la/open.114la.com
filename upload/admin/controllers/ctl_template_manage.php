<?php

/**
 * ģ�����
 *
 * @copyright http://www.114la.com
 * @version    $Id: ctl_template_manage.php 1093 2009-11-28 02:50:16Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_template_manage
{

    /**
     * ǰ̨ģ��Ŀ¼
     * @var string
     */
    private static $dir_tpl_main;

    /**
     * pre����
     *
     * @return void
     */
    public static function pre()
    {
        if (!self::$dir_tpl_main = mod_config::get_one_config('yl_dirtplmain'))
        {
            self::$dir_tpl_main = 'default';
        }
    }

    /**
     * ģ������б�
     *
     * @return void
     */
    public static function template_list()
    {
        try
        {
            app_tpl::assign('npa', array('ģ�����', 'ģ������б�'));
            $data = mod_template::template_list();
            app_tpl::assign('data',$data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=template_manage&a=template_list',   'subform'=>'?c=template_manage&a=template_delete');
        app_tpl::assign('sys', $sys);
        app_tpl::display('template_list.tpl');
    }

    /**
     * ɾ��ģ��
     *
     * @return void
     */
    public static function template_delete()
    {
        defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
        $referer = $_SERVER['HTTP_REFERER'];
        $ids = ($_GET['id']) ? (array)$_GET['id'] : $_POST['id'];
        empty($ids) && exit(mod_login::message("��ѡ��Ҫɾ����ģ��!", $_POST['referer']));
        $msg = '';
        $all_success = TRUE; //����ɾ�����ɹ�
        foreach ($ids as $id) 
        {
            app_db::query("SELECT `tpl_file` FROM `ylmf_template` WHERE `id`='{$id}'");
            $data = app_db::fetch_one();
            $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $data['tpl_file'];
            $filename_bak = $filename . TPLS_BACKUP_EXT;
            //ɾ��ģ���ļ���ģ�屸���ļ�
            if (is_file($filename))
            {
                //���ɾ�����ɹ���ƴ�ձ�����Ϣ
                if (!@unlink($filename))
                {
                    $msg .= "ģ���ļ� " .$data['tpl_file'] . "ɾ��<font color=red>ʧ��</font>��������ļ��Ƿ���ɾ��Ȩ��<br/>";
                }
            }
            if (is_file($filename_bak))
            {
                if (!@unlink($filename_bak))
                {
                    $msg .= "ģ�屸���ļ� " .$data['tpl_file'] . TPLS_BACKUP_EXT . "ɾ��<font color=red>ʧ��</font>��������ļ��Ƿ���ɾ��Ȩ��<br/>";
                }
            }
            //�����ļ�����������
            if (!is_file($filename) && !is_file($filename_bak))
            {
                app_db::query("DELETE FROM `ylmf_template` WHERE `id`='{$id}'");
            }
            else
            {
                $all_success = FALSE;
            }
        }
        //���ж��ɹ��Ļ�ֱ����ʾɾ��ģ��ɹ�
        if ($all_success)
        {
            exit(mod_login::message("ɾ��ģ��ɹ�!", (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
        }
        //ֻҪ��һ�����ɹ�������ʾ���д�����ϸ��Ϣ
        else
        {
            exit(mod_login::message($msg, (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
        }
    }

    /**
     * ���ģ��
     *
     * @return void
     */
    public static function template_add()
    {
        try
        {
            if (empty($_POST))
            {
                app_tpl::assign('npa', array('ģ�����', '���ģ��'));
                $sys = array('goback'=>'?c=template_manage&a=template_list', 'subform'=>'?c=template_manage&a=template_add');
                app_tpl::assign('sys', $sys);
            }
            else
            {
                defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
                $form = $_POST['form'];
                $content = (empty($_POST['content'])) ? '' : htmlspecialchars_decode(stripslashes($_POST['content']));
                //����ǰ��ո�
                $form['tpl_name'] = trim($form['tpl_name']);
                $form['tpl_file'] = trim($form['tpl_file']);
                //�����ʱ�򲻻ᵼ��֮ǰ���ֵ��ʧ
                app_tpl::assign('form', $form);
                app_tpl::assign('content', $content);
                //�ж�ģ������
                if (empty($form['tpl_name']))
                {
                    throw new Exception('������ģ������');
                }
                //�ж�ģ���ļ�
                if (empty($form['tpl_file']))
                {
                    app_db::query("SELECT MAX(id) as id FROM `ylmf_template`");
                    $data = app_db::fetch_one();
                    $id = intval($data[id]) + 1;
                    $form['tpl_file'] = "class_" . $id . '.tpl';
                    //�����ʱ�򲻻ᵼ��֮ǰ���ֵ��ʧ������û����ģ�����Ƶģ���һ��Ψһ��������
                    app_tpl::assign('form', $form);
                }
                else
                {
                    app_db::query("SELECT * FROM `ylmf_template` WHERE `tpl_file`='{$form['tpl_file']}'");
                    $data = app_db::fetch_one();
                    if($data) throw new Exception('�Ѵ���ģ���ļ���������Ψһ��ģ���ļ�');
                }
                //�ж�ģ������
                if (empty($content))
                {
                    throw new Exception('������ģ������');
                }
                $form['add_time'] = time();
                //�������ݿ�
                if (false === app_db::insert('ylmf_template', array_keys($form), array_values($form)))
                {
                    throw new Exception('���ݿ����ʧ��');
                }
                //����ģ���ļ���ģ�屸���ļ�,ɾ����ʱ��ǵ�������ɾ����
                $ini_filename = (empty($form['tpl_file'])) ? '' : $form['tpl_file'];
                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                if (false == mod_file::write($filename, $content, 'wb+'))
                {
                    throw new Exception('�ļ�' . $ini_filename . ' ����ʧ��');
                }
                @chmod($filename, 0777);
                $filename_bak = $filename . TPLS_BACKUP_EXT;
                if (false == mod_file::write($filename_bak, $content, 'wb+'))
                {
                    throw new Exception('�ļ�' . $ini_filename . TPLS_BACKUP_EXT . ' ����ʧ��');
                }
                @chmod($filename, 0777);

                //exit(mod_login::message("���ģ��ɹ�!", $_POST['referer']));
                exit(mod_login::message("���ģ��ɹ�!", (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('template_form.tpl');
        
    }
    
    /**
     * ���ģ��
     *
     * @return void
     */
    public static function template_edit()
    {
        try
        {
            //�༭�޸�ģ��
            if (empty($_POST))
            {
                //ģ���ļ������ֻ��,�޸�ʱ�Ͳ�Ҫ�޸�ģ���ļ��˷������
                app_tpl::assign('tpl_file_readonly', 'yes');

                $id = $_GET['id'];
                app_tpl::assign('npa', array('ģ�����', '�޸�ģ��'));
                $sys = array('goback'=>'?c=template_manage&a=template_list', 'subform'=>'?c=template_manage&a=template_edit');
                app_tpl::assign('sys', $sys);

                $query = app_db::query("SELECT * FROM `ylmf_template` WHERE `id`={$id}");
                $form  = app_db::fetch_one();
                app_tpl::assign('form', $form);
                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $form['tpl_file'];
                app_tpl::assign('content', htmlspecialchars(mod_file::read($filename), ENT_QUOTES));
            }
            //�����޸�ģ��
            else
            {
                $id = $_POST['id'];
                $form = $_POST['form'];
                $content = (empty($_POST['content'])) ? '' : htmlspecialchars_decode(stripslashes($_POST['content']));
                //����ǰ��ո�
                $form['tpl_name'] = trim($form['tpl_name']);
                $form['tpl_file'] = trim($form['tpl_file']);
                //�����ʱ�򲻻ᵼ��֮ǰ���ֵ��ʧ
                app_tpl::assign('form', $form);
                app_tpl::assign('content', $content);
                //�ж�ģ������
                if (empty($form['tpl_name']))
                {
                    throw new Exception('������ģ������');
                }
                //�ж�ģ������
                if (empty($content))
                {
                    throw new Exception('������ģ������');
                }

                if (false === app_db::update('ylmf_template', $form, "id={$id}"))
                {
                    throw new Exception('���ݿ��޸�ʧ��');
                }
                //����ģ���ļ���ģ�屸���ļ�,ɾ����ʱ��ǵ�������ɾ����
                $ini_filename = (empty($form['tpl_file'])) ? '' : $form['tpl_file'];
                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                if (false == mod_file::write($filename, $content, 'wb+'))
                {
                    throw new Exception('�ļ�' . $ini_filename . ' ����ʧ��');
                }

                //exit(mod_login::message("�޸�ģ��ɹ�!", $_POST['referer']));
                exit(mod_login::message("�޸�ģ��ɹ�!", (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('template_form.tpl');
    }

    /**
     * ����ģ��
     *
     * @return void
     */
    public static function backup()
    {
        defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
        $ini_filename = (empty($_GET['filename'])) ? '' : $_GET['filename'];
        $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
        $filename_bak = $filename . TPLS_BACKUP_EXT;
        if (@copy($filename, $filename_bak))
        {
            exit(mod_login::message("ģ�屸�ݳɹ�!", '?c=template_manage&a=template_list'));
        }
        exit(mod_login::message("ģ�屸��ʧ��,�����ļ�Ȩ��!", '?c=template_manage&a=template_list'));
    }

    /**
     * �ָ�ģ��
     *
     * @return void
     */
    public static function restore()
    {
        defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
        $ini_filename = (empty($_GET['filename'])) ? '' : $_GET['filename'];
        $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
        $filename_bak = $filename . TPLS_BACKUP_EXT;
        if (@copy($filename_bak, $filename))
        {
            exit(mod_login::message("ģ�廹ԭ�ɹ�!", '?c=template_manage&a=template_list'));
        }
        exit(mod_login::message("ģ�廹ԭʧ��,�����ļ�Ȩ��!", '?c=template_manage&a=template_list'));
    }

    /**
     * ģ�����
     *
     * @return void
     */
    public static function index()
    {
        //echo file_get_contents(PATH_DATA."/cache/cache_index_tool.php");
        //exit;
        try
        {
            app_tpl::assign('npa', array('ģ�����', 'ģ��༭'));
            //$action = 'modify' | 'save' | 'restore' �޸� ���� ��ԭ
            $action = (empty($_GET['action'])) ? '' : $_GET['action'];

            defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');

            // ���ļ���ָ���Ĭ��ģ��
            if ($action == 'modify' || $action == 'restore')
            {
                $ini_filename = (empty($_GET['filename'])) ? '' : $_GET['filename'];
                if (empty($ini_filename))
                {
                    throw new Exception('�ļ� ' . $ini_filename . ' ������');
                }

                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                if ($action == 'restore')
                {
                    $filename .= TPLS_BACKUP_EXT;
                }

                if (!file_exists($filename))
                {
                    throw new Exception('�ļ� ' . $ini_filename . ' ������');
                }
                if ($action == 'modify')
                {
                    // �����ڱ����ļ��򱸷�һ��ԭʼ�ļ�
                    if (!file_exists($filename . TPLS_BACKUP_EXT) && !@copy($filename, $filename . TPLS_BACKUP_EXT))
                    {
                        throw new Exception('�ļ� ' . $ini_filename . TPLS_BACKUP_EXT . ' ����ʧ��');
                    }
                }
                else
                {
                    // �ָ�ģ��
                    $old_filename = substr($filename, 0, -strlen((TPLS_BACKUP_EXT)));
                    $bak_filename = $filename;
                    if (!mod_file::write($old_filename, mod_file::read($bak_filename)))
                    {
                        throw new Exception('�ļ�' . $ini_filename . ' �ָ�ʧ��');
                    }

                    if (preg_match('/index\.tpl/i', $filename))
                    {
                        mod_make_html::auto_update('index');
                    }
                    elseif (preg_match('/other\_(header|footer|body)\.tpl/i', $filename))
                    {
                        mod_make_html::auto_update('other');
                    }
                }

                app_tpl::assign('content', htmlspecialchars(mod_file::read($filename), ENT_QUOTES));
                app_tpl::assign('filename', $ini_filename);
                app_tpl::assign('back', '?c=template_manage&action=modify&filename=' . $ini_filename);
            }
            // д�ļ�
            elseif ($action == 'save')
            {
                $content = (empty($_POST['content'])) ? '' : htmlspecialchars_decode(stripslashes($_POST['content']));
                if (empty($content))
                {
                    throw new Exception('������ģ������', 10);
                }

                $ini_filename = (empty($_POST['filename'])) ? '' : $_POST['filename'];
                if (empty($ini_filename))
                {
                    throw new Exception('�ļ� ' . $ini_filename . ' ������');
                }

                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                // �����޸�ԭʼ�����ļ�
                if (!file_exists($filename) || substr($filename, -(strlen(TPLS_BACKUP_EXT))) == TPLS_BACKUP_EXT)
                {
                    throw new Exception('�ļ� ' . $ini_filename . ' ������');
                }

                if (false == mod_file::write($filename, $content, 'wb+'))
                {
                    throw new Exception('�ļ�' . $ini_filename . ' ����ʧ��');
                }
                @chmod($filename, 0777);

                if (preg_match('/index\.tpl/i', $filename))
                {
                    mod_make_html::auto_update('index');
                }
                elseif (preg_match('/other\_(header|footer|body)\.tpl/i', $filename))
                {
                    mod_make_html::auto_update('other');
                }

                mod_login::message('�����ɹ�', (empty($_POST['referer'])) ? '?c=template_manage' : $_POST['referer']);
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        if (preg_match('/class\_(header|footer|body)\.tpl/i', $ini_filename))
        {
            app_tpl::assign('show_msg', 1);
        }
        app_tpl::display('template_manage.tpl');
    }

    /**
     * ģ��ѡ��
     *
     * @return void
     */
    public static function cur_tpl()
    {
        app_tpl::assign('npa', array('ģ�����', 'ģ��ѡ��'));
        // ɾ��
        if (!empty($_GET['delete']))
        {
            $tpl = PATH_TPLS_MAIN . '/' . $_GET['delete'];
            if (is_dir($tpl))
            {
                mod_file::rm_recurse($tpl);
                mod_login::message('�����ɹ�', '?c=template_manage&a=cur_tpl');
            }
        }
        // ����
        elseif (!empty($_GET['apply']))
        {
            mod_config::set_configs(array('yl_dirtplmain' => $_GET['apply']));
            if (!empty($_GET['mkhtml']))
            {
                mod_make_html::flush('����������ҳ����');
                mod_make_html::make_html_index();
                mod_make_html::flush($ok);
            }
            mod_login::message('�����ɹ�', '?c=template_manage&a=cur_tpl');
        }

        $dirs = mod_file::ls(PATH_TPLS_MAIN, 'dir');
        if (file_exists(PATH_TPLS_MAIN . '/' . self::$dir_tpl_main))
        {
            $cur_dir = self::$dir_tpl_main;
        }
        else
        {
            $cur_dir = current($dirs);
            if ($cur_dir === false)
            {
                //��ģ��
                //��ʾ���ҳ���˳�
            }
        }

        //��ʾ����ģ��
        $other_tpls = array();
        foreach ($dirs as $dir)
        {
            $name_filename = PATH_TPLS_MAIN . '/' . $dir . '/NAME';
            if (is_file($name_filename))
            {
                $cur_name = @file_get_contents($name_filename);
                if (empty($cur_name))
                {
                    $cur_name = $dir;
                }
            }
            else
            {
                $cur_name = $dir;
            }

            $tpl = array('path' => $dir, 'name' => $cur_name, 'preview' => ADMIN . '/tpls/tpls/main/' . $dir . '/PREVIEW.jpg');
            if ($dir == $cur_dir)
            {
                $cur_tpl = $tpl; // ��ǰģ�������
            }
            else
            {
                $other_tpls[] = $tpl;
            }
        }

        if (!empty($cur_tpl))
        {
            app_tpl::assign('cur_tpl', $cur_tpl);
        }
        if (!empty($other_tpls))
        {
            app_tpl::assign('other_tpls', $other_tpls);
        }

        app_tpl::display('template_select.tpl');
    }

}

?>
