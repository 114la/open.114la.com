<?php
/**
 *  ��������ؼ��ֹ��������
 *
 * @author seatle <seatle888@gmail.com>
 * @version $Id: ctl_search_keyword.php 2010-12-02
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_search_keyword
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
            app_tpl::assign('npa', array('��ַ����', ' ��������ؼ����б�'));
            $classid = empty($_GET['classid']) ? '' : $_GET['classid'];
            //���û��ѡ����࣬�Ե�һ������
            if (empty($classid))
            {
                app_db::query("SELECT classid FROM `ylmf_searchclass`");
                $data = app_db::fetch_one();
                $classid = $data['classid'];
            }
            app_tpl::assign('classid', $classid);
            $data = mod_search_keyword::get_search_keyword_list($classid);
            app_tpl::assign('data',$data);
            $options = mod_search_class::get_search_class_options();
            app_tpl::assign('options', $options);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_keyword',   'subform'=>'?c=search_keyword&a=search_keyword_operate');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_keyword_list.tpl');
    }
    
    /**
     * ���� ɾ�� ����
     *
     * @return void
     */
    public static function search_keyword_operate()
    {
        $referer = empty($_POST['referer']) ? "?c=search_keyword" : $_POST['referer'];

        $ids = empty($_GET['id']) ? $_POST['id'] : (array)$_GET['id'];
        //���������id��Ϊ�գ���ɾ������
        if (!empty($ids))
        {
            mod_search_keyword::search_keyword_delete($ids);
        }
        
        //���������
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        if ($sort)
        {
            mod_search_keyword::search_keyword_sort($sort);
        }

        mod_login::message('�����ɹ�', $referer);
    }

    /**
     * ��� ��������ؼ���
     */
    public function search_keyword_add()
    {
        $referer = empty($_POST['referer']) ? "?c=search_keyword" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '��� ��������ؼ���') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_search_keyword::search_keyword_save_add( $form ))
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
        $sys = array('goback'=>'?c=search_keyword',   'subform'=>'?c=search_keyword&a=search_keyword_add');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_keyword_form.tpl');
    }

    /**
     * �޸� ��������ؼ���
     */
    public function search_keyword_edit()
    {
        $referer = empty($_POST['referer']) ? "?c=search_keyword" : $_POST['referer'];
        try
        {
            app_tpl::assign( 'npa', array('��ַ����', '�޸� ��������ؼ���') );
            app_tpl::assign('options', mod_search_class::get_search_class_options());
            if(!empty($_POST['form']))
            {
                app_tpl::assign('data', $_POST['form']); //��ֹ����֮ǰ������ݶ�ʧ
                $form = $_POST['form'];
                if (mod_search_keyword::search_keyword_save_edit( $form ))
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
                (!$id) && mod_login::message('��ѡ��Ҫ�޸ĵ� ��������ؼ���', $referer);
                $data = mod_search_keyword::get_search_keyword_info($id);
                app_tpl::assign('data', $data);
            }
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=search_keyword',   'subform'=>'?c=search_keyword&a=search_keyword_edit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('search_keyword_form.tpl');
    }
}
