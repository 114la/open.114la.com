<?php

!defined('PATH_ADMIN') && exit('Forbidden');

/**
 * 系统升级提示
 *
 * 操作流程： index(版本对比，如果有升级提示) -> getlist(获取要升级的文件列表) -> makecache(把文件列表写入缓存) -> start(下载文件) -> apply(应用升级文件)
 *
 * 特殊情况：skinupdate 用于跳过升级
 */
class ctl_update
{

    public function index()
    {
        $infos = mod_update::check_update();
        if ($infos !== false && count($infos) > 0)
        {
            echo json_encode($infos);
        }
        else
        {
            echo "";
        }
    }

    /*
     * 获得待升级文件列表
     */

    public function getlist()
    {
        $upitems = $_POST['upitems'];
        $lasttime = $_POST['lasttime'];

        $tmpdir = substr(array_var($_COOKIE, AUTH_KEY . '_admin_auth'), 0, 16);
        $files = mod_update::getfilelist($upitems);
        $hasupfile = is_array($files) && count($files) > 0;
        app_tpl::assign('hasupfile', $hasupfile);
        app_tpl::assign('upitems', $upitems);
        app_tpl::assign('lasttime', $lasttime);
        app_tpl::assign('tmpdir', $tmpdir);
        app_tpl::assign('files', $files);

        app_tpl::display('update-list.tpl');
    }

    /*
     * 生成待下载文件缓存
     */

    public function makecache()
    {
        $dirinfos = mod_update::write_cache($_POST['tmpdir'], $_POST['lasttime'], $_POST['upitems'], $_POST['files'], $_POST['skipnodir']);

        app_tpl::assign('dirinfos', $dirinfos);

        app_tpl::display('update-affirm.tpl');
    }

    /*
     * 下载升级文件
     */

