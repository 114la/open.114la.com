<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//ini_set('error_log', PATH_ADMIN. "/data/log/install_error.log");

ini_set('memory_limit', '128M');
set_time_limit(300);

header('Content-Type: text/html; charset=gbk');

defined('HOST') || define('HOST', 'http://' . $_SERVER['HTTP_HOST']);
$path_info = pathinfo($_SERVER['PHP_SELF']);
$path_x = rtrim(strtr(dirname($path_info['dirname']), array('\\' => '/')), '/');
defined('URL') || define('URL', 'http://' . $_SERVER['HTTP_HOST'] . $path_x);
defined('ADMIN') || define('ADMIN', rtrim(dirname($_SERVER['PHP_SELF']), '/'));
defined('ADMIN_URL') || define('ADMIN_URL', rtrim(URL . ADMIN, '/'));

define('PWD', __FILE__ ? strtr(dirname(__FILE__).'/', array('\\' => '/')) : './');
define('YLMF_ROOT', dirname(PWD));
define('PATH_ADMIN', YLMF_ROOT . '/admin/');
define('PATH_INSTALL', YLMF_ROOT . '/install/');
define('PATH_OLD', YLMF_ROOT . '/old114la/');


$dbconffile = PATH_ADMIN . 'config/cfg_database.php';
$olddbconffile = PATH_OLD . 'admin/config/cfg_database.php';
$dbclassfile = PATH_INSTALL . 'app_db.php';
$installsqlfile = PATH_INSTALL . 'data/install.sql';
$updatesqlfile = PATH_INSTALL . 'data/update.sql';

$basename = 'index.php';

//处理输入数据
foreach(array('_COOKIE', '_POST', '_GET') as $_request)
{
	foreach($$_request as $_key => $_value)
	{
		$_key{0} != '_' && $$_key = Add_S($_value);
	}
}

//包含语言文件
require_once(PATH_INSTALL . 'install_lang.php');

//添加默认数据
if(empty($dbhost))$dbhost='localhost';
if(empty($dbuser))$dbuser='';
if(empty($dbpw))$dbpw='';
if(empty($dbname))$dbname='114la';
if(empty($dbpre))$dbpre='ylmf_';
if(empty($manager))$manager='admin';




//数据库链接
if(isset($step) && $step > 4 && $step < 6)
{
    if(file_exists($dbconffile))
    {
        include_once($dbconffile);
    }
    if(file_exists($dbclassfile))
    {
        include_once($dbclassfile);
        app_db::query("SET character_set_connection=gbk, character_set_results=gbk");
        app_db::query("SET NAMES gbk");
    }
}


