<?php
/**
 * �������ӹ��������
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_links.php 2010-11-29 09:08:41 yzt $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_links
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
            $data = mod_links::get_links_list();
            app_tpl::assign('data',$data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=links',   'subform'=>'?c=links&a=links_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('links_list.tpl');
    }
    
    /**
     * ���� ɾ�� ����
     *
     * @return void
     */
    public static function links_operate()
    {
        $ids = empty($_GET['id']) ? $_POST['id'] : (array)$_GET['id'];
        //���������id��Ϊ�գ���ɾ������
        if (!empty($ids))
        {
            mod_links::links_delete($ids);
        }

        //���������
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        mod_links::links_sort($sort);

        //���Ƿ���ʾ����
        $is_show = empty($_POST['is_show']) ? '' : $_POST['is_show'];
        mod_links::links_is_show($is_show);
        
        mod_links::update_cache_links_js(); //���»���
        $referer = empty($_POST['referer']) ? "?c=links" : $_POST['referer'];
        mod_login::message('�����ɹ�', $referer);
    }

    /**
     * �����������
     */
    public function links_add()
    {
        $referer = empty($_POST['referer']) ? "?c=links" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '�����������') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_links::links_save_add( $form ))
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
        $sys = array('goback'=>'?c=links',   'subform'=>'?c=links&a=links_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('links_form.tpl');
    }

    /**
     * �޸���������
     */
    public function links_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=links" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '�޸���������') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_links::links_save_edit( $form ))
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
                $data = mod_links::get_links_info($id);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=links',   'subform'=>'?c=links&a=links_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('links_form.tpl');
    }
}