    public function start()
    {

        global $tmpdir, $lasttime, $files, $fileConut, $sqls;
        $cacheFiles = PATH_DATA . mod_update::$update_dir . '/updatetmp.inc';
        if (file_exists($cacheFiles))
        {
            require_once($cacheFiles);
            $fileid = isset($_GET['fileid']) ? $_GET['fileid'] : 0;
            $curfile = isset($files[$fileid]) ? $files[$fileid] : '';
            //正常下载
            if ($curfile != '')
            {
                mod_update::make_tmp_dir($tmpdir, $curfile);
                $downfile_url = mod_update::$source_url . '/' . mod_update::$current_version . '/source/' . $curfile;
                $data = mod_downloader::get_data($downfile_url);
                if ($data)
                {
                    @file_put_contents(PATH_DATA . mod_update::$update_dir . '/' . $tmpdir . '/' . $curfile, $data);
                    $fileid++;
                    $msg = "下载文件：{$downfile_url} OK，<br />
                     正在下载下一个文件...
                     <script type=\"text/javascript\">
                        setTimeout(\"location='?c=update&a=start&fileid={$fileid}';\", 500);
                     </script>
                    ";
                }
                else
                {
                    $nextField = $fileid + 1;
                    $nextmsg = '';
                    if (isset($files[$nextField]))
                    {
                        $nextmsg = "&nbsp;&nbsp; <a href='?c=update&a=start&fileid={$nextField}'><u>&lt;&lt;跳过&gt;&gt;</u></a>";
                    }
                    $msg = "<p style='color:red;font-size:14px'>下载文件：{$downfile_url} 失败，请重新尝试，<br /><br /><a href='?c=update&a=start&fileid={$fileid}'><u>&lt;&lt;重试&gt;&gt;</u></a> {$nextmsg} &nbsp;&nbsp; <a href='{$downfile_url}' target='_blank'><u>手动保存此文件(右键，另存为...)</u></a><br /><br /></p>";
                }
            }
            //下载SQL文件并完成升级
            else
            {
                $ct = '';
                foreach ($sqls as $sql)
                {
                    $downfile_url = mod_update::$source_url . '/' . mod_update::$current_version . '/' . $sql . ".txt";
                    $ct .= mod_downloader::get_data($downfile_url);
                }
                if ($ct)
                {
                    $ct = @iconv('utf-8', 'gbk', $ct);
                    $sqlfile = PATH_DATA . mod_update::$update_dir . '/' . $tmpdir . '/sql.txt';
                    file_put_contents($sqlfile, $ct);
                }
                $msg = "所有文件下载完成，你可以：<br />";
                $msg .= "到：" . PATH_DATA . '/' . $tmpdir . " 目录复制文件进行手动升级。<br />";
                $msg .= "<a href='?c=update&a=apply'><strong>点击此马上进行直接升级&gt;&gt;</strong></a>";
            }
        }
        else
        {
            $msg = "任务缓存文件：{$cacheFiles} 不存在，请确保此文件夹可写入，然后返回重新尝试！ [<a href='?c=login&a=welcome'>返回主页&gt;&gt;</a>]";
        }

        app_tpl::assign('msg', $msg);

        app_tpl::display('update-msg.tpl');
    }

    /*
     * 应用更新
     */

    public static function apply()
    {
        global $tmpdir, $lasttime, $files, $fileConut, $sqls;
        $cacheFiles = PATH_DATA . mod_update::$update_dir . '/updatetmp.inc';
        $verLockFile = PATH_DATA . mod_update::$update_dir . '/ver.txt';
        if (file_exists($cacheFiles))
        {
            require_once($cacheFiles);
            $sqlfile = PATH_DATA . mod_update::$update_dir . '/' . $tmpdir . '/sql.txt';
            $sql = trim(@file_get_contents($sqlfile));
            if (!empty($sql))
            {
                $sqls = explode(";[\r\n]", $sql);
                foreach ($sqls as $sql)
                {
                    app_db::query($sql, true);
                }
            }
            $sDir = PATH_DATA . mod_update::$update_dir . '/' . $tmpdir;
            $tDir = PATH_ROOT;
            $badcp = 0;
            $adminDir = preg_replace("/^[\/\\\\]/", '', ADMIN);
            if (isset($files) && is_array($files))
            {
                foreach ($files as $f)
                {
                    if (preg_match('/^admin\//', $f))
                    {
                        $tf = preg_replace('/^admin\//', $adminDir . '/', $f);
                    }
                    else
                    {
                        $tf = $f;
                    }
                    if (file_exists($sDir . '/' . $f) && filesize($sDir . '/' . $f) > 0)
                    {
                        $rs = @copy($sDir . '/' . $f, $tDir . '/' . $tf);
                        if ($rs)
                        {
                            unlink($sDir . '/' . $f);
                        }
                        else
                        {
                            $badcp++;
                        }
                    }
                    else
                    {
                        $badcp++;
                    }
                }//end foreach
            }

            file_put_contents($verLockFile, $lasttime);

            if ($badcp > 0)
            {
                $msg = "升级成功，其中失败 {$badcp} 个文件，<br />请在临时目录检查这几个文件是否正常。[<a href='?c=login&a=welcome'>返回主页&gt;&gt;</a>]<br />";
                $msg .= "<div style='font-size:18px;color:red;line-height:36px;'><strong>如果你看到这个提示，表示有个别文件可能因为网络或兼容性等原因无法获取，你可以手动把 {$verLockFile} 的时间设为最后一次更新的日期，这样系统会再次提示你升级。</strong></div>";
            }
            else
            {
                $msg = "升级完成成功，与服务器同步的最新日期是：{$lasttime}。[<a href='?c=login&a=welcome'>返回主页&gt;&gt;</a>]";
            }
        }
        else
        {
            $msg = "没找到缓存文件，无法进行升级！ [<a href='?c=login&a=welcome'>返回主页&gt;&gt;</a>]";
        }
        app_tpl::assign('msg', $msg);
        app_tpl::display('update-msg.tpl');
    }

    /*
     * 忽略某次更新
     */

    public static function skinupdate()
    {
        $lasttime = $_GET['lasttime'];
        $upfile = PATH_DATA . mod_update::$update_dir . '/ver.txt';
        $rs = false;
        if ($lasttime != '')
        {
            $rs = @file_put_contents($upfile, $lasttime);
        }
        if ($rs)
        {
            $msg = "成功跳过本次升级！ 如果你想恢复，请手动把 {$upfile} 的时间设为最后一次更新的日期。[<a href='?c=login&a=welcome'>返回主页&gt;&gt;</a>]";
        }
        else
        {
            $msg = "操作失败，可能 data/update 文件夹没写入权限！ [<a href='?c=login&a=welcome'>返回主页&gt;&gt;</a>]";
        }
        app_tpl::assign('msg', $msg);
        app_tpl::display('update-msg.tpl');
    }

}

?>
