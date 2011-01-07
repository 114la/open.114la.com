<?php
/**
 * �ط����������������
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: ctl_local_class.php 1528 2009-12-07 09:36:38Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_local_class
{
    /**
     * �����б�
     */
    public function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('ר�����', '�ط���������б�') );
            if( isset($_POST['commit']) && $_POST['commit'] == 1)
            {
                if( $_GET['type'] == 'home' )
                {
                    $_POST['io'] = true;
                }
                mod_local_class::update_class( $_POST,  $_POST['action'] );
                mod_login::message("����ɹ�!");
            }
            $class_id =  isset($_GET['classid']) ? $_GET['classid'] : '';

            $class_list = mod_local_class::get_subclass_list(0);
            
            app_tpl::assign( 'classid', $class_id );
            app_tpl::assign( 'type', $type );
            app_tpl::assign( 'class_list', $class_list );
            app_tpl::assign( 'option_toggle', array( 0 => '��', 1 => '��' ) );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }

    }

    /**
     * ��ӷ���
     */
    public function add()
    {
        try
        {
            app_tpl::assign( 'npa', array('ר�����', '�����ط��������') );
            if(isset($_POST['classnewname']))
            {
                mod_local_class::add_class( $_POST );
                if(!empty($_POST['mkhtml']))
                {
                    //ͬʱ����ҳ��
                }
            }
            app_tpl::assign( 'class_list', mod_local_class::get_subclass_list(0) );
            app_tpl::assign( 'action', 'add' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * �޸ķ���
     */
    public function edit()
    {
        try
        {
            app_tpl::assign( 'npa', array('ר�����', '�༭�ط��������') );
            $id = isset($_GET['id']) ? intval($_GET['id']) : '';
            if( $_POST )
            {
                mod_local_class::edit_class( $_POST );
                if(!empty($_POST['mkhtml']))
                {
                    //ͬʱ����ҳ��
                }
                $_GET['classid'] =  isset($_POST['classid']) ? $_POST['classid'] : '';
            }

            app_tpl::assign( 'action', 'edit' );
            app_tpl::assign( 'classid', $_GET['classid']);
            app_tpl::assign( 'type', $_GET['type'] );
            app_tpl::assign( 'returnid', $_GET['classid'] );
            app_tpl::assign( 'info', mod_local_class::get_a_class( $id ) );
            app_tpl::assign( 'class_list', mod_local_class::get_subclass_list(0) );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * ɾ������
     */
    public function del()
    {
        try
        {
            if( !isset($_GET['id']) )
            {
                throw new Exception('id����Ϊ��');
            }
            mod_local_class::delete_class_and_update_cache( intval($_GET['id']) );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * ��������
     */
    public function search()
    {
        try
        {
            if( isset($_GET['k']) )
            {
                header("Content-type: text/html; charset=gbk");
                echo iconv('utf-8', 'gbk', json_encode(mod_local_class::search_class($_GET['k'])) );
            }
            exit;
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }

    /**
     * ajax��ȡ�����б�
     */
    public function ajax_get_list()
    {
        if( isset($_GET['id']) )
        {
            $id = intval($_GET['id']);
            header("Content-type: text/html; charset=gbk");
            $result = mod_local_class::get_subclass_list($_GET['id']);
            if(empty($result))
            {
                echo iconv('utf-8', 'gbk', json_encode($result));
                exit;
            }
            foreach($result as &$tmp)
            {
                $tmp['classname'] = iconv('gbk', 'utf-8//IGNORE', $tmp['classname']);
            }
            echo iconv('utf-8', 'gbk', json_encode($result));
        }
        exit;
    }

    /**
     * post���ӷ���
     */
    public function post()
    {
        try
        {
            app_tpl::display( 'local_class_list.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }
}
?>
