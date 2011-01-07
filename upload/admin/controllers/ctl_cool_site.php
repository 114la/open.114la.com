<?php
/**
 * 首页站点管理（酷站导航）
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_cool_site
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
            $keyword = (empty($_GET['keyword'])) ? '' : trim($_GET['keyword']);
            if (empty($keyword))
            {
                throw new Exception('请输入关键字', 10);
            }

            $search_type = (empty($_GET['search_type'])) ? 'url' : $_GET['search_type'];
            if (empty($search_type) || ($search_type != 'name' && $search_type != 'url'))
            {
                throw new Exception('请选择正确的搜索类型', 10);
            }

            // 搜索
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
            $result = mod_cool_site::search($keyword, $search_type, $start, PAGE_ROWS);
            if (empty($result))
            {
                throw new Exception('没有找到结果', 20);
            }
            else
            {
                app_tpl::assign('list', $result['data']);
                app_tpl::assign('page_url', "?c=cool_site&a=search&search_type={$search_type}&keyword={$keyword}");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
            }
        }
        catch (Exception $e)
        {
            $message = $e->getMessage();
            $code = $e->getCode();
            app_tpl::assign('error', $message );
        }
        app_tpl::assign('class_list', mod_cool_class::get_class_list());
        app_tpl::assign('class_id', $class_id);
        app_tpl::assign('keyword', $keyword );
        app_tpl::assign('search_type', $search_type );
        app_tpl::display('cool_site_list.tpl');

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
            app_tpl::assign( 'npa', array('网址管理', '酷站列表') );
            $show_type = 'default';
            // 按分类查看
            $class_id = (empty($_GET['classid'])) ? 0 : $_GET['classid'];
            // 显示过期站点
            $isend = (empty($_GET['isend'])) ? false : true;
            // 显示首页显示站点
            $inindex = (empty($_GET['inindex'])) ? false : true;

            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];

            // 分类列表
            app_tpl::assign('class_list', mod_cool_class::get_class_list());
            app_tpl::assign('class_id', $class_id);

            // 结果
            $result = mod_cool_site::get_list($class_id, $isend, $start, PAGE_ROWS);
            if (!empty($result))
            {
                app_tpl::assign('page_url', "?c=cool_site&classid={$class_id}&isend={$isend}");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
                app_tpl::assign('list', $result['data']);
                app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            }
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('cool_site_list.tpl');
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
                app_tpl::assign( 'npa', array('网址管理', '编辑酷站') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                if ($id < 1)
                {
                    throw new Exception('操作失败', 10);
                }
                $id = (int)$id;

                $result = mod_cool_site::get_one($id);
                if (empty($result))
                {
                    throw new Exception('没有找到数据', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
                app_tpl::assign('referer', (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '');
            }
            else
            {
                app_tpl::assign( 'npa', array('网址管理', '新增酷站') );
                app_tpl::assign('data', array('class'=>$_GET['classid']));
                app_tpl::assign('action', 'add');
            }
            app_tpl::assign('class_list', mod_cool_class::get_class_list());
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('cool_site_edit.tpl');
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
                throw new Exception('操作失败', 10);
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

            $class_id = (empty($_POST['class_id'])) ? 0 : $_POST['class_id'];
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


            // 新增
            if ($action == 'add')
            {
                // 检查是否已存在
                $class_list = mod_cool_class::get_class_list();
                if(empty($class_list))
                {
                    throw new Exception('请先添加酷站分类', 10);
                }
                $tmp = app_db::select('ylmf_coolsite', 'id', "(name = '{$site_name}' OR url = '{$site_url}') AND class = {$class_id}");
                if (!empty($tmp))
                {
                    throw new Exception('该网站已存在');
                }

                if (false === app_db::insert('ylmf_coolsite', array_keys($data), array_values($data)))
                {
                    throw new Exception('数据库操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');

                    mod_login::message('添加成功', '?c=cool_site&classid=' . $class_id);
                }

            }
            // 修改
            elseif ($action == 'modify')
            {
                // 检查是否已存在
                $tmp = app_db::select('ylmf_coolsite', 'id', "id != {$id} AND (name = '{$site_name}' OR url = '{$site_url}') AND class = {$class_id}");
                if (!empty($tmp))
                {
                    throw new Exception('该网站已存在');
                }

                if ($id < 1 || false === app_db::update('ylmf_coolsite', $data, "id = {$id}"))
                {
                    throw new Exception('数据库操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');

                    mod_login::message('修改成功', '?c=cool_site&classid=' . $class_id);
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
        app_tpl::assign('class_list', mod_cool_class::get_class_list());

        app_tpl::display('cool_site_edit.tpl');
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
            $referer = (empty($_POST['referer'])) ? '?c=cool_site' : $_POST['referer'];
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
                    app_db::update('ylmf_coolsite', array('displayorder' => $val), "id = {$key}");
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
                    app_db::update('ylmf_coolsite', array('good' => 1), "id IN ($condition)");
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
                    app_db::update('ylmf_coolsite', array('good' => 0), "id IN ($condition)");
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
                        $tmp = mod_cool_site::get_one($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '您将删除下列站点：<strong>' . $name . '</strong>，确认删除吗？');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=cool_site&a=list_edit');

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
                        app_db::query("INSERT INTO ylmf_recycler (table_name, sitename,siteurl,oldclass, adduser, namecolor,displayorder,remark)
                        			SELECT 'ylmf_coolsite', name,url,class, '" . mod_login::get_username() . "', namecolor,displayorder,remark FROM ylmf_coolsite WHERE id IN ($condition)");
                        app_db::delete('ylmf_coolsite', "id IN ($condition)");
                    }
                }
            }
            //mod_make_html::auto_update('index');

            mod_login::message('操作成功', $referer);
        }
        catch (Exception $e)
        {

        }
    }
}
?>
