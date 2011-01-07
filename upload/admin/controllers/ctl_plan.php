<?php
/**
 * ����ƻ�
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    control
 * @version    $Id: ctl_plan.php 574 2009-11-23 13:45:52Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

/**
 * �ƻ����������
 */
class ctl_plan
{

    /**
     * Ԥ������
     *
     * @param none
     * @return none
     * @throws none
     */
    public function pre()
    {
        if( isset($_GET['a']) && ( $_GET['a'] == 'add' || $_GET['a'] == 'edit' ))
        {
            $days['*'] = '*';
            for( $i = 1; $i <= 31; $i++ )
            {
                $days[$i] = $i;
            }

            app_tpl::assign( 'option_days', $days );
            $weekdays = array( '*' => '*', 1 => '����һ', 2 => '���ڶ�', 3 => '������', 4 => '������', 5 => '������', 6 => '������', 7 => '������' );
            app_tpl::assign( 'option_weekdays', $weekdays );

            $hours['*'] = '*';
            for( $i = 0; $i <= 23; $i++ )
            {
                $hours[$i] = $i;
            }

            app_tpl::assign( 'option_hours', $hours );

            $minutes['*'] = '*';
            for( $i = 0; $i <= 59; $i++ )
            {
                $minutes[$i] = $i;
            }
            app_tpl::assign( 'option_minutes', $minutes );

            app_tpl::assign( 'option_toggle', array( 0 => '�ر�', 1 => '����' ) ); //����ѡ��
        }
    }

    /**
     * �����ƻ�����
     *
     * @param none
     * @return none
     * @throws none
     */
    public function add()
    {
        app_tpl::assign( 'npa', array('ϵͳ����', '��������') );
        if( ! empty( $_POST ) )
        {
            mod_plan::add_plan( $_POST );
            mod_login::message("��ӳɹ�!",'?c=plan&a=index');
        }
        app_tpl::assign( 'action', 'add' );
        app_tpl::display( 'plan.tpl' );
    } //end function add()


    /**
     * ɾ���ƻ�����
     *
     * @param none
     * @return none
     * @throws none
     */
    public function remove()
    {
    } //end function remove()


    /**
     * �༭�ƻ�����
     *
     * @param none
     * @return none
     * @throws none
     */
    public function edit()
    {
        try
        {
            app_tpl::assign( 'npa', array('ϵͳ����', '�༭����') );
            if( ! $_GET['id'] )
            {
                throw new Exception('id ����Ϊ��');
            }
            if( ! empty( $_POST ) )
            {
                mod_plan::edit_plan( intval($_GET['id']),  $_POST );
                mod_login::message("�޸ĳɹ�!",'?c=plan&a=index');
                exit;
            }
            $plan = mod_plan::get_plan( $_GET['id'] );
            $plan['hour'] = explode( ',', $plan['hour'] );
            app_tpl::assign( 'action', 'edit' );
            app_tpl::assign( 'plan', $plan );
            app_tpl::display( 'plan.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        } 
    } //end function


    /**
     * ִ�мƻ�����
     *
     * @param none
     * @return none
     * @throws none
     */
    public function execute()
    {
        try
        {
            $id = $_GET['id'];
            mod_plan::execute_plan( $id );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        } 
    } //end function execute()


    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('ϵͳ����', '�����б�') );
            if( ! empty( $_POST['remove_id'] ) )
            {
                mod_plan::remove_plan( $_POST['remove_id'] );
                mod_login::message("ɾ���ɹ�!",'?c=plan&a=index');
            }
            $plan_list = mod_plan::get_plan_list();
            unset( $plan_list['plantime'] );
            app_tpl::assign( 'plan_list', $plan_list );
            app_tpl::display( 'plan.tpl' );
        }
        catch( Exception $e )
        {
            app_tpl::assign('error', $e->getMessage());
        } 
    }
}
