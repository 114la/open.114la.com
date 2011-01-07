<?php
/**
 * 专题管理
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_key
{
    /**
     * 搜索
     *
     * @return void
     */
    public static function search()
    {
        try
        {
            $_GET['keyword'] = 'www';

            $keyword = (empty($_GET['keyword'])) ? '' : $_GET['keyword'];
            if (empty($keyword))
            {
                throw new Exception('请输入关键字', 10);
            }

            // 搜索
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];
            $result = mod_zhuanti::search($keyword, $start, PAGE_ROWS);
            if (empty($result))
            {
                throw new Exception('没有找到结果', 20);
            }

        }
        catch (Exception $e)
        {
            $message = $e->getMessage();
            $code = $e->getCode();

            echo $message;
        }
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
            app_tpl::assign( 'npa', array('广告管理', '关键词列表') );
            $show_type = 'default';
            // 按分类查看
            // 显示过期站点
            $isend = (empty($_GET['isend'])) ? false : true;
            // 显示首页显示站点
            $inindex = (empty($_GET['inindex'])) ? false : true;

            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];

            // 分类列表
            $class_list =  self::get_class_list();
            app_tpl::assign('class_list', $class_list);
            $class_list = @array_pop($class_list);
            $class_id = (empty($_GET['classid'])) ? $class_list[0]['id'] : $_GET['classid'];
            app_tpl::assign('class_id', $class_id);


            // 结果
            $result = mod_zhuanti::get_list($class_id, $isend, $inindex, $start, PAGE_ROWS, 'keyword');
            if (!empty($result))
            {
                app_tpl::assign('page_url', "?c=key&classid={$class_id}&isend={$isend}&inindex={$inindex}");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
                app_tpl::assign('list', $result['data']);

                app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());

        }
        app_tpl::display('key_site_list.tpl');
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
            $referer = (!empty($_POST['referer'])) ? $_POST['referer'] : '?c=key';
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

            $class_id = (empty($_POST['class_id'])) ? '' : $_POST['class_id'];
            if (empty($class_id))
            {
                throw new Exception('请选择分类', 10);
            }
            $data['class'] = $class_id;

            $order = (empty($_POST['order'])) ? 100 : $_POST['order'];
            $data['displayorder'] = $order;

            $inindex = (empty($_POST['inindex'])) ? 0 : $_POST['inindex'];
            $data['inindex'] = $inindex;

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
                $tmp = app_db::select('ylmf_tool', 'id', "(name = '{$site_name}')AND class = {$class_id}");
                if (!empty($tmp))
                {
                    throw new Exception('该网站已存在');
                }
                if (false === app_db::insert('ylmf_tool', array_keys($data), array_values($data)))
                {
                    throw new Exception('数据库操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    mod_login::message('添加成功', '?c=key');
                }

            }
            // 修改
            elseif ($action == 'modify')
            {
                $tmp = app_db::select('ylmf_tool', 'id', "(name = '{$site_name}')AND class = {$class_id} AND id != {$id}");
                if (!empty($tmp))
                {
                    throw new Exception('该网站已存在');
                }

                if ($id < 1 || false === app_db::update('ylmf_tool', $data, "id = {$id}"))
                {
                    throw new Exception('数据库操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    mod_login::message('修改成功', $referer);
                }
            }
            else
            {
                mod_login::message('操作失败', '?c=key');
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
        $_POST['remark'] = $_POST['remark'];
        $_POST['class'] = $_POST['class_id'];
        app_tpl::assign('data', $_POST);

        // 分类列表
        $class_list = self::get_class_list();
        app_tpl::assign('class_list', $class_list);

        app_tpl::display('key_site_edit.tpl');
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
                app_tpl::assign( 'npa', array('广告管理', '编辑关键词') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                if ($id < 1)
                {
                    throw new Exception('操作失败', 10);
                }
                $id = (int)$id;

                $result = mod_zhuanti::get_one($id);
                if (empty($result))
                {
                    throw new Exception('没有找到数据', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
                app_tpl::assign('referer', $_SERVER['HTTP_REFERER']);
            }
            else
            {
                app_tpl::assign( 'npa', array('广告管理', '新增关键词') );
                app_tpl::assign('action', 'add');
            }

            // 分类列表
            $class_list = self::get_class_list();
            if (empty($class_list))
            {
                throw new Exception('没有创建分类', 10);
            }
            app_tpl::assign('class_list', $class_list);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('key_site_edit.tpl');
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
            $referer = (empty($_POST['referer'])) ? '?c=key' : $_POST['referer'];
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
                    app_db::update('ylmf_tool', array('displayorder' => $val), "id = {$key}");
                }
            }

            // 首页显示
            if (!empty($_POST['inindex']))
            {
                $condition = '';
                foreach ($_POST['inindex'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1)
                    {
                        continue;
                    }
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::update('ylmf_tool', array('inindex' => 1), "id IN ($condition)");
                }
            }
            if (!empty($_POST['noindex']))
            {
                $condition = '';
                foreach ($_POST['noindex'] as $key => $val)
                {
                    if (!is_numeric($key) || $key < 1 || $val != 1)
                    {
                        continue;
                    }
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::update('ylmf_tool', array('inindex' => 0), "id IN ($condition)");
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
                        $tmp = mod_zhuanti::get_one($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '您将删除下列站点：<strong>' . $name . '</strong>，确认删除吗？');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=key&a=list_edit');

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
                        app_db::delete('ylmf_tool', "id IN ($condition)");
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


    /**
     * 获取用于 select 的分类列表
     *
     * @return array
     */
    private function get_class_list()
    {
        $class_list = mod_zhuanti_class::get_list('keyword');
        if (!empty($class_list['data']))
        {
            $new_class_list = array();
            foreach ($class_list['data'] as $row)
            {
                 $new_class_list[$row['type_zh']][] = array('id'=>$row['id'], 'name' => $row['name']);
            }
            return (empty($new_class_list)) ? false : $new_class_list;
        }
        return false;
    }
}
?>