if(empty($step))
{
    $check = 1;
    if (PHP_VERSION < '5.0.0')
    {
        $check = 0;
        $error_txt = $lang['low_version'];
    }
}
elseif($step==1)//选择安装模式
{
}
elseif($step==2)//输入库配置文件可写检测
{
    $w_check = array(
        $dbconffile,
    );
    $check = 1;
    foreach ($w_check as $key => $value)
    {
        if (!file_exists($value) && !@touch($value))
        {
            $w_check[$key] .= $lang['no_file'];
            $check = 0;
        } elseif (!is_writable($value))
        {
            $w_check[$key] .= $lang['777_test'];
            $check = 0;
        } else
        {
            $w_check[$key] .= $lang['test_ok'];
            $step = 3;
            if($method == 2)
            {
                if(file_exists($olddbconffile))
                {
                    @copy($olddbconffile, $dbconffile);
                    include_once($dbconffile);
                }
                $dbuser = $GLOBALS ['database'] ['db_user'];
                $dbpw = $GLOBALS ['database'] ['db_pass'];
                $dbname = $GLOBALS ['database'] ['db_name'];
                $dbpre = $GLOBALS ['database'] ['table_prefix'];
                $dbhost = $GLOBALS ['database'] ['db_host'];
                $manager = $GLOBALS ['database'] ['manager'];
                $manager_pwd = $GLOBALS ['database'] ['managerpw'];
                $staticfolder = $GLOBALS ['database'] ['staticfolder'];
            }
        }
    }
}
elseif($step==3)
{
    if($method == 2)
    {
        if(file_exists($olddbconffile))
        {
            @copy($olddbconffile, $dbconffile);
            include_once($dbconffile);
        }
        $dbuser = $GLOBALS ['database'] ['db_user'];
        $dbpw = $GLOBALS ['database'] ['db_pass'];
        $dbname = $GLOBALS ['database'] ['db_name'];
        $dbpre = $GLOBALS ['database'] ['table_prefix'];
        $dbhost = $GLOBALS ['database'] ['db_host'];
        $manager = $GLOBALS ['database'] ['manager'];
        $manager_pwd = $GLOBALS ['database'] ['managerpw'];
        $staticfolder = $GLOBALS ['database'] ['staticfolder'];
    }
}
elseif($step==4) //输入处理和目录权限检测
{
    $check = 1;
    if(!empty($method) && $method == 1)
    {
        if(!$manager || !$password || $password != $password_check)
        {
            $error_password = 1;//密码错误,显示
            $step=3;
            $check=0;
        }
        if(!$dbuser || $dbpw != $dbpw_check)
        {
            $error_password = 2;//数据库密码错误,显示
            $step=3;
            $check=0;
        }
        else
        {
            $manager_pwd = md5($password);
            $writetofile = <<<EOT
<?php
!defined('PATH_ADMIN') && exit('Forbidden');
\$GLOBALS ['database'] ['db_user'] = '$dbuser';
\$GLOBALS ['database'] ['db_pass'] = '$dbpw';
\$GLOBALS ['database'] ['db_name'] = '$dbname';
\$GLOBALS ['database'] ['db_charset'] = 'gbk';
\$GLOBALS ['database'] ['table_prefix'] = '$dbpre';
\$GLOBALS ['database'] ['db_host'] = '$dbhost';
\$GLOBALS ['database'] ['manager'] = '$manager';
\$GLOBALS ['database'] ['managerpw'] = '$manager_pwd';
\$GLOBALS ['database'] ['staticfolder'] = '$staticfolder';
?>
EOT;
            file_put_contents($dbconffile, $writetofile);
        }
    }
    else
    {

        if(file_exists($dbconffile))
        {
            include_once($dbconffile);
        }
        $staticfolder = $GLOBALS ['database'] ['staticfolder'] ;
    }

	//权限检测.
	$file_check_result = check_attr($staticfolder);
	$file_check_error = $file_check_result[0];
	$file_check_report = $file_check_result[1];
	if($file_check_error)//文件权限检测错误,显示
	{
		$check = 0;
	}

}
elseif($step==5) //数据导入
{
    if($method == 1) //重新安装
    {
        $error = 0;
        $error_txt = '';
        $dbcharset=$GLOBALS['database']['db_charset'];
        $dbname=$GLOBALS['database']['db_name'];

        if (!@app_db::select_db($dbname))
        {
            $sql = "CREATE DATABASE $dbname".((app_db::server_info() >= '4.1' && $dbcharset) ? " DEFAULT CHARACTER SET $dbcharset" : '');
            if(!app_db::query($sql))
            {
                $error = 1;
                $error_txt = $lang['no_database'];
            }
            else
            {
                @app_db::select_db($dbname);
            }
        }

        if(!$error)
        {
            $sql = file_get_contents($installsqlfile);
            $tblpre = $GLOBALS ['database'] ['table_prefix'] ;
            $yl_managerpw = $GLOBALS ['database'] ['managerpw'];
            $yl_manager = $GLOBALS ['database'] ['manager'];

            $installinfo = creat_table($sql);

            $sql = "INSERT INTO `{$tblpre}admin_user` VALUES('$yl_manager','$yl_managerpw','1','','0','127.0.0.1')";
            app_db::query($sql);

            $sql = "UPDATE `{$tblpre}config` SET `yl_value` = '{$GLOBALS ['database'] ['staticfolder']}' where `yl_name` = 'yl_path_html' ";
            app_db::query($sql);

            $newstr = substr($GLOBALS ['database'] ['staticfolder'], 1, strlen($GLOBALS ['database'] ['staticfolder']));
            $sql = "UPDATE `{$tblpre}coolclass` SET `path`=concat('{$newstr}',`path`)";
            app_db::query($sql);

        }
    }
    elseif($method == 2) //升级安装
    {
        $tblpre = $GLOBALS ['database'] ['table_prefix'] ;
        //导入新的数据
        $sql = file_get_contents($updatesqlfile);
        $installinfo = creat_table($sql);

        //迁移酷站数据
        app_db::query("select * from ylmf_class where inindex=1");
        $cool_class_list = app_db::fetch_all();
        if($cool_class_list)
        {
            foreach($cool_class_list as $c)
            {
                $staticfolder = $GLOBALS ['database'] ['staticfolder'];
                $c['path'] = empty($c['path']) ? $staticfolder . "/catalog/{$c['parentid']}.htm#" . $c['classid'] : $staticfolder . '/' . $c['path'] . '/index.htm#' . $c['classid'];
                $classname = !empty($c['indexname']) ? $c['indexname'] : $c['classname'];
                app_db::query("INSERT INTO ylmf_coolclass (classname,displayorder,path)VALUES ('$classname','$c[indexdisplayorder]','$c[path]')");

                $cid = app_db::insert_id();
                app_db::query("select * from ylmf_indexsite where class='$c[classid]'");
                $cool_site_list = app_db::fetch_all();
                if($cool_site_list)
                {
                    foreach($cool_site_list as $z)
                    {
                        app_db::query("INSERT INTO ylmf_coolsite (name,url,class,displayorder,good)VALUES ('$z[name]','$z[url]','$cid','$z[displayorder]','$z[good]')");
                    }
                }

                app_db::query("select count(*) as cnt from ylmf_coolsite where class='$cid'");
                $cnt = app_db::fetch_one();
                $cnt = $cnt['cnt'];
                app_db::query("update ylmf_coolclass set sitenum='$cnt' where classid='$cid'");
            }
        }

        //修改表结构
        $sql = "ALTER TABLE `{$tblpre}class` DROP `inindex`, DROP `indexname`, DROP `indexdisplayorder`";
        app_db::query($sql);

        $sql = "DROP TABLE IF EXISTS  `{$tblpre}indexsite`";
        app_db::query($sql);
    }

    //导入非数据库存储的数据
    if(file_exists(PATH_INSTALL . 'data/cache_famous_tab.php'))
    {
       @copy(PATH_INSTALL . 'data/cache_famous_tab.php', PATH_ADMIN . 'data/cache/cache_famous_tab.php'); 
    }
    if(file_exists(PATH_INSTALL . 'data/cache_index_tool.php'))
    {
       @copy(PATH_INSTALL . 'data/cache_index_tool.php', PATH_ADMIN . 'data/cache/cache_index_tool.php'); 
    }
    if(file_exists(PATH_INSTALL . 'data/cache_mztop.php'))
    {
       @copy(PATH_INSTALL . 'data/cache_mztop.php', PATH_ADMIN . 'data/cache/cache_mztop.php'); 
    }
    if(file_exists(PATH_INSTALL . 'data/cache_local_index.php'))
    {
       @copy(PATH_INSTALL . 'data/cache_local_index.php', PATH_ADMIN . 'data/cache/cache_local_index.php'); 
    }

    if(file_exists(PATH_INSTALL . 'data/cache_famous_loop.php'))
    {
       @copy(PATH_INSTALL . 'data/cache_famous_loop.php', PATH_ADMIN . 'data/cache/cache_famous_loop.php'); 
    }
    if(file_exists(PATH_INSTALL . 'data/cache_notice.php'))
    {
       @copy(PATH_INSTALL . 'data/cache_notice.php', PATH_ADMIN . 'data/cache/cache_notice.php'); 
    }
}
elseif($step==6)
{
    if($method == 1)//全新安装
    {
    }
    elseif($method == 2)//升级
    {
    }
}
elseif($step==7) //安装目录自删
{
	@deldir(dirname(__FILE__));
	if(!file_exists(__FILE__))
	{
		header('Location: ../admin/index.php');
        echo "<script type='text/javascript'>window.location.href='" . ADMIN_URL . "';</script>";
		exit;
	}
}

