<?php
/**
 * 网站管理控制器
 *
 * @copyright http://www.114la.com
 * @version    $Id: ctl_site_manage.php 1170 2009-11-28 10:01:09Z syh $
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_site_manage
{
    /**
     * 提示信息
     * @var string
     */
    private static $message = '';

    /**
     * 搜索
     *
     * @return void
     */
    public static function search()
    {
        try
        {
            $keyword = (empty($_REQUEST['keyword'])) ? '' : trim($_REQUEST['keyword']);
            if (empty($keyword))
            {
                throw new Exception('请输入关键字', 10);
            }

            $search_type = (empty($_REQUEST['search_type'])) ? 'url' : $_REQUEST['search_type'];
            if (empty($search_type) || ($search_type != 'name' && $search_type != 'url'))
            {
                throw new Exception('请选择正确的搜索类型', 10);
            }

            // 搜索
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
            $result = mod_site_manage::search($keyword, $search_type, $start, PAGE_ROWS);
            if (empty($result))
            {
                throw new Exception('没有找到结果', 20);
            }
            else
            {
                app_tpl::assign('list', $result['data']);
                app_tpl::assign('page_url', "?c=site_manage&a=search&search_type={$search_type}&keyword={$keyword}");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
            }
        }
        catch (Exception $e)
        {
            $code = $e->getCode();
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::assign('class_list', array());
        app_tpl::assign('class_id', $class_id);
        app_tpl::assign('keyword', $keyword );
        app_tpl::assign('search_type', $search_type );
        app_tpl::display('site_list.tpl');

    }


    /**
     * 显示
     *
     * @return void
     */
    public static function index()
    {
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '网址列表') );
            $show_type = 'default';
            // 按分类查看
            $class_id = (empty($_GET['classid'])) ? 0 : $_GET['classid'];
            // 显示过期站点
            $isend = (empty($_GET['isend'])) ? 0 : 1;

            // 结果
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
            $result = mod_site_manage::get_list($class_id, $isend, $start, PAGE_ROWS);

            if (!empty($result))
            {
                app_tpl::assign('list', $result['data']);
                app_tpl::assign('page_url', "?c=site_manage&classid={$class_id}&isend={$isend}");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
            }
            app_tpl::assign('referer', $_SERVER['REQUEST_URI']);

            app_tpl::assign('class_list', array());
            app_tpl::assign('class_id', $class_id);
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('site_list.tpl');
    }


    /**
     * 保存
     *
     * @return void
     */
    public static function save()
    {
        try
        {
            $action = (empty($_POST['action'])) ? '' : $_POST['action'];
            $referer = (empty($_POST['referer'])) ? '' : $_POST['referer'];
            if ($action != 'add' && $action != 'modify')
            {
                throw new Exception('操作失败', 10);
            }
            $data = array();

            $id = (empty($_POST['id'])) ? '' : $_POST['id'];

            $site_name = (empty($_POST['site_name'])) ? '' : htmlspecialchars($_POST['site_name'], ENT_QUOTES);
            if (empty($site_name))
            {
                throw new Exception('请输入站点名称', 10);
            }
            $data['name'] = $site_name;

            $site_url = (empty($_POST['site_url'])) ? '' : $_POST['site_url'];
            if (empty($site_url) || !preg_match('#^http[s]?://#', $site_url))
            {
                throw new Exception('网站地址不能为空或请以http://开头', 10);
            }
            $data['url'] = $site_url;

            $color = (empty($_POST['color'])) ? '' : trim($_POST['color']);
            if (!empty($color) && !preg_match("/^#?([a-f]|[0-9]){3}(([a-f]|[0-9]){3})?$/i", $color))
            {
                throw new Exception('颜色代码不正确，（正确方式：#FF0000）', 10);
            }
            $data['namecolor'] = $color;


            $class_id = 0;
            if (!empty($_POST['classid']))
            {
                if ((false === strpos($_POST['classid'], ',')))
                {
                    $class_id = $_POST['classid'];
                }
                else
                {
                    $tmp = explode(',', $_POST['classid']);
                    $class_id = trim($tmp[count($tmp) -1]);
                }
            }
            $cache_main_class = mod_class::get_class_list();
            if (!array_key_exists($class_id, $cache_main_class))
            {
                throw new Exception('请选择站点分类', 10);
            }
            if ($cache_main_class[$class_id]['parentid'] == 0 || $cache_main_class[$cache_main_class[$class_id]['parentid']]['parentid'] == 0)
            {
                throw new Exception('分类请选择子分类', 10);
            }
            if (preg_match("#^http[s]?://#", $cache_main_class[$class_id]['path']))
            {
                throw new Exception('父分类是外部链接,无法添加!', 10);
    	    }
            $data['class'] = $class_id;

            $recommend = (empty($_POST['recommend'])) ? 0 : 1;
            $data['good'] = $recommend;

            $order = (empty($_POST['order'])) ? 100 : $_POST['order'];
            $data['displayorder'] = $order;

            $start_time = (empty($_POST['start_time'])) ? 0 : strtotime($_POST['start_time']);
            $data['starttime'] = $start_time;

            $end_time = (empty($_POST['end_time'])) ? 0 : strtotime($_POST['end_time']);
            if ($end_time < $start_time)
            {
                throw new Exception('结束时间不能早于开始时间', 10);
            }
            $data['endtime'] = $end_time;

            $remark = (empty($_POST['remark'])) ? '' : trim($_POST['remark']);
            $data['remark'] = $remark;

            $data['adduser'] = addslashes(mod_login::get_username());
            // 新增
            if ($action == 'add')
            {
                // 检查是否已存在

                if (app_db::insert('ylmf_site', array_keys($data), array_values($data)))
                {
                    if ((false === strpos($_POST['classid'], ',')))
                    {
                        $tmp_class_id = $_POST['classid'];
                    }
                    else
                    {
                        $tmp = explode(',', $_POST['classid']);
                        $tmp_class_id = (count($tmp) > 1) ? trim($tmp[1]) : trim($tmp[0]);
                    }

                    mod_make_html::auto_update('catalog', $tmp_class_id);
                    mod_login::message('添加成功', '?c=site_manage&classid=' . $class_id);
                }
                else
                {
                    throw new Exception('数据库操作失败', 10);
                }
            }
            // 修改
            elseif ($action == 'modify')
            {

                $old = mod_site_manage::get_one($id);
                if ($id < 1 || false === app_db::update('ylmf_site', $data, "id = {$id}"))
                {
                    throw new Exception('数据库操作失败', 10);
                }
                else
                {
                    if ((false === strpos($_POST['classid'], ',')))
                    {
                        $tmp_class_id = $_POST['classid'];
                    }
                    else
                    {
                        $tmp = explode(',', $_POST['classid']);
                        $tmp_class_id = (count($tmp) > 1) ? trim($tmp[1]) : trim($tmp[0]);
                    }
                    mod_make_html::auto_update('catalog', $tmp_class_id);

                    $tmp_class_id1 = $old['class'];
                    if ((false !== strpos($tmp_class_id1, ',')))
                    {
                        $tmp = explode(',', $tmp_class_id1);
                        $tmp_class_id1 = (count($tmp) > 1) ? trim($tmp[1]) : trim($tmp[0]);
                    }

                    if ($tmp_class_id1 != $tmp_class_id)
                    {
                        mod_make_html::auto_update('catalog', $tmp_class_id1);
                    }

                    mod_login::message('修改成功', '?c=site_manage&classid=' . $class_id);
                }
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }

        app_tpl::assign('action', $action);
        app_tpl::assign('referer', $referer);

        $_POST['name'] = $_POST['site_name'];
        $_POST['url'] = $_POST['site_url'];
        $_POST['starttime'] = $_POST['start_time'];
        $_POST['endtime'] = $_POST['end_time'];
        $_POST['displayorder'] = $_POST['order'];
        $_POST['namecolor'] = $_POST['color'];
        $_POST['good'] = $_POST['recommend'];
        app_tpl::assign('data', $_POST);

        // 分类列表
        app_tpl::assign( 'class_list', '');
        app_tpl::assign('class_id', $_POST['class_id']);

        app_tpl::display('site_edit.tpl');
    }


    /**
     * 编辑
     *
     * @return void
     */
    public static function edit()
    {
        try
        {
            $action = (empty($_GET['action'])) ? '' : $_GET['action'];
            if (empty($action) || ($action != 'modify' && $action != 'add'))
            {
                throw new Exception('操作失败', 10);
            }


            if ($action == 'modify')
            {
                app_tpl::assign( 'npa', array('网址管理', '修改网址') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                if ($id < 1)
                {
                    throw new Exception('操作失败', 10);
                }
                $id = (int)$id;

                $result = mod_site_manage::get_one($id);
                if (empty($result))
                {
                    throw new Exception('没有找到数据', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
                app_tpl::assign('referer', $_SERVER['HTTP_REFERER']);

                app_tpl::assign('class_id', $result['class']);
                $class_info = mod_class::get_a_class( $result['class'] );
                $class_id_list = $class_info['id_list'] . ',' . $result['class'];
                app_tpl::assign( 'class_id_list', $class_id_list );
            }
            else
            {
                app_tpl::assign( 'npa', array('网址管理', '添加网址') );
                $class_id = (empty($_GET['classid'])) ? 0 : $_GET['classid'];
                if($class_id)
                {
                    $class_info = mod_class::get_a_class( $class_id );
                    $class_id_list = $class_info['id_list'] . ',' . $class_id;
                    app_tpl::assign( 'class_id_list', $class_id_list );
                }
                app_tpl::assign('action', 'add');
            }

            $class_list = mod_class::get_subclass_list(0);
            if (empty($class_list))
            {
                throw new Exception('没有创建分类');
            }
            app_tpl::assign( 'class_list', $class_list);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('site_edit.tpl');
    }


	/**
     * 列表操作
     *
     * @return void
     */
    public static function list_edit()
    {
        try
        {
            $referer = (empty($_POST['referer'])) ? '?c=site_manage' : $_POST['referer'];
            // 排序
            if (!empty($_POST['order']))
            {
                foreach ($_POST['order'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1)
                    {
                        continue;
                    }
                    $key = (int)$key;
                    $val = (empty($val)) ? 100 : (int)$val;
                    app_db::update('ylmf_site', array('displayorder' => $val), "id = {$key}");
                }
            }

            // 推荐
            if (!empty($_POST['recommend']))
            {
                $condition = '';
                foreach ($_POST['recommend'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1)
                    {
                        continue;
                    }
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::update('ylmf_site', array('good' => 1), "id IN ($condition)");
                }
            }
            if (!empty($_POST['norecommend']))
            {
                $condition = '';
                foreach ($_POST['norecommend'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1 || $val != 1)
                    {
                        continue;
                    }
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::update('ylmf_site', array('good' => 0), "id IN ($condition)");
                }
            }

            // 删除
            if (!empty($_POST['delete']))
            {
                if (empty($_POST['step']))
                {
                    $name = '';
                    $delete = array();
                    foreach ($_POST['delete'] as $key => $val)
                    {
                        $key = (int)$key;
                        $delete[] = $key;
                        $tmp = mod_site_manage::get_one($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '您将删除下列站点：<strong>' . $name . '</strong>，确认删除吗？');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=site_manage&a=list_edit');

                    app_tpl::display('confirm.tpl');
                    exit;
                }
                else
                {
                    $condition = '';
                    $_POST['delete'] = explode(',', $_POST['delete']);
                    foreach ($_POST['delete'] as $key => $val)
                    {
                        $val = (int)$val;
                        $condition .= (empty($condition)) ? "{$val}" : ", {$val}";
                    }
                    if (!empty($condition))
                    {
                        app_db::query("INSERT INTO ylmf_recycler (table_name, sitename,siteurl,oldclass,namecolor,adduser,good,good2,displayorder,gooddisplayorder, remark)
                                        SELECT 'ylmf_site', name,url,class,namecolor,'" . mod_login::get_username() . "',good,good2,displayorder,gooddisplayorder, remark FROM ylmf_site WHERE id IN ($condition)");
                        app_db::delete('ylmf_site', "id IN ($condition)");
                    }
                    $referer = preg_replace("/&start=\d+/", "", $referer);
                }
            }
            mod_login::message('操作成功', $referer);
        }
        catch (Exception $e)
        {

        }
    }


    /**
     * 移动
     *
     * @return array
     */
    public static function mv()
    {
        try
        {
            $id = (empty($_POST['id'])) ? '' : $_POST['id'];
            if (!is_array($id) || empty($id))
            {
                throw new Exception('操作失败');
            }

            $cache_main_class = mod_class::get_class_list();
            $mv2class = (empty($_POST['mv2class'])) ? 0 : (int)$_POST['mv2class'];
            if (!array_key_exists($mv2class, $cache_main_class))
            {
                throw new Exception('非法的目标分类');
            }
            $condition = '';
            foreach ($id as $val)
            {
                $val = (int)$val;
                $condition .= (empty($condition)) ? "{$val}" : ", {$val}";
            }
            app_db::update('ylmf_site', array('class' => $mv2class), "id = {$condition}");
        }
        catch (Exception $e)
        {

        }
    }

    /**
     * 批量新增站点
     *
     * @return array
     */
    public static function multi_add()
    {
        app_tpl::assign( 'npa', array('网址管理', '批量添加网址') );
        if(!empty($_POST))
        {
            mod_site_manage::multi_add($_POST);
            mod_login::message('批量添加成功', '?c=site_manage&classid=' . $_POST['classid']);
            exit;
        }

        $class_list = mod_class::get_subclass_list(0);
        if (empty($class_list))
        {
            throw new Exception('没有创建分类');
        }
        app_tpl::assign( 'class_list', $class_list);
        app_tpl::display('site_multi_add.tpl');
    }


    /**
     * 批量导入站点
     *
     * @return array
     */
    public static function import()
    {
        app_tpl::assign( 'npa', array('网址管理', '批量导入网址') );
        if(!empty($_POST['sites']))
        {
            mod_site_manage::import($_POST);
            mod_login::message('网址导入成功', '?c=site_manage&classid=' . $_POST['classid']);
            exit;
        }
        $class_list = mod_class::get_subclass_list(0);
        if (empty($class_list))
        {
            throw new Exception('没有创建分类');
        }
        app_tpl::assign( 'class_list', $class_list);
        app_tpl::display('site_import.tpl');
    }
}
?>
