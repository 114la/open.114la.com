<?php
/**
 * ��־����
 *  1.����Ա������־   log_admin
 *  2.php������־       php��־
 *  3.mysql������־     mysql��־
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_log extends mod_auth
{
    function index()
    {
        $this->log_admin();
    }

    public function log($type='admin',$tpl='log_admin.tpl')
    {
        try
        {
            app_tpl::assign( 'npa', array('ϵͳ����', '����Ա��־') );
            $data=mod_log::log_admin($type);//define the filename
            app_tpl::assign('data', $data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        switch ($type)
        {
            case 'admin':
                $sys=array('formurl'=>'?c=log&a=log_admin',  );
                app_tpl::assign('sys', $sys);
                app_tpl::display('log_admin.tpl');
                break;

            case 'php':
                app_tpl::display('log_php.tpl');
                break;

            case 'mysql':
                app_tpl::display('log_mysql.tpl');
                break;
        }
    }
    function log_admin()//default for list  include search
    {
       $this->log();
    }
    function log_php()//default for list  include search
    {
       $this->log('php');
    }
    function log_mysql()//default for list  include search
    {
       $this->log('mysql');
    }

    /**
     *  ɾ����־,ʣ��100��.?c=log&a=log_admin_delete&delete=yes
     */
    function log_admin_delete()
    {
        try
        {
            $a=(empty($_GET['a']))?'admin':$_GET['a'];
            $filename='';
            switch ($a)
            {
                case 'log_admin_delete':
                    $filename='admin';
                    break;

                case 'log_php_delete':
                    $filename='php';
                    break;

                case 'log_mysql_delete':
                    $filename='mysql';
                    break;
            }
            $action=(empty($_GET['delete']))?'':$_GET['delete'];
            mod_log::log_admin_delete($action,$filename);//define the filename
            mod_login::message('����Ա��־�Ѿ�ɾ��,ϵͳ���������100��.',"?c=log&a=log_".$filename);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $this->log($filename);
    }
    function log_php_delete()
    {
        $this->log_admin_delete();
    }
    function log_mysql_delete()
    {
        $this->log_admin_delete();
    }



}
?>