ob_start();
include('install.tpl.htm');
$output = str_replace(array('<!--<!---->', '<!---->', "\r\n","   "), array('','', '',''), ob_get_contents());
ob_end_clean();
echo $output;

/**  
 * 函数定义
 */

//输入过滤
function Add_S($string, $force = 0)
{
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if (!MAGIC_QUOTES_GPC || $force)
	{
		if (is_array($string))
		{
			foreach($string as $key => $val)
			{
				$string[$key] = Add_S($val, $force);
			}
		}
		else
		{
			$string = addslashes($string);
		}
	}
	return $string;
}


//目录权限检测
function check_attr($staticfolder)
{
	$error = 0 ;
    $result = array();
    if(file_exists('check_list.php'))
    {
        include('check_list.php');
        foreach ($check_list['dir_list'] as $name => $dir)
        {
            if(file_exists($dir))
            {
                if(is_dir($dir) && is_writable($dir))
                {
                    $result[] = array($name . ": " . $dir, 1);
                }
                else
                {
                    $error = 1 ;
                    $result[] = array($name . ": " . $dir, 2);
                }
            }
            else
            {
                if(@mkdir($dir, 0777, true))
                {
                    $result[] = array($name . ": " . $dir, 1);
                }
                else
                {
                    $error = 1 ;
                    $result[] = array($name . ": " . $dir, 3);
                }
            }
        }

        foreach ($check_list['file_list'] as $name => $file)
        {
            if(file_exists($file))
            {
                if(is_writable($file))
                {
                    $result[] = array($name . ": " . $file, 1);
                }
                else
                {
                    $error = 1 ;
                    $result[] = array($name . ": " . $file, 2);
                }
            }
            else
            {
                if(@touch($file))
                {
                    $result[] = array($name . ": " . $file, 1);
                }
                else
                {
                    $error = 1 ;
                    $result[] = array($name . ": " . $file, 3);
                }
            }
        }
    }
    else
    {
    }
	return array($error, $result);
}

