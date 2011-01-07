<?php

/**
 * 模块管理
 *
 * @copyright http://www.114la.com
 * @version    $Id: ctl_template_manage.php 1093 2009-11-28 02:50:16Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_template_manage
{

    /**
     * 前台模板目录
     * @var string
     */
    private static $dir_tpl_main;

    /**
     * pre钩子
     *
     * @return void
     */
    public static function pre()
    {
        if (!self::$dir_tpl_main = mod_config::get_one_config('yl_dirtplmain'))
        {
            self::$dir_tpl_main = 'default';
        }
    }

    /**
     * 模板管理列表
     *
     * @return void
     */
    public static function template_list()
    {
        try
        {
            app_tpl::assign('npa', array('模板管理', '模板管理列表'));
            $data = mod_template::template_list();
            app_tpl::assign('data',$data);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        $sys = array('goback'=>'?c=template_manage&a=template_list',   'subform'=>'?c=template_manage&a=template_delete');
        app_tpl::assign('sys', $sys);
        app_tpl::display('template_list.tpl');
    }

    /**
     * 删除模板
     *
     * @return void
     */
    public static function template_delete()
    {
        defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
        $referer = $_SERVER['HTTP_REFERER'];
        $ids = ($_GET['id']) ? (array)$_GET['id'] : $_POST['id'];
        empty($ids) && exit(mod_login::message("请选择要删除的模板!", $_POST['referer']));
        $msg = '';
        $all_success = TRUE; //所有删除都成功
        foreach ($ids as $id) 
        {
            app_db::query("SELECT `tpl_file` FROM `ylmf_template` WHERE `id`='{$id}'");
            $data = app_db::fetch_one();
            $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $data['tpl_file'];
            $filename_bak = $filename . TPLS_BACKUP_EXT;
            //删除模板文件和模板备份文件
            if (is_file($filename))
            {
                //如果删除不成功，拼凑报错信息
                if (!@unlink($filename))
                {
                    $msg .= "模板文件 " .$data['tpl_file'] . "删除<font color=red>失败</font>，请检查该文件是否有删除权限<br/>";
                }
            }
            if (is_file($filename_bak))
            {
                if (!@unlink($filename_bak))
                {
                    $msg .= "模板备份文件 " .$data['tpl_file'] . TPLS_BACKUP_EXT . "删除<font color=red>失败</font>，请检查该文件是否有删除权限<br/>";
                }
            }
            //两个文件都不存在了
            if (!is_file($filename) && !is_file($filename_bak))
            {
                app_db::query("DELETE FROM `ylmf_template` WHERE `id`='{$id}'");
            }
            else
            {
                $all_success = FALSE;
            }
        }
        //所有都成功的话直接显示删除模板成功
        if ($all_success)
        {
            exit(mod_login::message("删除模板成功!", (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
        }
        //只要有一个不成功，就显示所有错误详细信息
        else
        {
            exit(mod_login::message($msg, (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
        }
    }

    /**
     * 添加模板
     *
     * @return void
     */
    public static function template_add()
    {
        try
        {
            if (empty($_POST))
            {
                app_tpl::assign('npa', array('模板管理', '添加模板'));
                $sys = array('goback'=>'?c=template_manage&a=template_list', 'subform'=>'?c=template_manage&a=template_add');
                app_tpl::assign('sys', $sys);
            }
            else
            {
                defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
                $form = $_POST['form'];
                $content = (empty($_POST['content'])) ? '' : htmlspecialchars_decode(stripslashes($_POST['content']));
                //过滤前后空格
                $form['tpl_name'] = trim($form['tpl_name']);
                $form['tpl_file'] = trim($form['tpl_file']);
                //出错的时候不会导致之前填的值丢失
                app_tpl::assign('form', $form);
                app_tpl::assign('content', $content);
                //判断模板名称
                if (empty($form['tpl_name']))
                {
                    throw new Exception('请输入模板名称');
                }
                //判断模板文件
                if (empty($form['tpl_file']))
                {
                    app_db::query("SELECT MAX(id) as id FROM `ylmf_template`");
                    $data = app_db::fetch_one();
                    $id = intval($data[id]) + 1;
                    $form['tpl_file'] = "class_" . $id . '.tpl';
                    //出错的时候不会导致之前填的值丢失，而且没有填模板名称的，给一个唯一的名称它
                    app_tpl::assign('form', $form);
                }
                else
                {
                    app_db::query("SELECT * FROM `ylmf_template` WHERE `tpl_file`='{$form['tpl_file']}'");
                    $data = app_db::fetch_one();
                    if($data) throw new Exception('已存在模板文件，请输入唯一的模板文件');
                }
                //判断模板内容
                if (empty($content))
                {
                    throw new Exception('请输入模块内容');
                }
                $form['add_time'] = time();
                //操作数据库
                if (false === app_db::insert('ylmf_template', array_keys($form), array_values($form)))
                {
                    throw new Exception('数据库添加失败');
                }
                //保存模板文件和模板备份文件,删除的时候记得两个都删除了
                $ini_filename = (empty($form['tpl_file'])) ? '' : $form['tpl_file'];
                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                if (false == mod_file::write($filename, $content, 'wb+'))
                {
                    throw new Exception('文件' . $ini_filename . ' 保存失败');
                }
                @chmod($filename, 0777);
                $filename_bak = $filename . TPLS_BACKUP_EXT;
                if (false == mod_file::write($filename_bak, $content, 'wb+'))
                {
                    throw new Exception('文件' . $ini_filename . TPLS_BACKUP_EXT . ' 保存失败');
                }
                @chmod($filename, 0777);

                //exit(mod_login::message("添加模板成功!", $_POST['referer']));
                exit(mod_login::message("添加模板成功!", (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('template_form.tpl');
        
    }
    
    /**
     * 添加模板
     *
     * @return void
     */
    public static function template_edit()
    {
        try
        {
            //编辑修改模板
            if (empty($_POST))
            {
                //模板文件输入框只读,修改时就不要修改模板文件了否则很乱
                app_tpl::assign('tpl_file_readonly', 'yes');

                $id = $_GET['id'];
                app_tpl::assign('npa', array('模板管理', '修改模板'));
                $sys = array('goback'=>'?c=template_manage&a=template_list', 'subform'=>'?c=template_manage&a=template_edit');
                app_tpl::assign('sys', $sys);

                $query = app_db::query("SELECT * FROM `ylmf_template` WHERE `id`={$id}");
                $form  = app_db::fetch_one();
                app_tpl::assign('form', $form);
                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $form['tpl_file'];
                app_tpl::assign('content', htmlspecialchars(mod_file::read($filename), ENT_QUOTES));
            }
            //保存修改模板
            else
            {
                $id = $_POST['id'];
                $form = $_POST['form'];
                $content = (empty($_POST['content'])) ? '' : htmlspecialchars_decode(stripslashes($_POST['content']));
                //过滤前后空格
                $form['tpl_name'] = trim($form['tpl_name']);
                $form['tpl_file'] = trim($form['tpl_file']);
                //出错的时候不会导致之前填的值丢失
                app_tpl::assign('form', $form);
                app_tpl::assign('content', $content);
                //判断模板名称
                if (empty($form['tpl_name']))
                {
                    throw new Exception('请输入模板名称');
                }
                //判断模板内容
                if (empty($content))
                {
                    throw new Exception('请输入模块内容');
                }

                if (false === app_db::update('ylmf_template', $form, "id={$id}"))
                {
                    throw new Exception('数据库修改失败');
                }
                //保存模板文件和模板备份文件,删除的时候记得两个都删除了
                $ini_filename = (empty($form['tpl_file'])) ? '' : $form['tpl_file'];
                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                if (false == mod_file::write($filename, $content, 'wb+'))
                {
                    throw new Exception('文件' . $ini_filename . ' 保存失败');
                }

                //exit(mod_login::message("修改模板成功!", $_POST['referer']));
                exit(mod_login::message("修改模板成功!", (empty($_POST['referer'])) ? '?c=template_manage&a=template_list' : $_POST['referer']));
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('template_form.tpl');
    }

    /**
     * 备份模板
     *
     * @return void
     */
    public static function backup()
    {
        defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
        $ini_filename = (empty($_GET['filename'])) ? '' : $_GET['filename'];
        $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
        $filename_bak = $filename . TPLS_BACKUP_EXT;
        if (@copy($filename, $filename_bak))
        {
            exit(mod_login::message("模板备份成功!", '?c=template_manage&a=template_list'));
        }
        exit(mod_login::message("模板备份失败,请检查文件权限!", '?c=template_manage&a=template_list'));
    }

    /**
     * 恢复模板
     *
     * @return void
     */
    public static function restore()
    {
        defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');
        $ini_filename = (empty($_GET['filename'])) ? '' : $_GET['filename'];
        $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
        $filename_bak = $filename . TPLS_BACKUP_EXT;
        if (@copy($filename_bak, $filename))
        {
            exit(mod_login::message("模板还原成功!", '?c=template_manage&a=template_list'));
        }
        exit(mod_login::message("模板还原失败,请检查文件权限!", '?c=template_manage&a=template_list'));
    }

    /**
     * 模板管理
     *
     * @return void
     */
    public static function index()
    {
        //echo file_get_contents(PATH_DATA."/cache/cache_index_tool.php");
        //exit;
        try
        {
            app_tpl::assign('npa', array('模板管理', '模板编辑'));
            //$action = 'modify' | 'save' | 'restore' 修改 保存 还原
            $action = (empty($_GET['action'])) ? '' : $_GET['action'];

            defined('TPLS_BACKUP_EXT') || define(TPLS_BACKUP_EXT, '.bak');

            // 读文件或恢复到默认模板
            if ($action == 'modify' || $action == 'restore')
            {
                $ini_filename = (empty($_GET['filename'])) ? '' : $_GET['filename'];
                if (empty($ini_filename))
                {
                    throw new Exception('文件 ' . $ini_filename . ' 不存在');
                }

                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                if ($action == 'restore')
                {
                    $filename .= TPLS_BACKUP_EXT;
                }

                if (!file_exists($filename))
                {
                    throw new Exception('文件 ' . $ini_filename . ' 不存在');
                }
                if ($action == 'modify')
                {
                    // 不存在备份文件则备份一下原始文件
                    if (!file_exists($filename . TPLS_BACKUP_EXT) && !@copy($filename, $filename . TPLS_BACKUP_EXT))
                    {
                        throw new Exception('文件 ' . $ini_filename . TPLS_BACKUP_EXT . ' 备份失败');
                    }
                }
                else
                {
                    // 恢复模板
                    $old_filename = substr($filename, 0, -strlen((TPLS_BACKUP_EXT)));
                    $bak_filename = $filename;
                    if (!mod_file::write($old_filename, mod_file::read($bak_filename)))
                    {
                        throw new Exception('文件' . $ini_filename . ' 恢复失败');
                    }

                    if (preg_match('/index\.tpl/i', $filename))
                    {
                        mod_make_html::auto_update('index');
                    }
                    elseif (preg_match('/other\_(header|footer|body)\.tpl/i', $filename))
                    {
                        mod_make_html::auto_update('other');
                    }
                }

                app_tpl::assign('content', htmlspecialchars(mod_file::read($filename), ENT_QUOTES));
                app_tpl::assign('filename', $ini_filename);
                app_tpl::assign('back', '?c=template_manage&action=modify&filename=' . $ini_filename);
            }
            // 写文件
            elseif ($action == 'save')
            {
                $content = (empty($_POST['content'])) ? '' : htmlspecialchars_decode(stripslashes($_POST['content']));
                if (empty($content))
                {
                    throw new Exception('请输入模块内容', 10);
                }

                $ini_filename = (empty($_POST['filename'])) ? '' : $_POST['filename'];
                if (empty($ini_filename))
                {
                    throw new Exception('文件 ' . $ini_filename . ' 不存在');
                }

                $filename = PATH_TPLS_MAIN . '/' . self::$dir_tpl_main . '/' . $ini_filename;
                // 不能修改原始备份文件
                if (!file_exists($filename) || substr($filename, -(strlen(TPLS_BACKUP_EXT))) == TPLS_BACKUP_EXT)
                {
                    throw new Exception('文件 ' . $ini_filename . ' 不存在');
                }

                if (false == mod_file::write($filename, $content, 'wb+'))
                {
                    throw new Exception('文件' . $ini_filename . ' 保存失败');
                }
                @chmod($filename, 0777);

                if (preg_match('/index\.tpl/i', $filename))
                {
                    mod_make_html::auto_update('index');
                }
                elseif (preg_match('/other\_(header|footer|body)\.tpl/i', $filename))
                {
                    mod_make_html::auto_update('other');
                }

                mod_login::message('操作成功', (empty($_POST['referer'])) ? '?c=template_manage' : $_POST['referer']);
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        if (preg_match('/class\_(header|footer|body)\.tpl/i', $ini_filename))
        {
            app_tpl::assign('show_msg', 1);
        }
        app_tpl::display('template_manage.tpl');
    }

    /**
     * 模板选择
     *
     * @return void
     */
    public static function cur_tpl()
    {
        app_tpl::assign('npa', array('模板管理', '模板选择'));
        // 删除
        if (!empty($_GET['delete']))
        {
            $tpl = PATH_TPLS_MAIN . '/' . $_GET['delete'];
            if (is_dir($tpl))
            {
                mod_file::rm_recurse($tpl);
                mod_login::message('操作成功', '?c=template_manage&a=cur_tpl');
            }
        }
        // 启用
        elseif (!empty($_GET['apply']))
        {
            mod_config::set_configs(array('yl_dirtplmain' => $_GET['apply']));
            if (!empty($_GET['mkhtml']))
            {
                mod_make_html::flush('正在生成首页……');
                mod_make_html::make_html_index();
                mod_make_html::flush($ok);
            }
            mod_login::message('操作成功', '?c=template_manage&a=cur_tpl');
        }

        $dirs = mod_file::ls(PATH_TPLS_MAIN, 'dir');
        if (file_exists(PATH_TPLS_MAIN . '/' . self::$dir_tpl_main))
        {
            $cur_dir = self::$dir_tpl_main;
        }
        else
        {
            $cur_dir = current($dirs);
            if ($cur_dir === false)
            {
                //无模板
                //显示相关页，退出
            }
        }

        //显示正常模板
        $other_tpls = array();
        foreach ($dirs as $dir)
        {
            $name_filename = PATH_TPLS_MAIN . '/' . $dir . '/NAME';
            if (is_file($name_filename))
            {
                $cur_name = @file_get_contents($name_filename);
                if (empty($cur_name))
                {
                    $cur_name = $dir;
                }
            }
            else
            {
                $cur_name = $dir;
            }

            $tpl = array('path' => $dir, 'name' => $cur_name, 'preview' => ADMIN . '/tpls/tpls/main/' . $dir . '/PREVIEW.jpg');
            if ($dir == $cur_dir)
            {
                $cur_tpl = $tpl; // 当前模板的数据
            }
            else
            {
                $other_tpls[] = $tpl;
            }
        }

        if (!empty($cur_tpl))
        {
            app_tpl::assign('cur_tpl', $cur_tpl);
        }
        if (!empty($other_tpls))
        {
            app_tpl::assign('other_tpls', $other_tpls);
        }

        app_tpl::display('template_select.tpl');
    }

}

?>
