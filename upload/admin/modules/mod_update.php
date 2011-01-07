<?php

/**
 * 114啦 网址导航系统
 *
 * @since      2009-7-9
 * @copyright  http://www.ylmf.com
 * @package    modules
 * @version    $Id: mod_update.php 1509 2009-12-04 06:14:52Z syh $
 */
/**
 * 升级提示类
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_update
{

    public static $current_version = CUR_VERSION;
    public static $source_url = SOURCE_URL;
    public static $update_dir = '/update';

    /**
     * 检测是否需要升级
     *
     * @param  none
     * @return array or false
     * @throws none
     */
    public static function check_update()
    {
        try
        {
            $uptime = trim(file_get_contents(PATH_DATA . self::$update_dir . '/ver.txt'));
            $verlist = mod_downloader::get_data(self::$source_url . '/' . self::$current_version . '/update-list.txt');
            if (!$verlist || $uptime == '')
            {
                return false;
            }
            $verlist = preg_replace("/[\r\n]{1,}/", "\n", $verlist);
            $verlists = explode("\n", $verlist);
            //分析数据
            $update_vers = array();
            $upitems = $lasttime = '';
            $n = 0;
            foreach ($verlists as $verstr)
            {
                if (empty($verstr) || preg_match("/^\/\//", $verstr))
                {
                    continue;
                }
                list($vtime, $vlang, $issafe, $vmsg) = explode(',', $verstr);
                $vtime = trim($vtime);
                $vlang = trim($vlang);
                $issafe = trim($issafe);
                $vmsg = trim($vmsg);
                if ($vtime > $uptime)
                {
                    $update_vers[$n]['issafe'] = $issafe;
                    $update_vers[$n]['vmsg'] = $vmsg;
                    $upitems .= ( $upitems == '' ? $vtime : ',' . $vtime);
                    $lasttime = $vtime;
                    $update_vers[$n]['vtime'] = substr($vtime, 0, 4) . '-' . substr($vtime, 4, 2) . '-' . substr($vtime, 6, 2);
                    $n++;
                }
            }//End Foreach
            return array('vers' => $update_vers, 'lasttime' => $lasttime, 'upitems' => $upitems);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
            return false;
        }
    }

    /**
     * 获取升级文件列表
     *
     * @param  none
     * @return array or false
     * @throws none
     */
    public static function getfilelist($upitems)
    {
        $tmpdir = substr(md5(array_var($_COOKIE, AUTH_KEY . '_admin_auth')), 0, 16);
        try
        {
            $upitemsArr = explode(',', $upitems);
            rsort($upitemsArr);

            $fileArr = array();
            $f = 0;
            foreach ($upitemsArr as $upitem)
            {
                $durl = self::$source_url . '/' . self::$current_version . '/' . $upitem . '.file.txt';
                $filelist = mod_downloader::get_data($durl);
                $filelist = @iconv('utf-8', 'gbk//ignore', $filelist);
                $filelist = trim(preg_replace("/[\r\n]{1,}/", "\n", $filelist));
                if (!empty($filelist))
                {
                    $filelists = explode("\n", $filelist);
                    foreach ($filelists as $filelist)
                    {
                        $filelist = trim($filelist);
                        if (empty($filelist))
                            continue;
                        $fs = explode(',', $filelist);
                        if (empty($fs[1]))
                        {
                            $fs[1] = $upitem . " 常规功能更新文件";
                        }
                        if (!isset($fileArr[$fs[0]]))
                        {
                            $fileArr[$fs[0]] = $upitem . " " . trim($fs[1]);
                            $f++;
                        }
                    }
                }// if
            }//foreach upitems
            return $fileArr;
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
            return false;
        }
    }

    /*
     * 写入升级文件列表缓存
     */

    public static function write_cache($tmpdir, $lasttime, $upitems, $files, $skipnodir)
    {
        $cacheFiles = PATH_DATA . self::$update_dir . '/updatetmp.inc';
        $skipnodir = (isset($skipnodir) ? 1 : 0);
        $adminDir = preg_replace("/(.*)[\/\\\\]/", "", dirname(__FILE__));
        $fp = fopen($cacheFiles, 'w');
        fwrite($fp, '<' . '?php' . "\r\n");
        fwrite($fp, '$tmpdir = "' . $tmpdir . '";' . "\r\n");
        fwrite($fp, '$lasttime = ' . $lasttime . ';' . "\r\n");
        $dirs = array();
        $i = -1;
        foreach ($files as $filename)
        {
            $tfilename = $filename;
            if (preg_match("/^admin\//i", $filename))
            {
                $tfilename = preg_replace("/^admin\//i", preg_replace("/^[\/\\\\]/", '', ADMIN . '/'), $filename);
            }
            $curdir = mod_update::get_dir_name($tfilename);
            if (!isset($dirs[$curdir]))
            {
                $dirs[$curdir] = self::test_file_dir($curdir);
            }
            if ($skipnodir == 1 && $dirs[$curdir]['isdir'] == false)
            {
                continue;
            }
            else
            {
                @mkdir($curdir, 0777);
                $dirs[$curdir] = self::test_file_dir($curdir);
            }
            $i++;
            fwrite($fp, '$files[' . $i . '] = "' . $filename . '";' . "\r\n");
        }
        fwrite($fp, '$fileConut = ' . $i . ';' . "\r\n");
        $items = explode(',', $upitems);
        foreach ($items as $sqlfile)
        {
            fwrite($fp, '$sqls[] = "' . $sqlfile . '.sql";' . "\r\n");
        }
        fwrite($fp, '?' . '>');
        fclose($fp);
        return $dirs;
    }

    /*
     * 测试目录写入权限
     */

    public static function test_write_able($d)
    {
        $rs = @file_put_contents($d . '_t.txt', 'test');
        if (!$rs)
        {
            return false;
        }
        else
        {
            @unlink($d . '_t.txt');
            return true;
        }
    }

    /*
     * 获取目录名
     */

    public static function get_dir_name($filename)
    {
        $dirname = '../' . preg_replace("/[\/\\\\]{1,}/", '/', $filename);
        $dirname = preg_replace("/([^\/]*)$/", '', $dirname);
        return $dirname;
    }

    /*
     * 检测目录属性
     */

    public static function test_file_dir($dirname)
    {
        $dirs = array('name' => '', 'isdir' => false, 'writeable' => false);
        $dirs['name'] = $dirname;
        if (is_dir($dirname))
        {
            $dirs['isdir'] = true;
            $dirs['writeable'] = self::test_write_able($dirname);
        }
        return $dirs;
    }

    /*
     * 创建临时目录
     */

    public static function make_tmp_dir($tmpdir, $filename)
    {
        $basedir = PATH_DATA . self::$update_dir . '/' . $tmpdir;
        $dirname = trim(preg_replace("/[\/\\\\]{1,}/", '/', $filename));
        $dirname = preg_replace("/([^\/]*)$/", '', $dirname);
        if (!is_dir($basedir))
        {
            mkdir($basedir, 0777);
        }
        if ($dirname == '')
        {
            return true;
        }
        $dirs = explode('/', $dirname);
        $curdir = $basedir;
        foreach ($dirs as $d)
        {
            $d = trim($d);
            if (empty($d))
                continue;
            $curdir = $curdir . '/' . $d;
            if (!is_dir($curdir))
            {
                mkdir($curdir, 0777) or die($curdir);
            }
        }
        return true;
    }

}

?>