//导入表结果和数据
function creat_table($sql)
{
	global $db,$PW,$lang,$charset;
	$installinfo = '';
	$sql = str_replace("\r",'',$sql);
	$sqlarray = array();
	$sqlarray = explode(";\n",$sql);

	foreach ($sqlarray as $key => $query)
	{
		$query = trim(str_replace("\n",'',$query));


		if ($query && strpos($query,'CREATE TABLE') !==false)
		{
			$c_name = trim(substr($query, 13, strpos($query, '(')-13));
			$c_name = str_replace('ylmf_', $GLOBALS ['database'] ['table_prefix'], $c_name);
			$installinfo .= "$lang[creat_table] $c_name ... $lang[success]\n";
			$extra1 = trim(substr(strrchr($query,')'),1));

			if (app_db::server_info() >= '4.1')
                        {
                            $extra2 = "ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_chinese_ci ;" ;
                        }
                        else
                        {
                            $extra2 = 'TYPE=MyISAM;';
                        }
			$query = str_replace($extra1,$extra2,$query);
		}
		$query && app_db::query($query);
	}

	return $installinfo;
}

//目录删除
function deldir($path)
{
	if (file_exists($path))
	{
		if(is_file($path))
		{
			P_unlink($path);
		} else
		{
			$handle = opendir($path);
			while ($file = readdir($handle))
			{
				if (($file!=".") && ($file!="..") && ($file!=""))
				{
					if (is_dir("$path/$file"))
					{
						deldir("$path/$file");
					} else
					{
						P_unlink("$path/$file");
					}
				}
			}
			closedir($handle);
			rmdir($path);
		}
	}
}

//文件删除
function P_unlink($filename)
{
	strpos($filename,'..')!==false && exit('Forbidden');
	return @unlink($filename);
}
?>
