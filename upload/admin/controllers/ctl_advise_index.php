<?php
/**
 * ��ҳ���
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_advise_index
{
/**
 * ���ص���Ϣ
 * @var string
 */
		private static $message = '';

    public function index()
    {
        app_tpl::assign( 'npa', array('������', '��ҳ������') );
        $this->advise_index_list();
    }
    /**
     * ��ʾ
     *
     * @return viod
     */

    public function advise_index_list()
    {
        try
        {
            $data = mod_advise_index::advise_index_list();
            app_tpl::assign('data', $data);

        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys=array('goback'=>'?c=famous_nav',   'subform'=>'?c=advise_index&a=advise_index_submit');
        app_tpl::assign('sys', $sys);
        app_tpl::display('advise_index.tpl');//����ģ��
    }

    /**
     * ��Ӻͱ༭
     */
    public function advise_index_add()
    {
        try
        {
            app_tpl::assign( 'npa', array('������', '�����ҳ���') );
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($step==2)
            {
                $data=$_POST;
                mod_advise_index::advise_index_add($data);                
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                mod_advert::update_cache_main_advert();
                mod_make_html::auto_update('index');
                mod_login::message("��ӹ��ɹ�.",'?c=advise_index&action='.$action);
                exit;
            }
            else
            {
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                $sys=array('goback'=>'?c=advise_index&action='.$action,   'subform'=>'?c=advise_index&a=advise_index_add&action='.$action);
                app_tpl::assign('sys', $sys);
            }
        }
        catch (Exception $e)
        {
            $data=(!isset($_POST))?'':$_POST;
            app_tpl::assign('data', $data);
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('advise_index_add.tpl');
    }

    /**
     * ������Ϣ
     */
    public function advise_index_save()
    {
        try
        {
            app_tpl::assign( 'npa', array('������', '�༭��ҳ���') );
            $data=array();
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($step==2)
            {
                $data=$_POST;
                mod_advise_index::advise_index_save($data,'save');
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                mod_advert::update_cache_main_advert();
                mod_make_html::auto_update('index');
                mod_login::message("�޸����ݳɹ�.",'?c=advise_index&action='.$action);
                exit;
            }
            else
            {
                $data['id']=(empty($_GET['id']))?'':$_GET['id'];
                $data=mod_advise_index::advise_index_save($data,'select');
                $action=(empty($_REQUEST['action']))?'':$_REQUEST['action'];
                $sys=array('goback'=>'?c=advise_index&action='.$action,   'subform'=>'?c=advise_index&a=advise_index_save');
                app_tpl::assign('sys', $sys);
                app_tpl::assign('data',$data);
                app_tpl::display('advise_index_add.tpl');//����ģ��,�ָ�   �����Ĥ�� .......  advise_index ���Բο�����  ͬһģ��
                exit;
            }
        }
        catch (Exception $e)
        {
            $data=(!isset($_POST))?'':$_POST;
            app_tpl::assign('data', $data);
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('advise_index_add.tpl');//����ģ��
    }

    /**
     * ����,ɾ��
     */
    public function advise_index_submit()
    {
        try
        {
            $subaction=(empty($_POST['subaction']))?'':$_POST['subaction'];
            $step=(empty($_POST['step']))?'':$_POST['step'];
            if($subaction=='display')
            {
                $this->advise_index_display();
            }
            elseif($subaction=='delete')
            {
                $this->advise_index_delete();
            }
            elseif($step==2)
            {
                throw new Exception("û����ִ�еĶ���");
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $this->advise_index_list();
    }

    /**
     * ����
     */
    public function advise_index_display()
    {
            $applyid=(!is_array($_POST['applyid']))?array():$_POST['applyid'];
            $select_id_all=(!is_array($_POST['select_id_all']))?array():$_POST['select_id_all'];
            $data = mod_advise_index::advise_index_display($applyid,$select_id_all);
            $action=(empty($_REQUEST['action']))?'header_1':$_REQUEST['action'];
            mod_login::message("��ʾ���óɹ�.",'?c=advise_index&action='.$action);
            exit;
    }

    /**
     * ɾ��
     */
    public function advise_index_delete()
    {
        $applyid='';
        $data=(empty($_POST['id']))?array():$_POST['id'];
        $data = mod_advise_index::advise_index_delete($data);
        mod_advert::update_cache_main_advert();
        mod_make_html::auto_update('index');
        $action=(empty($_REQUEST['action']))?'header_1':$_REQUEST['action'];
        mod_login::message("ɾ�����ݳɹ�.",'?c=advise_index&action='.$action);
        exit;
    }


}
?>
