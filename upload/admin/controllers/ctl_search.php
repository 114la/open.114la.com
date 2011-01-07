<?php
/**
 * ����������������
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_search.php 2010-12-02
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_search
{
    /**
     * ��ʾ
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign('npa', array('��ַ����', '���������б�'));
            $classid = empty($_GET['classid']) ? '' : $_GET['classid'];
            //���û��ѡ����࣬�Ե�һ������
            if (empty($classid))
            {
                app_db::query("SELECT classid FROM `ylmf_searchclass`");
                $data = app_db::fetch_one();
                $classid = $data['classid'];
            }
            app_tpl::assign('classid', $classid);
            $data = mod_search::get_search_list($classid);
            app_tpl::assign('data',$data);
            $options = mod_search_class::get_search_class_options();
            app_tpl::assign('options', $options);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search',   'subform'=>'?c=search&a=search_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_list.tpl');
    }
    
    /**
     * ���� ɾ�� ����
     *
     * @return void
     */
    public static function search_operate()
    {
        $referer = empty($_POST['referer']) ? "?c=search" : $_POST['referer'];

        $ids = empty($_GET['id']) ? $_POST['id'] : (array)$_GET['id'];
        $classid = empty($_GET['classid']) ? $_POST['classid'] : $_GET['classid'];
        if (empty($classid))
        {
            mod_login::message('����ʧ�ܣ���ѡ�����', $referer);
        }
        //���������id��Ϊ�գ���ɾ������
        if (!empty($ids))
        {
            mod_search::search_delete($ids, $classid);
        }
        else
        {
            //���Ƿ�Ĭ�ϲ�������ɾ���г�ͻ���ܿ�
            $id = empty($_POST['is_default']) ? '' : $_POST['is_default'];
            mod_search::search_set_default($id, $classid);
        }
        
        //���������
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        if ($sort)
        {
            mod_search::search_sort($sort);
        }

        //���Ƿ���ʾ����
        $is_show = empty($_POST['is_show']) ? '' : $_POST['is_show'];
        if ($is_show)
        {
            mod_search::search_is_show($is_show, $classid);
        }
        
        mod_login::message('�����ɹ�', $referer);
    }

    /**
     * �����������
     */
    public function search_add()
    {
        $referer = empty($_POST['referer']) ? "?c=search" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '�����������') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_search::search_save_add( $form ))
                {
                    mod_login::message('�����ɹ�', $referer);
                }
                else
                {
                    mod_login::message('����ʧ��', $referer);
                }
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search',   'subform'=>'?c=search&a=search_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_form.tpl');
    }

    /**
     * �޸���������
     */
    public function search_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=search" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '�޸���������') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_search::search_save_edit( $form ))
                {
                    exit(mod_login::message('�����ɹ�', $referer));
                }
                else
                {
                    exit(mod_login::message('����ʧ��', $referer));
                }
            }
            else
            {
                $id = empty($_GET['id']) ? '' : $_GET['id'];
                (!$id) && mod_login::message('��ѡ��Ҫ�޸ĵ���������', $referer);
                $data = mod_search::get_search_info($id);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search',   'subform'=>'?c=search&a=search_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_form.tpl');
    }
}
