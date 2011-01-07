<?php

/**
 * 登陆
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
        //载入需要的类
    }

    /**
     * 实例
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
     * 登录验证
     */
    public function authenticate($data)
    {
        $timestamp = time();
        $admin_recordfile = PATH_ADMIN . "/data/log/admin_log.php";
        $F_count = F_L_count($admin_recordfile, 2000);
        $L_T = 3600 - ($timestamp - @filemtime($admin_recordfile)); //20分钟内
        $L_left = 15 - $F_count;
        if ($F_count > 15 && $L_T > 0)
        {// 登录失败次数过多检测
            throw new Exception("连续登陆错误超过15次,请20分钟后再试.");
        }

        if (is_dir(PATH_ROOT . '/install'))
        {
            //throw new Exception("请删除安装文件夹:install.");
        }

        $this->securimage = new mod_securimage();
        $username = trim(array_var($data, "name"));
        $password = trim(array_var($data, "password"));
        $securimage = trim(array_var($data, "securimage"));

        // 检验  增加错误登陆次数限制
        if ($username == '')
        {
            self::log_error_login($username, $password);
            throw new Exception('请输入登录帐号！');
        }
        if ($password == '')
        {
            self::log_error_login($username, $password);
            throw new Exception('请输入登录密码！');
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
                throw new Exception('请输入验证码！');
            }
            else//如果需要,再次添加关闭验证码功能
            {
                if (!$this->securimage->check($securimage))
                {
                    throw new Exception('请输入正确的验证码！');
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
            $cookie_expire = time () + 3600; //20分钟
            $cook_pre = AUTH_KEY . '_admin_auth';
            $_COOKIE[$cook_pre] = $cookie_value;
            setcookie(AUTH_KEY . '_admin_auth', $cookie_value, $cookie_expire, PATH_COOKIE);
            return true;
        }
    }

    /**
     * 更新用户登录信息
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
     * 验证是否登录
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
     * 获取加密串
     * @return <type>
     */
    public static function get_user_agent()
    {
        return md5(AUTH_KEY . '_' . $_SERVER ['HTTP_USER_AGENT']);
    }

    /**
     * 验证登陆账户,密码
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
                $cookie_expire = time () + 3600; //20分钟
                $cook_pre = AUTH_KEY . '_admin_auth';
                $_COOKIE[$cook_pre] = $cookie_value;
                setcookie(AUTH_KEY . '_admin_auth', $cookie_value, $cookie_expire, PATH_COOKIE);

                defined('USERNAME') || define('USERNAME', $username);
                $row_info = app_db::fetch_one();
                //                defined('If_manager')||	define('If_manager',1);//开启权限控制
                if ($row_info['level'] == 1)//超级管理员
                {
                    defined('If_manager') || define('If_manager', 1);
                    $rightset = array();
                }
                else//普通用户 //if($row_info['level']==1000)//开启权限控制
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
                    else //添加登陆模块
                    {
                        $if_auth = false;
                        foreach ($rightset as $k => $v)
                        {
                            $if_auth = strrpos($k, $sys_con);
                            if (is_int($if_auth)
                                )break;
                        }
                        //if(1==@$rightset[$sys_con])//对权限生成解析,得到权限,定义常量 serialize
                        if (is_int($if_auth))
                        {
                            return true;
                        }
                        else
                        {
                            $error = '没有对应的操作权限.';
                            //$http = empty($_SERVER['HTTP_REFERER']) ? './?ctl=login&action=welcome' : $_SERVER['HTTP_REFERER'];
                            $http = './?c=login&a=welcome';
                            $stop_loop = 0; //没权限不跳转
                            self::message($error, $http, 500000, $stop_loop);
                            exit();
                        }
                    }
                }



                $admin_recordfile = PATH_ADMIN . "/data/log/admin_log.php";
                $onlineip = get_client_ip();
                $new_record = "<?die;?>|$username|***|Logging Failed|$onlineip|" . time() . "|\n"; //登陆次数限制
                //writeover($admin_recordfile,$new_record,"ab");

                return true;
            }
            else
            {
                self::log_error_login($username, $password);
                setcookie(AUTH_KEY . '_admin_auth', 0, 100, '/', PATH_COOKIE);
                //             throw new Exception("账号或密码错误!");
                app_tpl::assign('error', '账号或密码错误');
                app_tpl::display('login.tpl');
                exit;
            }
        }
        else
        {
            throw new Exception('数据库语句错误');
        }
    }

    /**
     * 写入登陆错误日志
     * @param <type> $username
     * @param <type> $password
     */
    public function log_error_login($username, $password)
    {
        $admin_recordfile = PATH_ADMIN . "/data/log/admin_log.php";
        $onlineip = get_client_ip();
        $new_record = "<?die;?>|$username|$password|Logging Failed|$onlineip|" . time() . "|\n"; //登陆次数限制
        writeover($admin_recordfile, $new_record, "ab");
    }

    /**
     * 载入系统导航
     * @param <type> $id
     */
    public static function menu($id)
    {
        $data = array();
        //得到verify定义的常量, 放在config目录下  cfg_menu.php
        //结合权限,解析配置文件.
        $menu = array
            (
            '管理首页' => array
                (
                '常用选项' => array
                    (
                    '添加网址' => '?c=site_manage&a=edit&action=add',
                    '一键生成' => '?c=make_html',
                    '收录管理' => '?c=url_add',
                    '意见反馈' => '?c=feedback',
                    '用户管理' => '?c=member',
                ),
                '网址管理' => array
                    (
                    '分类管理' => '?c=class&a=index&type=2',
                    '网址管理' => '?c=site_manage',
                    '友情链接管理' => '?c=links',
                    '批量添加网址' => '?c=site_manage&a=multi_add',
                    '批量导入网址' => '?c=site_manage&a=import',
                )
            ),
            '系统管理' => array
                (
                '基本设置' => array
                    (
                    '资料设置' => '?c=config&a=info',
                    '状态设置' => '?c=config&a=status',
                    '功能设置' => '?c=config&a=fn',
                    '邮箱设置' => '?c=config&a=mail',
                    '所有设置' => '?c=config&a=index',
                ),
                '安全设置' => array
                    (
                    '基本安全设置' => '?c=security&a=agent',
                    'CC防护设置' => '?c=security&a=cc',
                ),
                '计划任务' => array
                    (
                    '任务管理' => '?c=plan',
                    '添加任务' => '?c=plan&a=add',
                ),
                '日志管理' => array
                    (
                    '管理员日志' => '?c=log&a=log_admin',
                )
            ),
            '网址管理' => array
                (
                '首页管理' => array
                    (
                    '名站管理' => '?c=famous_nav',
                    '名站首行' => '?c=mztop',
                    //'名站轮播网站'=>'?c=famous_loop',
                    '名站切换栏' => '?c=famous_tab',
                    '酷站分类' => '?c=cool_class',
                    '酷站网址' => '?c=cool_site',
                    '首页实用工具' => '?c=index_tool',
                    '友情链接管理' => '?c=links',
                ),
                '网址管理' => array
                    (
                    '分类管理' => '?c=class&a=index&type=2',
                    '网址管理' => '?c=site_manage',
                    '批量添加网址' => '?c=site_manage&a=multi_add',
                    '批量导入网址' => '?c=site_manage&a=import',
                    '网址回收站' => '?c=recycler',
                ),
            ),
            '专题管理' => array
                (
                '网游单机工具' => array
                    (
                    '专题分类管理' => '?c=zhuanti_class',
                    '专题网站管理' => '?c=zhuanti',
                ),
                '地方服务专题' => array
                    (
                    '地方首页站点' => '?c=local_index',
                    '地方服务分类' => '?c=local_class',
                    '地方服务网站' => '?c=local_site',
                ),
                '行业专题管理' => array
                    (
                    '行业分类' => '?c=trade_class',
                    '行业网址管理' => '?c=trade_site',
                ),
            ),
            '广告管理' => array
                (
                '广告管理' => array
                    (
                    '首页顶部广告' => '?c=advise_index&action=header',
                    '名站上方推荐栏' => '?c=advise_index&action=footer',
                    '名站下方推荐栏' => '?c=advise_index&action=notice',
                    '搜索关键词管理' => '?c=key',
                    '搜索关键词标签' => '?c=keyword_class',
                    '首页滚动新闻管理' => '?c=notice&a=index',
                ),
            ),
            '数据管理' => array(
                '数据管理' => array
                    (
                    '数据库备份' => '?c=backup',
                    '数据库导入' => '?c=restore',
                    '数据库优化修复' => '?c=repair',
                    '清空所有数据' => '?c=clear',
                ),
            ),
            '模板管理' => array
            (
                '模板选择' => array
                (
                    '模板选择' => '?c=template_manage&a=cur_tpl',
                ),
                '模板编辑' => array
                (
                    '首页模板' => '?c=template_manage&action=modify&filename=index.tpl',
                    '首页宽屏模板' => '?c=template_manage&action=modify&filename=kp.tpl',
                    //'分类模版管理' => '?c=template_manage&action=modify&filename=class.tpl',
                    '分类模板' => '?c=template_manage&a=template_list',
                    '申请收录模板' => '?c=template_manage&action=modify&filename=url_submit.tpl',
                    '意见反馈模板' => '?c=template_manage&action=modify&filename=feedback.tpl',
                    '地方服务首页' => '?c=template_manage&action=modify&filename=local_index.tpl',
                    '地方服务内页' => '?c=template_manage&action=modify&filename=local_sites.tpl',
                    '行业网站模板' => '?c=template_manage&action=modify&filename=trade_sites.tpl',
                ),
            ),
            '静态生成' => array
            (
                '静态生成' => array
                (
                    '一键生成选择' => '?c=make_html',
                    '静态生成目录设置' => '?c=make_html&a=set',
                ),
            ),
            '搜索引擎' => array
            (
                '搜索引擎' => array
                (
                    '搜索分类管理' => '?c=search_class',
                    '搜索引擎管理' => '?c=search',
                    '搜索关键字' => '?c=search_keyword',
                ),
            ),
            '插件管理' => mod_plugin::get_plugins_menu(),
        );
        switch ($id)
        {
            case 0:
                $nam = '管理首页';
                break;
            case 1:
                $nam = '系统管理';
                break;
            case 2:
                $nam = '网址管理';
                break;
            case 3:
                $nam = '专题管理';
                break;
            case 4:
                $nam = '广告管理';
                break;
            case 5:
                $nam = '数据管理';
                break;
            case 6:
                $nam = '模板管理';
                break;
            case 7:
                $nam = '静态生成';
                break;
            case 8:
                $nam = '插件管理';
                break;
            case 9:
                $nam = '搜索引擎';
                break;
        }
        $output = '';
        foreach ($menu as $key => $val)
        {
            if ($key == $nam)
            {
                foreach ($val as $k1 => $v1)
                {
                    $output.="<div class='item'><h2>{$k1}<span class='close'>收起</span></h2><ul>";
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
     *  系统信息
     *
     */
    public static function system_info()
    {
        define("YES", "<span class='resYes'>YES</span>");
        define("NO", "<span class='resNo'>NO</span>");
        // 系统基本信息
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
            $pmemory = '共' . $sysInfo['memTotal'] . 'M, 已使用' . $sysInfo['memUsed'] . 'M, 空闲' . $sysInfo['memFree'] . 'M, 使用率' . $sysInfo['memPercent'] . '%';
            $pmemorybar = $sysInfo['memPercent'];
            $swapmomory = '共' . $sysInfo['swapTotal'] . 'M, 已使用' . $sysInfo['swapUsed'] . 'M, 空闲' . $sysInfo['swapFree'] . 'M, 使用率' . $sysInfo['swapPercent'] . '%';
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
        $systime = gmdate("Y年n月j日 H:i:s", time() + 8 * 3600);
        $phpversionsp = $phpversion > '5.0' ? YES : NO;
        $mysqlversionsp = $mysql['dbversion'] > '4.1' ? YES : NO;
        $dbasp = extension_loaded('dba') ? YES : NO;
        // 数据库大小
        $databasesize = 0;
        app_db::query("SHOW TABLE STATUS");
        while ($rs = app_db::fetch_one())
        {
            $databasesize +=$rs['Data_length'] + $rs['Index_length'];
        }
        $databasesize = bytes_to_string($databasesize);
        //站点统计
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
        //系统日志大小超过限制提示
        $noticemsg = '';
        if (@filesize(PATH_DATA . '/log/admin_log.php') > 409600)
        {
            $noticemsg = '后台记录日志';
        }
        if (@filesize(PATH_DATA . '/log/php_error.log') > 409600)
        {
            $data['noticemsg'] = 'PHP错误日志';
        }
        if (@filesize(PATH_DATA . '/log/mysql_error.php') > 409600)
        {
            $data['noticemsg'] = 'mysql日志';
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
     * 跳转方法(独立与login模块)
     * @param <type> $message
     * @param <type> $url
     * @param <type> $timeout     默认:2秒跳转
     * @param <type> $stop_loop   1:停止跳走,   默认0:自动跳转
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
     * 获取管理员用户名
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
            $error = '您没有登录.';
            //$http = empty($_SERVER['HTTP_REFERER']) ? './?ctl=login&action=welcome' : $_SERVER['HTTP_REFERER'];
            $http = './?c=login';
            $stop_loop = 0; //没权限不跳转
            self::message($error, $http, 1000, $stop_loop);
            exit();
        }
    }

    /**
     * 对权限用户进行序列化处理
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
     * 得到控制器名称
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
     * 检测函数是否存在
     * @param <type> $funName
     * @return <type>
     */
    public static function isfun($funName)
    {
        return (false !== function_exists($funName)) ? YES : NO;
    }

    /**
     *  linux 系统信息
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
                $res['cpu']['detail'][] = "类型：" . $model[1][$i] . " 缓存：" . $cache[1][$i];
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
            $res['uptime'] = $days . "天";
        if ($hours !== 0)
            $res['uptime'] .= $hours . "小时";
        $res['uptime'] .= $min . "分钟";

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

    // freebsd 系统信息
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
            $res['uptime'] = $days . "天";
        if ($hours !== 0)
            $res['uptime'] .= $hours . "小时";
        $res['uptime'] .= $min . "分钟";

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
