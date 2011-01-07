<?php
/**
 * ��½
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_login
{
/**
 * ��½
 */
    public function index()
    {
        $this->login();
    }

    /**
     * ��½
     */
    public function login()
    {

    //ctl_u_admin::instance();
        $auth = mod_login::instance();
        //        if($auth->is_login())//���Զ���ת
        //        {
        //            header("location: ./index.php?ctl=login&action=welcome");
        //        }
        if(isset($_POST["login"]))
        {
            $login_data = $_POST["login"];
            try
            {
                if($auth->authenticate($login_data))
                {
                    if(!$auth->is_login())//���Զ���ת

                    {
                        throw new Exception("���뿪��cookie.");
                    }
                    $url='./?c=login&a=frame';
                    // mod_login::message_login($url);
                    $this->frame();
                    exit;
                }
            }
            catch (Exception $e)
            {
                    app_tpl::assign('error', $e->getMessage());
                    app_tpl::assign('login', $login_data);
            }
        }
        app_tpl::display('login.tpl');
    }

    public function logout()
    {
        setcookie ( AUTH_KEY . '_admin_auth', '', time () - 35920000, PATH_COOKIE );
        header('location:?c=login');
    }

    /**
     * ������
     */
    public function frame()
    {
        app_tpl::display('admin.tpl');
    }
    public function frame_init()
    {
        app_tpl::display('admin.tpl');
    }
    /**
     * ����
     */
    public function header()
    {
        app_tpl::display('top.tpl');
    }
    /**
     * ������
     */
    public function menu()
    {
        $id=(empty($_GET['id']))?'':$_GET['id'];
        $data=mod_login::menu($id);
        app_tpl::assign('data', $data);
        app_tpl::display('menu.tpl');
    }

    /**
     * ��ӭҳ��
     */
    public function welcome()
    {
        $data = array();
        $data = mod_login::system_info();
        $how_site_new = mod_url_add::get_total(0);//  c=url_add&a=ulist&type=0
        $data['site_new']=$how_site_new;
        $data['site_url']='?c=url_add&type=0';

        $tmp = explode('/', dirname($_SERVER['PHP_SELF']));
        $data['safe_notice'] = (is_array($tmp) && !empty($tmp[count($tmp)-1]) && $tmp[count($tmp)-1] == 'admin') ? 1 : 0;
        
        $curtime = @file_get_contents( PATH_DATA . '/update/ver.txt' );
        
        app_tpl::assign('curver', CUR_VERSION);
        app_tpl::assign('curtime', $curtime);

        app_tpl::assign('data', $data);
        app_tpl::display('welcome.tpl');
    }
}

?>