<?php
/**
 * ��ҵ������������
 *
 * @author eric <0o0zzyZ@gmail.com>
 * @version    $Id: ctl_trade_class.php 902 2009-11-25 09:26:34Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_trade_class
{
    /**
     * �����б�
     */
    public function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('ר�����', '��ҵ�����б�') );
            if( isset($_POST['commit']) && $_POST['commit'] == 1)
            {
                if( $_GET['type'] == 'home' )
                {
                    $_POST['io'] = true;
                }
                mod_trade_class::update_class( $_POST,  $_POST['action'] );
                mod_login::message("����ɹ�!");
            }
            $class_id =  isset($_GET['classid']) ? $_GET['classid'] : '';

            $class_list = mod_trade_class::get_subclass_list(0);

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
            app_tpl::assign( 'npa', array('ר�����', '������ҵ����') );
            if(isset($_POST['classnewname']))
            {
                mod_trade_class::add_class( $_POST );
                if(!empty($_POST['mkhtml']))
                {
                    //ͬʱ����ҳ��
                }
            }
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
            app_tpl::assign( 'npa', array('ר�����', '�༭��ҵ����') );
            $id = isset($_GET['id']) ? intval($_GET['id']) : '';
            if( $_POST )
            {
                mod_trade_class::edit_class( $_POST );
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
            app_tpl::assign( 'info', mod_trade_class::get_a_class( $id ) );
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
            mod_trade_class::delete_class_and_update_cache( intval($_GET['id']) );
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
                echo iconv('utf-8', 'gbk', json_encode(mod_trade_class::search_class($_GET['k'])) );
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
            $varname =  isset($_GET['var']) ? trim($_GET['var']) : 'list';
            header("Content-type: text/html; charset=gbk");
            $result = mod_trade_class::get_subclass_list($_GET['id']);
            if(empty($result))
            {
                echo iconv('utf-8', 'gbk', json_encode($result));
                exit;
            }
            foreach($result as &$tmp)
            {
                $tmp['classname'] = iconv('gbk', 'utf-8//IGNORE', $tmp['classname']);
            }
            echo 'var ',$varname,'=',iconv('utf-8', 'gbk', json_encode($result));

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
            app_tpl::display( 'trade_class_list.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        }
    }
}
?>
