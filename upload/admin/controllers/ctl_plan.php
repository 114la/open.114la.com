<?php
/**
 * 任务计划
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    control
 * @version    $Id: ctl_plan.php 574 2009-11-23 13:45:52Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

/**
 * 计划任务控制器
 */
class ctl_plan
{

    /**
     * 预处理方法
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
            $weekdays = array( '*' => '*', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六', 7 => '星期天' );
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

            app_tpl::assign( 'option_toggle', array( 0 => '关闭', 1 => '开启' ) ); //开关选项
        }
    }

    /**
     * 新增计划任务
     *
     * @param none
     * @return none
     * @throws none
     */
    public function add()
    {
        app_tpl::assign( 'npa', array('系统管理', '新增任务') );
        if( ! empty( $_POST ) )
        {
            mod_plan::add_plan( $_POST );
            mod_login::message("添加成功!",'?c=plan&a=index');
        }
        app_tpl::assign( 'action', 'add' );
        app_tpl::display( 'plan.tpl' );
    } //end function add()


    /**
     * 删除计划任务
     *
     * @param none
     * @return none
     * @throws none
     */
    public function remove()
    {
    } //end function remove()


    /**
     * 编辑计划任务
     *
     * @param none
     * @return none
     * @throws none
     */
    public function edit()
    {
        try
        {
            app_tpl::assign( 'npa', array('系统管理', '编辑任务') );
            if( ! $_GET['id'] )
            {
                throw new Exception('id 不能为空');
            }
            if( ! empty( $_POST ) )
            {
                mod_plan::edit_plan( intval($_GET['id']),  $_POST );
                mod_login::message("修改成功!",'?c=plan&a=index');
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
     * 执行计划任务
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
            app_tpl::assign( 'npa', array('系统管理', '任务列表') );
            if( ! empty( $_POST['remove_id'] ) )
            {
                mod_plan::remove_plan( $_POST['remove_id'] );
                mod_login::message("删除成功!",'?c=plan&a=index');
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
