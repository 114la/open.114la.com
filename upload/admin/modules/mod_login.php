<?php

/**
 * ��½
 * @author  wushh <mailwushh@gmail.com>
 * @version    $Id: mod_login.php 1541 2009-12-11 07:54:41Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_login
{

    protected $user = null, $securimage = null;
    protected static $instance;

    public function __construct()
    {
        //������Ҫ����
    }

    /**
     * ʵ��
     * @return <type>
     */
    public static function instance()
    {
        if (self::$instance === null)
        {
            self::$instance = new mod_login();
        }
        return self::$instance;
    }

    /**
     * ��¼��֤
     */
    public function authenticate($data)
    {
        $timestamp = time();
        $admin_recordfile = PATH_ADMIN . "/data/log/admin_log.php";
        $F_count = F_L_count($admin_recordfile, 2000);
        $L_T = 3600 - ($timestamp - @filemtime($admin_recordfile)); //20������
        $L_left = 15 - $F_count;
        if ($F_count > 15 && $L_T > 0)
        {// ��¼ʧ�ܴ���������
            throw new Exception("������½���󳬹�15��,��20���Ӻ�����.");
        }

        if (is_dir(PATH_ROOT . '/install'))
        {
            //throw new Exception("��ɾ����װ�ļ���:install.");
        }

        $this->securimage = new mod_securimage();
        $username = trim(array_var($data, "name"));
        $password = trim(array_var($data, "password"));
        $securimage = trim(array_var($data, "securimage"));

        // ����  ���Ӵ����½��������
        if ($username == '')
        {
            self::log_error_login($username, $password);
            throw new Exception('�������¼�ʺţ�');
        }
        if ($password == '')
        {
            self::log_error_login($username, $password);
            throw new Exception('�������¼���룡');
        }
        else
        {
            $password = $password;
        }
        if (VERIFY_CODE == 1)
        {
            if ($securimage == '')
            {
                self::log_error_login($username, $password);
                throw new Exception('��������֤�룡');
            }
            else//�����Ҫ,�ٴ���ӹر���֤�빦��
            {
                if (!$this->securimage->check($securimage))
                {
                    throw new Exception('��������ȷ����֤�룡');
                }
            }
        }
        if (self::verify_login_in($username, $password))
        {
            $auth_key = self::get_user_agent();
            $auth_password = $password;
            $auth_username = $username;
            self::update_login($username);
            $cookie_value = base64_encode($auth_username . ':' . $auth_key . ':' . $auth_password);
            $cookie_expire = time () + 3600; //20����
            $cook_pre = AUTH_KEY . '_admin_auth';
            $_COOKIE[$cook_pre] = $cookie_value;
            setcookie(AUTH_KEY . '_admin_auth', $cookie_value, $cookie_expire, PATH_COOKIE);
            return true;
        }
    }

    /**
     * �����û���¼��Ϣ
     * @param <type> $username
     */
    public static function update_login($username)
    {
        $ip = get_client_ip();
        $update = "update ylmf_admin_user set lastvisit =" . time() . " , lastip='" . $ip . "'
					where name='{$username}' limit 1";
        app_db::query($update);
    }

    /**
     * ��֤�Ƿ��¼
     * @return boolean
     */
    public function is_login()
    {
        $cookie = array_var($_COOKIE, AUTH_KEY . '_admin_auth');
        if (isset($cookie) and !empty($cookie))
        {
            //username:username+password:$_SERVER['HTTP_USER_AGENT']
            $cookie_data = explode(':', base64_decode($cookie));
            if (count($cookie_data) == 3)
            {
                $current_cookie_auth = $cookie_data [1];
                if ($current_cookie_auth == $this->get_user_agent())
                {
                    $current_cookie_username = $cookie_data [0];
                    $current_cookie_password = $cookie_data [2];

                    if (self::verify_login_in($cookie_data [0], $cookie_data [2]))
                    {
                        $post = $_POST;
                        if ($_GET['c'] == 'config' && $_GET['a'] == 'mail')
                        {
                            unset($post['config']['smtppass']);
                        }
                        $_postdata = $post ? PostLog($post) : '';
                        $REQUEST_URI = $_SERVER['QUERY_STRING'] . '?' . $_SERVER['QUERY_STRING'];
                        $onlineip = get_client_ip();
                        $timestamp = time();
                        $admin_recordfile = PATH_ADMIN . "/data/log/admin_log.php";
                        $record_name = str_replace('|', '&#124;', Char_cv($cookie_data[0]));
                        $record_URI = str_replace('|', '&#124;', Char_cv($REQUEST_URI));
                        $new_record = "<?die;?>|$record_name|$record_URI|$onlineip|$timestamp|$_postdata|\n";
                        writeover($admin_recordfile, $new_record, "ab");
                        return true;
                    } // username_exists( )
                } //$current_cookie_auth
            }
        }
        return false;
    }

    /**
     * ��ȡ���ܴ�
     * @return <type>
     */
    public static function get_user_agent()
    {
        return md5(AUTH_KEY . '_' . $_SERVER ['HTTP_USER_AGENT']);
    }

    /**
     * ��֤��½�˻�,����
     * @param <type> $username
     * @param <type> $password
     * @return <type>
     */
    public static function verify_login_in($username, $password)
    {

        $password_md5 = md5($password);
        $select = "select * from ylmf_admin_user where
			`name`='$username' and `password`='$password_md5'  ";
        if (app_db::query($select))
        {
            $data = app_db::num_rows();

            if ($data > 0)
            {
                $auth_key = self::get_user_agent();
                $auth_password = $password;
                $auth_username = $username;
                $cookie_value = base64_encode($auth_username . ':' . $auth_key . ':' . $auth_password);
                $cookie_expire = time () + 3600; //20����
                $cook_pre = AUTH_KEY . '_admin_auth';
                $_COOKIE[$cook_pre] = $cookie_value;
                setcookie(AUTH_KEY . '_admin_auth', $cookie_value, $cookie_expire, PATH_COOKIE);

                defined('USERNAME') || define('USERNAME', $username);
                $row_info = app_db::fetch_one();
                //                defined('If_manager')||	define('If_manager',1);//����Ȩ�޿���
                if ($row_info['level'] == 1)//��������Ա
                {
                    defined('If_manager') || define('If_manager', 1);
                    $rightset = array();
                }
                else//��ͨ�û� //if($row_info['level']==1000)//����Ȩ�޿���
                {
                    defined('If_manager') || define('If_manager', 0);
                    $rightset = array();

                    $rightset = self::P_unserialize($row_info['adminright']);
                    $sys_con = self::get_control();
                    if (empty($sys_con) || ($sys_con == 'login' and (
                            empty($_GET['a']) ||
                            $_GET['a'] == 'login' ||
                            $_GET['a'] == 'logout' ||
                            $_GET['a'] == 'header' ||
                            $_GET['a'] == 'welcome' ||
                            $_GET['a'] == 'menu'
                            )) || $sys_con == 'securimage')
                    {

                    }
                    else //��ӵ�½ģ��
                    {
                        $if_auth = false;
                        foreach ($rightset as $k => $v)
                        {
                            $if_auth = strrpos($k, $sys_con);
                            if (is_int($if_auth)
                                )break;
                        }
                        //if(1==@$rightset[$sys_con])//��Ȩ�����ɽ���,�õ�Ȩ��,���峣�� serialize
                        if (is_int($if_auth))
                        {
                            return true;
                        }
                        else
                        {
                            $error = 'û�ж�Ӧ�Ĳ���Ȩ��.';
                            //$http = empty($_SERVER['HTTP_REFERER']) ? './?ctl=login&action=welcome' : $_SERVER['HTTP_REFERER'];
                            $http = './?c=login&a=welcome';
                            $stop_loop = 0; //ûȨ�޲���ת
                            self::message($error, $http, 500000, $stop_loop);
                            exit();
                        }
                    }
                }



                $admin_recordfile = PATH_ADMIN . "/data/log/admin_log.php";
                $onlineip = get_client_ip();
                $new_record = "<?die;?>|$username|***|Logging Failed|$onlineip|" . time() . "|\n"; //��½��������
                //writeover($admin_recordfile,$new_record,"ab");

                return true;
            }
            else
            {
                self::log_error_login($username, $password);
                setcookie(AUTH_KEY . '_admin_auth', 0, 100, '/', PATH_COOKIE);
                //             throw new Exception("�˺Ż��������!");
                app_tpl::assign('error', '�˺Ż��������');
                app_tpl::display('login.tpl');
                exit;
            }
        }
        else
        {
            throw new Exception('���ݿ�������');
        }
    }

    /**
     * д���½������־
     * @param <type> $username
     * @param <type> $password
     */
    public function log_error_login($username, $password)
    {
        $admin_recordfile = PATH_ADMIN . "/data/log/admin_log.php";
        $onlineip = get_client_ip();
        $new_record = "<?die;?>|$username|$password|Logging Failed|$onlineip|" . time() . "|\n"; //��½��������
        writeover($admin_recordfile, $new_record, "ab");
    }

    /**
     * ����ϵͳ����
     * @param <type> $id
     */
    public static function menu($id)
    {
        $data = array();
        //�õ�verify����ĳ���, ����configĿ¼��  cfg_menu.php
        //���Ȩ��,���������ļ�.
        $menu = array
            (
            '������ҳ' => array
                (
                '����ѡ��' => array
                    (
                    '�����ַ' => '?c=site_manage&a=edit&action=add',
                    'һ������' => '?c=make_html',
                    '��¼����' => '?c=url_add',
                    '�������' => '?c=feedback',
                    '�û�����' => '?c=member',
                ),
                '��ַ����' => array
                    (
                    '�������' => '?c=class&a=index&type=2',
                    '��ַ����' => '?c=site_manage',
                    '�������ӹ���' => '?c=links',
                    '���������ַ' => '?c=site_manage&a=multi_add',
                    '����������ַ' => '?c=site_manage&a=import',
                )
            ),
            'ϵͳ����' => array
                (
                '��������' => array
                    (
                    '��������' => '?c=config&a=info',
                    '״̬����' => '?c=config&a=status',
                    '��������' => '?c=config&a=fn',
                    '��������' => '?c=config&a=mail',
                    '��������' => '?c=config&a=index',
                ),
                '��ȫ����' => array
                    (
                    '������ȫ����' => '?c=security&a=agent',
                    'CC��������' => '?c=security&a=cc',
                ),
                '�ƻ�����' => array
                    (
                    '�������' => '?c=plan',
                    '�������' => '?c=plan&a=add',
                ),
                '��־����' => array
                    (
                    '����Ա��־' => '?c=log&a=log_admin',
                )
            ),
            '��ַ����' => array
                (
                '��ҳ����' => array
                    (
                    '��վ����' => '?c=famous_nav',
                    '��վ����' => '?c=mztop',
                    //'��վ�ֲ���վ'=>'?c=famous_loop',
                    '��վ�л���' => '?c=famous_tab',
                    '��վ����' => '?c=cool_class',
                    '��վ��ַ' => '?c=cool_site',
                    '��ҳʵ�ù���' => '?c=index_tool',
                    '�������ӹ���' => '?c=links',
                ),
                '��ַ����' => array
                    (
                    '�������' => '?c=class&a=index&type=2',
                    '��ַ����' => '?c=site_manage',
                    '���������ַ' => '?c=site_manage&a=multi_add',
                    '����������ַ' => '?c=site_manage&a=import',
                    '��ַ����վ' => '?c=recycler',
                ),
            ),
            'ר�����' => array
                (
                '���ε�������' => array
                    (
                    'ר��������' => '?c=zhuanti_class',
                    'ר����վ����' => '?c=zhuanti',
                ),
                '�ط�����ר��' => array
                    (
                    '�ط���ҳվ��' => '?c=local_index',
                    '�ط��������' => '?c=local_class',
                    '�ط�������վ' => '?c=local_site',
                ),
                '��ҵר�����' => array
                    (
                    '��ҵ����' => '?c=trade_class',
                    '��ҵ��ַ����' => '?c=trade_site',
                ),
            ),
            '������' => array
                (
                '������' => array
                    (
                    '��ҳ�������' => '?c=advise_index&action=header',
                    '��վ�Ϸ��Ƽ���' => '?c=advise_index&action=footer',
                    '��վ�·��Ƽ���' => '?c=advise_index&action=notice',
                    '�����ؼ��ʹ���' => '?c=key',
                    '�����ؼ��ʱ�ǩ' => '?c=keyword_class',
                    '��ҳ�������Ź���' => '?c=notice&a=index',
                ),
            ),
            '���ݹ���' => array(
                '���ݹ���' => array
                    (
                    '���ݿⱸ��' => '?c=backup',
                    '���ݿ⵼��' => '?c=restore',
                    '���ݿ��Ż��޸�' => '?c=repair',
                    '�����������' => '?c=clear',
                ),
            ),
            'ģ�����' => array
            (
                'ģ��ѡ��' => array
                (
                    'ģ��ѡ��' => '?c=template_manage&a=cur_tpl',
                ),
                'ģ��༭' => array
                (
                    '��ҳģ��' => '?c=template_manage&action=modify&filename=index.tpl',
                    '��ҳ����ģ��' => '?c=template_manage&action=modify&filename=kp.tpl',
                    //'����ģ�����' => '?c=template_manage&action=modify&filename=class.tpl',
                    '����ģ��' => '?c=template_manage&a=template_list',
                    '������¼ģ��' => '?c=template_manage&action=modify&filename=url_submit.tpl',
                    '�������ģ��' => '?c=template_manage&action=modify&filename=feedback.tpl',
                    '�ط�������ҳ' => '?c=template_manage&action=modify&filename=local_index.tpl',
                    '�ط�������ҳ' => '?c=template_manage&action=modify&filename=local_sites.tpl',
                    '��ҵ��վģ��' => '?c=template_manage&action=modify&filename=trade_sites.tpl',
                ),
            ),
            '��̬����' => array
            (
                '��̬����' => array
                (
                    'һ������ѡ��' => '?c=make_html',
                    '��̬����Ŀ¼����' => '?c=make_html&a=set',
                ),
            ),
            '��������' => array
            (
                '��������' => array
                (
                    '�����������' => '?c=search_class',
                    '�����������' => '?c=search',
                    '�����ؼ���' => '?c=search_keyword',
                ),
            ),
            '�������' => mod_plugin::get_plugins_menu(),
        );
        switch ($id)
        {
            case 0:
                $nam = '������ҳ';
                break;
            case 1:
                $nam = 'ϵͳ����';
                break;
            case 2:
                $nam = '��ַ����';
                break;
            case 3:
                $nam = 'ר�����';
                break;
            case 4:
                $nam = '������';
                break;
            case 5:
                $nam = '���ݹ���';
                break;
            case 6:
                $nam = 'ģ�����';
                break;
            case 7:
                $nam = '��̬����';
                break;
            case 8:
                $nam = '�������';
                break;
            case 9:
                $nam = '��������';
                break;
        }
        $output = '';
        foreach ($menu as $key => $val)
        {
            if ($key == $nam)
            {
                foreach ($val as $k1 => $v1)
                {
                    $output.="<div class='item'><h2>{$k1}<span class='close'>����</span></h2><ul>";
                    foreach ($v1 as $k2 => $v2)
                    {
                        $output.="<li><a href='{$v2}' target='main' >{$k2}</a></li>";
                    }
                    $output.='</ul></div>';
                }
            }
        }


        return $output;
    }

    /**
     *  ϵͳ��Ϣ
     *
     */
    public static function system_info()
    {
        define("YES", "<span class='resYes'>YES</span>");
        define("NO", "<span class='resNo'>NO</span>");
        // ϵͳ������Ϣ
        $serverapi = strtoupper(php_sapi_name());
        $phpversion = PHP_VERSION;
        $systemversion = explode(" ", php_uname());
        $sysReShow = 'none';
        switch (PHP_OS)
        {
            case "Linux":
                $sysReShow = (false !== ($sysInfo = self::sys_linux())) ? "show" :
                        "none";
                $sysinfo = $systemversion[0] . '   ' . $systemversion[2];
                break;
            case "FreeBSD":
                $sysReShow = (false !== ($sysInfo = self::sys_freebsd())) ? "show" :
                        "none";
                $sysinfo = $systemversion[0] . '   ' . $systemversion[2];
                break;
            default:
                $sysinfo = $systemversion[0] . '  ' . $systemversion[1] . ' ' . $systemversion[3] . $systemversion[4] . $systemversion[5];
                break;
        }
        if ($sysReShow == 'show')
        {
            $pmemory = '��' . $sysInfo['memTotal'] . 'M, ��ʹ��' . $sysInfo['memUsed'] . 'M, ����' . $sysInfo['memFree'] . 'M, ʹ����' . $sysInfo['memPercent'] . '%';
            $pmemorybar = $sysInfo['memPercent'];
            $swapmomory = '��' . $sysInfo['swapTotal'] . 'M, ��ʹ��' . $sysInfo['swapUsed'] . 'M, ����' . $sysInfo['swapFree'] . 'M, ʹ����' . $sysInfo['swapPercent'] . '%';
            $swapmemorybar = $sysInfo['swapPercent'];
            $syslaodavg = $sysInfo['loadAvg'];
        }
        app_db::query("SELECT VERSION() AS dbversion");
        $mysql = app_db::fetch_one();
        $mysql = $mysql['dbversion'];
        $phpsafe = self::getcon("safe_mode");
        $dispalyerror = self::getcon("display_errors");
        $allowurlopen = self::getcon("allow_url_fopen");
        $registerglobal = self::getcon("register_globals");
        $maxpostsize = self::getcon("post_max_size");
        $maxupsize = self::getcon("upload_max_filesize");
        $maxexectime = self::getcon("max_execution_time") . 's';
        $mqqsp = get_magic_quotes_gpc() === 1 ? YES : NO;
        $mprsp = get_magic_quotes_runtime() === 1 ? YES : NO;
        $zendoptsp = (get_cfg_var("zend_optimizer.optimization_level") || get_cfg_var("zend_extension_manager.optimizer_ts") || get_cfg_var("zend_extension_ts")) ? YES : NO;
        $iconvsp = self::isfun('iconv');
        $curlsp = self::isfun('curl_init');
        $gdsp = self::isfun('gd_info');
        $zlibsp = self::isfun('gzclose');
        $eaccsp = self::isfun('eaccelerator_info');
        $xcachesp = extension_loaded('XCache') ? YES : NO;
        $sessionsp = self::isfun("session_start");
        $cookiesp = isset($_COOKIE) ? YES : NO;
        $serverip = @gethostbyname($_SERVER['SERVER_NAME']);
        $serverip = $serverip == '' ? '' : "  ($serverip)";
        $systime = gmdate("Y��n��j�� H:i:s", time() + 8 * 3600);
        $phpversionsp = $phpversion > '5.0' ? YES : NO;
        $mysqlversionsp = $mysql['dbversion'] > '4.1' ? YES : NO;
        $dbasp = extension_loaded('dba') ? YES : NO;
        // ���ݿ��С
        $databasesize = 0;
        app_db::query("SHOW TABLE STATUS");
        while ($rs = app_db::fetch_one())
        {
            $databasesize +=$rs['Data_length'] + $rs['Index_length'];
        }
        $databasesize = bytes_to_string($databasesize);
        //վ��ͳ��
        app_db::query("SELECT count(*) as sum FROM ylmf_site");
        $rt = app_db::fetch_one();
        $sitesum = $rt['sum'];

        //        // memcache
        //        if ($yl_enmemcache)
        //        {
        //            $memcache = new Memcache;
        //            $memcache->connect($yl_memcacheserver, $yl_memcacheport) or die ("Could not connect");
        //            $stat=$memcache->getExtendedStats();
        //            $memcachestat=$stat[$yl_memcacheserver.':'.$yl_memcacheport];
        //        //print_r($memcachestat);
        //        }
        //ϵͳ��־��С����������ʾ
        $noticemsg = '';
        if (@filesize(PATH_DATA . '/log/admin_log.php') > 409600)
        {
            $noticemsg = '��̨��¼��־';
        }
        if (@filesize(PATH_DATA . '/log/php_error.log') > 409600)
        {
            $data['noticemsg'] = 'PHP������־';
        }
        if (@filesize(PATH_DATA . '/log/mysql_error.php') > 409600)
        {
            $data['noticemsg'] = 'mysql��־';
        }

        $data['serverip'] = $serverip;
        $data['systime'] = $systime;
        $data['sysinfo'] = $sysinfo;
        $data['phpversion'] = $phpversion;
        $data['dbversion'] = $mysql;
        $data['dispalyerror'] = $dispalyerror;
        $data['serverapi'] = $serverapi;
        $data['phpsafe'] = $phpsafe;
        $data['sessionsp'] = $sessionsp;
        $data['cookiesp'] = $cookiesp;
        $data['phpsafe'] = $phpsafe;
        $data['zendoptsp'] = $zendoptsp;
        $data['eaccsp'] = $eaccsp;
        $data['xcachesp'] = $xcachesp;
        $data['registerglobal'] = $registerglobal;
        $data['mqqsp'] = $mqqsp;
        $data['mprsp'] = $mprsp;
        $data['maxupsize'] = $maxupsize;
        $data['maxpostsize'] = $maxpostsize;
        $data['maxexectime'] = $maxexectime;
        $data['allowurlopen'] = $allowurlopen;
        $data['curlsp'] = $curlsp;
        $data['iconvsp'] = $iconvsp;
        $data['zlibsp'] = $zlibsp;
        $data['gdsp'] = $gdsp;
        $data['dbasp'] = $dbasp;
        $data['datasize'] = $databasesize;
        $data['sitesum'] = $sitesum;

        return $data;
    }

    /**
     * ��ת����(������loginģ��)
     * @param <type> $message
     * @param <type> $url
     * @param <type> $timeout     Ĭ��:2����ת
     * @param <type> $stop_loop   1:ֹͣ����,   Ĭ��0:�Զ���ת
     */
    public static function message($message, $url = null, $timeout = 2, $stop_loop=0)
    {
        if ($url == null)
        {
            $url = $_SERVER['HTTP_REFERER'];
        }
        app_tpl::assign('stop_loop', $stop_loop);
        app_tpl::assign('url_page', $url);
        app_tpl::assign('message', $message);
        app_tpl::assign('timeout', $timeout);
        app_tpl::display('message.tpl');
        exit();
    }

    public static function message_login($url = null, $timeout = 2000)
    {
        if ($url == null)
        {
            $url = $_SERVER['HTTP_REFERER'];
        }
        app_tpl::assign('url_page', $url);
        app_tpl::assign('timeout', $timeout);
        app_tpl::display('init.tpl');
        exit();
    }

    /**
     * ��ȡ����Ա�û���
     * @return <type>
     */
    public static function get_username()
    {
        if (defined('USERNAME'))
        {
            return USERNAME;
        }
        else
        {
            $error = '��û�е�¼.';
            //$http = empty($_SERVER['HTTP_REFERER']) ? './?ctl=login&action=welcome' : $_SERVER['HTTP_REFERER'];
            $http = './?c=login';
            $stop_loop = 0; //ûȨ�޲���ת
            self::message($error, $http, 1000, $stop_loop);
            exit();
        }
    }

    /**
     * ��Ȩ���û��������л�����
     * @param <type> $str
     * @param <type> $array
     * @param <type> $i
     * @return <type>
     */
    public static function P_unserialize($str, $array = array(), $i = 1)
    {
        $str = explode("\n$i\n", $str);
        foreach ($str as $key => $value)
        {
            $k = substr($value, 0, strpos($value, "\t"));
            $v = substr($value, strpos($value, "\t") + 1);
            if (strpos($v, "\n") !== false)
            {
                $next = $i + 1;
                $array[$k] = self::P_unserialize($v, @$array[$k], $next);
            }
            elseif (strpos($v, "\t") !== false)
            {
                $array[$k] = P_array($array[$k], $v);
            }
            else
            {
                $array[$k] = $v;
            }
        }
        return $array;
    }

    public static function P_array($array, $string)
    {
        $k = substr($string, 0, strpos($string, "\t"));
        $v = substr($string, strpos($string, "\t") + 1);
        if (strpos($v, "\t") !== false)
        {
            $array[$k] = P_array($array[$k], $v);
        }
        else
        {
            $array[$k] = $v;
        }
        return $array;
    }

    /*
     * �õ�����������
     */

    public static function get_control()
    {
        return (empty($_GET['c'])) ? 'login' : $_GET['c'];
    }

    public static function getcon($varName)
    {
        switch ($res = get_cfg_var($varName))
        {
            case 0:
                return NO;
                break;
            case 1:
                return YES;
                break;
            default:
                return $res;
                break;
        }
    }

    /**
     * ��⺯���Ƿ����
     * @param <type> $funName
     * @return <type>
     */
    public static function isfun($funName)
    {
        return (false !== function_exists($funName)) ? YES : NO;
    }

    /**
     *  linux ϵͳ��Ϣ
     * @return <type>
     */
    public static function sys_linux()
    {
        // CPU
        if (false === ($str = @file("/proc/cpuinfo")))
            return false;
        $str = implode("", $str);
        @preg_match_all("/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(.@\.]+)[\r\n]+/", $str, $model);
        //@preg_match_all("/cpu\s+MHz\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $mhz);
        @preg_match_all("/cache\s+size\s{0,}\:+\s{0,}([\d\.]+\s{0,}[A-Z]+[\r\n]+)/", $str, $cache);
        if (false !== is_array($model[1]))
        {
            $res['cpu']['num'] = sizeof($model[1]);
            for ($i = 0; $i < $res['cpu']['num']; $i++)
            {
                $res['cpu']['detail'][] = "���ͣ�" . $model[1][$i] . " ���棺" . $cache[1][$i];
            }
            if (false !== is_array($res['cpu']['detail']))
                $res['cpu']['detail'] = implode("<br />", $res['cpu']['detail']);
        }


        // UPTIME
        if (false === ($str = @file("/proc/uptime")))
            return false;
        $str = explode(" ", implode("", $str));
        $str = trim($str[0]);
        $min = $str / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0)
            $res['uptime'] = $days . "��";
        if ($hours !== 0)
            $res['uptime'] .= $hours . "Сʱ";
        $res['uptime'] .= $min . "����";

        // MEMORY
        if (false === ($str = @file("/proc/meminfo")))
            return false;
        $str = implode("", $str);
        preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);

        $res['memTotal'] = round($buf[1][0] / 1024, 2);
        $res['memFree'] = round($buf[2][0] / 1024, 2);
        $res['memUsed'] = ($res['memTotal'] - $res['memFree']);
        $res['memPercent'] = (floatval($res['memTotal']) != 0) ? round($res['memUsed'] / $res['memTotal'] * 100, 2) : 0;

        $res['swapTotal'] = round($buf[3][0] / 1024, 2);
        $res['swapFree'] = round($buf[4][0] / 1024, 2);
        $res['swapUsed'] = ($res['swapTotal'] - $res['swapFree']);
        $res['swapPercent'] = (floatval($res['swapTotal']) != 0) ? round($res['swapUsed'] / $res['swapTotal'] * 100, 2) : 0;

        // LOAD AVG
        if (false === ($str = @file("/proc/loadavg")))
            return false;
        $str = explode(" ", implode("", $str));
        $str = array_chunk($str, 3);
        $res['loadAvg'] = implode(" ", $str[0]);

        return $res;
    }

    // freebsd ϵͳ��Ϣ
    public static function sys_freebsd()
    {
        //CPU
        if (false === ($res['cpu']['num'] = get_key("hw.ncpu")))
            return false;
        $res['cpu']['detail'] = get_key("hw.model");

        //LOAD AVG
        if (false === ($res['loadAvg'] = get_key("vm.loadavg")))
            return false;
        $res['loadAvg'] = str_replace("{", "", $res['loadAvg']);
        $res['loadAvg'] = str_replace("}", "", $res['loadAvg']);

        //UPTIME
        if (false === ($buf = get_key("kern.boottime")))
            return false;
        $buf = explode(' ', $buf);
        $sys_ticks = time() - intval($buf[3]);
        $min = $sys_ticks / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0)
            $res['uptime'] = $days . "��";
        if ($hours !== 0)
            $res['uptime'] .= $hours . "Сʱ";
        $res['uptime'] .= $min . "����";

        //MEMORY
        if (false === ($buf = get_key("hw.physmem")))
            return false;
        $res['memTotal'] = round($buf / 1024 / 1024, 2);
        $buf = explode("\n", do_command("vmstat", ""));
        $buf = explode(" ", trim($buf[2]));

        $res['memFree'] = round($buf[5] / 1024, 2);
        $res['memUsed'] = ($res['memTotal'] - $res['memFree']);
        $res['memPercent'] = (floatval($res['memTotal']) != 0) ? round($res['memUsed'] / $res['memTotal'] * 100, 2) : 0;

        $buf = explode("\n", do_command("swapinfo", "-k"));
        $buf = $buf[1];
        preg_match_all("/([0-9]+)\s+([0-9]+)\s+([0-9]+)/", $buf, $bufArr);
        $res['swapTotal'] = round($bufArr[1][0] / 1024, 2);
        $res['swapUsed'] = round($bufArr[2][0] / 1024, 2);
        $res['swapFree'] = round($bufArr[3][0] / 1024, 2);
        $res['swapPercent'] = (floatval($res['swapTotal']) != 0) ? round($res['swapUsed'] / $res['swapTotal'] * 100, 2) : 0;


        return $res;
    }

}

?>
