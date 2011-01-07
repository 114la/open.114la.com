<?php

!defined('PATH_ADMIN') && exit('Forbidden');

/**
 * ϵͳ������ʾ
 *
 * �������̣� index(�汾�Աȣ������������ʾ) -> getlist(��ȡҪ�������ļ��б�) -> makecache(���ļ��б�д�뻺��) -> start(�����ļ�) -> apply(Ӧ�������ļ�)
 *
 * ���������skinupdate ������������
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
     * ��ô������ļ��б�
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
     * ���ɴ������ļ�����
     */

    public function makecache()
    {
        $dirinfos = mod_update::write_cache($_POST['tmpdir'], $_POST['lasttime'], $_POST['upitems'], $_POST['files'], $_POST['skipnodir']);

        app_tpl::assign('dirinfos', $dirinfos);

        app_tpl::display('update-affirm.tpl');
    }

    /*
     * ���������ļ�
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
            //��������
            if ($curfile != '')
            {
                mod_update::make_tmp_dir($tmpdir, $curfile);
                $downfile_url = mod_update::$source_url . '/' . mod_update::$current_version . '/source/' . $curfile;
                $data = mod_downloader::get_data($downfile_url);
                if ($data)
                {
                    @file_put_contents(PATH_DATA . mod_update::$update_dir . '/' . $tmpdir . '/' . $curfile, $data);
                    $fileid++;
                    $msg = "�����ļ���{$downfile_url} OK��<br />
                     ����������һ���ļ�...
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
                        $nextmsg = "&nbsp;&nbsp; <a href='?c=update&a=start&fileid={$nextField}'><u>&lt;&lt;����&gt;&gt;</u></a>";
                    }
                    $msg = "<p style='color:red;font-size:14px'>�����ļ���{$downfile_url} ʧ�ܣ������³��ԣ�<br /><br /><a href='?c=update&a=start&fileid={$fileid}'><u>&lt;&lt;����&gt;&gt;</u></a> {$nextmsg} &nbsp;&nbsp; <a href='{$downfile_url}' target='_blank'><u>�ֶ�������ļ�(�Ҽ������Ϊ...)</u></a><br /><br /></p>";
                }
            }
            //����SQL�ļ����������
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
                $msg = "�����ļ�������ɣ�����ԣ�<br />";
                $msg .= "����" . PATH_DATA . '/' . $tmpdir . " Ŀ¼�����ļ������ֶ�������<br />";
                $msg .= "<a href='?c=update&a=apply'><strong>��������Ͻ���ֱ������&gt;&gt;</strong></a>";
            }
        }
        else
        {
            $msg = "���񻺴��ļ���{$cacheFiles} �����ڣ���ȷ�����ļ��п�д�룬Ȼ�󷵻����³��ԣ� [<a href='?c=login&a=welcome'>������ҳ&gt;&gt;</a>]";
        }

        app_tpl::assign('msg', $msg);

        app_tpl::display('update-msg.tpl');
    }

    /*
     * Ӧ�ø���
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
                $msg = "�����ɹ�������ʧ�� {$badcp} ���ļ���<br />������ʱĿ¼����⼸���ļ��Ƿ�������[<a href='?c=login&a=welcome'>������ҳ&gt;&gt;</a>]<br />";
                $msg .= "<div style='font-size:18px;color:red;line-height:36px;'><strong>����㿴�������ʾ����ʾ�и����ļ�������Ϊ���������Ե�ԭ���޷���ȡ��������ֶ��� {$verLockFile} ��ʱ����Ϊ���һ�θ��µ����ڣ�����ϵͳ���ٴ���ʾ��������</strong></div>";
            }
            else
            {
                $msg = "������ɳɹ����������ͬ�������������ǣ�{$lasttime}��[<a href='?c=login&a=welcome'>������ҳ&gt;&gt;</a>]";
            }
        }
        else
        {
            $msg = "û�ҵ������ļ����޷����������� [<a href='?c=login&a=welcome'>������ҳ&gt;&gt;</a>]";
        }
        app_tpl::assign('msg', $msg);
        app_tpl::display('update-msg.tpl');
    }

    /*
     * ����ĳ�θ���
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
            $msg = "�ɹ��������������� �������ָ������ֶ��� {$upfile} ��ʱ����Ϊ���һ�θ��µ����ڡ�[<a href='?c=login&a=welcome'>������ҳ&gt;&gt;</a>]";
        }
        else
        {
            $msg = "����ʧ�ܣ����� data/update �ļ���ûд��Ȩ�ޣ� [<a href='?c=login&a=welcome'>������ҳ&gt;&gt;</a>]";
        }
        app_tpl::assign('msg', $msg);
        app_tpl::display('update-msg.tpl');
    }

}

?>
