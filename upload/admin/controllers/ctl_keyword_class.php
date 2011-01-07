<?php
/**
 * 关键字分类管理
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_keyword_class
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
            app_tpl::assign( 'npa', array('广告管理', '关键词分类列表') );
            // 结果
            $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];

            $result = mod_zhuanti_class::get_list('keyword');

            app_tpl::assign('list', $result['data']);

            app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            app_tpl::assign('key', $type);
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('keyword_class_list.tpl');
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
            $name = (empty($_POST['name'])) ? '' : $_POST['name'];
            $type = 'keyword';

            $data['type'] = $type;
            $data['name'] = $name;

            // 新增
            if ($action == 'add')
            {
                $tmp = app_db::select('ylmf_toolclass', '*', "type = '{$type}' AND name = '{$name}'");
                if (!empty($tmp))
                {
                    throw new Exception('该分类名称已存在', 10);
                }

                if (false === app_db::insert('ylmf_toolclass', array_keys($data), array_values($data)))
                {
                    throw new Exception('数据库操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    //mod_make_html::auto_update('zhuanti', $type);
                    mod_login::message('添加成功', '?c=keyword_class&type=' . $type);
                }

            }
            // 修改
            elseif ($action == 'modify')
            {
                $tmp = app_db::select('ylmf_toolclass', '*', "type = '{$type}' AND name = '{$name}' AND id != {$id}");
                if (!empty($tmp))
                {
                    throw new Exception('该分类名称已存在', 10);
                }

                $old = app_db::select('ylmf_toolclass', 'type', "id = {$id}");
                if ($id < 1 || false === app_db::update('ylmf_toolclass', $data, "id = {$id}"))
                {
                    throw new Exception('数据库操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');
                    //mod_make_html::auto_update('zhuanti', $type);
                    if (!empty($old[0]['type']))
                    {
                        //mod_make_html::auto_update('zhuanti', $old[0]['type']);
                    }

                    mod_login::message('修改成功', '?c=keyword_class&type=' . $type);
                }
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }

        app_tpl::assign('action', $action);
        app_tpl::assign('referer', $referer);
        app_tpl::assign('data', $_POST);

        // 分类列表
        app_tpl::display('keyword_class_edit.tpl');
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
            $referer = (empty($_POST['referer'])) ? '?c=keyword_class' : $_POST['referer'];
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
                    app_db::update('ylmf_toolclass', array('displayorder' => $val), "id = {$key}");
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
                    app_db::update('ylmf_toolclass', array('inindex' => 1), "id IN ($condition)");
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
                    app_db::update('ylmf_toolclass', array('inindex' => 0), "id IN ($condition)");
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
                        $tmp = mod_zhuanti_class::get_one($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '您将删除下列分类：<strong>' . $name . '</strong>，确认删除吗？');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=keyword_class&a=list_edit');

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
                        app_db::delete('ylmf_toolclass', "id IN ($condition)");
                    }
                }
            }
            mod_make_html::auto_update('index');
            mod_make_html::auto_update('zhuanti');

            mod_login::message('操作成功', $referer);
        }
        catch (Exception $e)
        {

        }
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
            $referer = (empty($_SERVER['HTTP_REFERER'])) ? '?c=zhuant_clas' : $_SERVER['HTTP_REFERER'];
            if (empty($action) || ($action != 'modify' && $action != 'add'))
            {
                throw new Exception('操作失败', 10);
            }

            if ($action == 'modify')
            {
                app_tpl::assign( 'npa', array('广告管理', '编辑关键词分类') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                if ($id < 1)
                {
                    throw new Exception('操作失败', 10);
                }
                $id = (int)$id;

                $result = mod_zhuanti_class::get_one($id);
                if (empty($result))
                {
                    throw new Exception('没有找到数据', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
            }
            else
            {
                app_tpl::assign( 'npa', array('广告管理', '新增关键词分类') );
                app_tpl::assign('action', 'add');
            }

            app_tpl::assign('referer', $referer);

            require PATH_DATA . '/conf/zhuantidb.php';
            app_tpl::assign('class_list', $zhuantidb);
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('keyword_class_edit.tpl');
    }
}
?>
