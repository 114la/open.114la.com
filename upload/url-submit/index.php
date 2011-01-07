<?php
/**
 * 网址提交
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
require '../init.php';

try
{
    $action = (empty($_POST['action'])) ? '' : $_POST['action'];
    $dir_tpls_main = mod_config::get_one_config('yl_dirtplmain');
    empty($dir_tpls_main) && $dir_tpls_main = 'default';
    $path_tpls_main = PATH_TPLS_MAIN . '/' . $dir_tpls_main;
    if ($action == 'add')
    {
        $name = (empty($_POST['name'])) ? '' : strip($_POST['name']);
        if (empty($name))
        {
            throw new Exception('网站名称不能为空', 10);
        }

        $siteurl = (empty($_POST['siteurl'])) ? '' : strip($_POST['siteurl']);
        if (empty($siteurl))
        {
            throw new Exception('网站名称不能为空', 10);
        }
        $tmp = parse_url($siteurl);
        $domain = $tmp['host'];
        if (!eregi("^http[s]?://", $siteurl) || empty($domain))
        {
            throw new Exception('网站网址不正确', 10);
        }
        $domain = addslashes($domain);

        $jianjie = (empty($_POST['jianjie'])) ? '' : strip($_POST['jianjie']);
        if (empty($jianjie))
        {
            throw new Exception('网站简介不能为空', 10);
        }

        $pv = (empty($_POST['pv'])) ? '' : strip($_POST['pv']);
        $class = (empty($_POST['class'])) ? '' : strip($_POST['class']);
        if (empty($class))
        {
            throw new Exception('网站分类不能为空', 10);
        }

        $icp = (empty($_POST['icp'])) ? '' : strip($_POST['icp']);
        $sitetime = (empty($_POST['sitetime'])) ? '' : strip($_POST['sitetime']);
        $lianxiren = (empty($_POST['lianxiren'])) ? '' : strip($_POST['lianxiren']);
        $address = (empty($_POST['address'])) ? '' : strip($_POST['address']);
        $qq = (empty($_POST['qq'])) ? '' : strip($_POST['qq']);
        if (empty($qq))
        {
            throw new Exception('QQ 不能为空', 10);
        }
        if (!is_numeric($qq))
        {
            throw new Exception('QQ 号码不正确', 10);
        }

        $mobile = (empty($_POST['mobile'])) ? '' : strip($_POST['mobile']);
        $tel = (empty($_POST['tel'])) ? '' : strip($_POST['tel']);
        $email = (empty($_POST['email'])) ? '' : strip($_POST['email']);
        if (empty($email))
        {
            throw new Exception('电子邮箱不能为空', 10);
        }

        $sharelink = (empty($_POST['sharelink'])) ? '' : strip($_POST['sharelink']);

        $rs = app_db::select('ylmf_urladd', '*', "domain = '{$domain}' LIMIT 1");
        if (!empty($rs))
        {
            $rs = $rs[0];
            if ($rs['type'] == 0)
            {
               throw new Exception('该站点已提交,请耐心等待工作人员的审核,不要重复提交!', 10);
            }
            elseif ($rs['type'] == 1)
            {
               throw new Exception('该站点已提交并且通过审核,已收录该站点!', 10);
            }
            else
            {
               throw new Exception('该站点上次提交未通过审核,请不要重复提交! 如有疑问请联系' . mod_config::get_one_config('yl_ceoemail'), 10);
            }
        }

        $info = $_POST;
        foreach($info as &$v)
        {
            $v = htmlentities($v, ENT_NOQUOTES, 'gb2312');
        }
        $infos = addslashes(serialize($info));
        app_db::insert('ylmf_urladd', array('domain', 'info', 'addtime'), array($domain, $infos, time()));

        $msg = '站点信息已成功提交,请耐心等待工作人员的审核!';
        app_tpl::assign('message', $msg, $path_tpls_main);
    }
    app_tpl::assign('sysname', mod_config::get_one_config('yl_sysname'), $path_tpls_main);
    app_tpl::assign('header_path', mod_make_html::OTHER_HEADER_FILENAME, $path_tpls_main);
    app_tpl::assign('footer_path', mod_make_html::OTHER_FOOTER_FILENAME, $path_tpls_main);
}
catch (Exception $e)
{
    $message = $e->getMessage();
    if (!empty($message))
    {
        app_tpl::assign('message', $message, $path_tpls_main);
    }
}
app_tpl::display('url_submit.tpl', $path_tpls_main);
?>
