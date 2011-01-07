<?php
/**
 * �������������������
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_search_class.php 2010-12-02
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_search_class
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
            app_tpl::assign('npa', array('��ַ����', '������������б�'));
            $data = mod_search_class::get_search_class_list();
            app_tpl::assign('data',$data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_class',   'subform'=>'?c=search_class&a=search_class_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_class_list.tpl');
    }
    
    /**
     * ���� ɾ�� ����
     *
     * @return void
     */
    public static function search_class_operate()
    {
        $ids = empty($_GET['classid']) ? $_POST['classid'] : (array)$_GET['classid'];
        //���������id��Ϊ�գ���ɾ������
        if (!empty($ids))
        {
            mod_search_class::search_class_delete($ids);
        }
        //���Ϊ�գ����������Ĭ�ϲ���
        else
        {
            //���Ƿ�Ĭ�ϲ�������ɾ���г�ͻ���ܿ�
            $classid = empty($_POST['is_default']) ? '' : $_POST['is_default'];
            mod_search_class::search_class_set_default($classid);
        }
        
        //���������
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        mod_search_class::search_class_sort($sort);

        $referer = empty($_POST['referer']) ? "?c=search_class" : $_POST['referer'];
        mod_login::message('�����ɹ�', $referer);
    }

    /**
     * ��������������
     */
    public function search_class_add()
    {
        $referer = empty($_POST['referer']) ? "?c=search_class" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '��������������') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_search_class::search_class_save_add( $form ))
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
        $sys = array('goback'=>'?c=search_class',   'subform'=>'?c=search_class&a=search_class_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_class_form.tpl');
    }

    /**
     * �޸������������
     */
    public function search_class_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=search_class" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '�޸������������') );
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_search_class::search_class_save_edit( $form ))
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
                $classid = empty($_GET['classid']) ? '' : $_GET['classid'];
                (!$classid) && mod_login::message('��ѡ��Ҫ�޸ĵ������������', $referer);
                $data = mod_search_class::get_search_class_info($classid);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_class',   'subform'=>'?c=search_class&a=search_class_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_class_form.tpl');
    }
}
