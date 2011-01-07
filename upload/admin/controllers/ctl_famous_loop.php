<?php
/**
 * 名站轮播
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_famous_loop
{
    /**
     * 提示信息
     * @var string
     */
    private static $message = '';

    /**
     * 显示
     *
     * @return viod
     */
	public static function index()
	{
        try
        {
            app_tpl::assign( 'npa', array('网址管理', '名站轮播站点管理') );
            $result = mod_famous_loop::get_famous_loop_list();
            if (!empty($result))
            {
                app_tpl::assign('list', $result);
            }
        }
        catch (Exception $e)
        {

        }
        app_tpl::display('famous_loop_list.tpl');
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

            $id = (int)$_POST['id'];

            $site_name = (empty($_POST['name'])) ? '' : htmlspecialchars($_POST['name'], ENT_QUOTES);
            if (empty($site_name))
            {
                throw new Exception('操作失败', 10);
            }
            $data['name'] = $site_name;

            $site_url = (empty($_POST['url'])) ? '' : $_POST['url'];
            if (empty($site_url) || !preg_match('#^http[s]?://#', $site_url))
            {
                throw new Exception('网站地址不能为空或请以http://开头', 10);
            }
            $data['url'] = $site_url;
            $order = (empty($_POST['order'])) ? 100 : $_POST['order'];
            $data['order'] = $order;
            $data['color'] = $_POST['color'];

            // 新增
            if ($action == 'add')
            {

                if (false === mod_famous_loop::add_famous_loop($data))
                {
                    throw new Exception('操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');

                    mod_login::message('添加成功', '?c=famous_loop');
                }

            }
            // 修改
            elseif ($action == 'modify')
            {
                if ($id < 0 || false === mod_famous_loop::edit_famous_loop($id, $data))
                {
                    throw new Exception('操作失败', 10);
                }
                else
                {
                    //mod_make_html::auto_update('index');

                    mod_login::message('修改成功', '?c=famous_loop');
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
        app_tpl::display('famous_loop_edit.tpl');
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
                app_tpl::assign( 'npa', array('网址管理', '编辑名站轮播站点') );
                $id = (empty($_GET['id'])) ? 0 : $_GET['id'];
                $id = (int)$id;

                $result = mod_famous_loop::get_famous_loop($id);
                if (empty($result))
                {
                    throw new Exception('没有找到数据', 10);
                }
                app_tpl::assign('data', $result);
                app_tpl::assign('action', 'modify');
                app_tpl::assign('id', $id);
                app_tpl::assign('referer', (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '');
            }
            else
            {
                app_tpl::assign( 'npa', array('网址管理', '新增编辑名站轮播站点') );
                app_tpl::assign('action', 'add');
            }
        }
        catch (Exception $e)
        {
            app_tpl::assign('error', $e->getMessage());
        }
        app_tpl::display('famous_loop_edit.tpl');
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
            $referer = (empty($_POST['referer'])) ? '?c=famous_loop' : $_POST['referer'];
            // 排序
            if (!empty($_POST['order']))
            {
                mod_famous_loop::order_famous_loop($_POST['order']);
            }

            // 删除
            if (isset($_POST['delete']))
            {
                if (empty($_POST['step']))
                {
                    $name = '';
                    $delete = array();
                    foreach ($_POST['delete'] as $key => $val)
                    {
                        $key = (int)$key;
                        $delete[] = $key;
                        $tmp = mod_famous_loop::get_famous_loop($key);
                        $name .= $tmp['name'] . ', ';
                    }
                    (!empty($name)) && $name = substr($name, 0, -2);
                    app_tpl::assign('message', '您将删除下列标签：<strong>' . $name . '</strong>，确认删除吗？');
                    app_tpl::assign('delete', implode(',', $delete));
                    app_tpl::assign('referer', $referer);
                    app_tpl::assign('action_url', '?c=famous_loop&a=list_edit');

                    app_tpl::display('confirm.tpl');
                    exit;
                }
                else
                {
                    $delete_id = explode(',', $_POST['delete']);
                    if (!empty($delete_id))
                    {
                        mod_famous_loop::delete_famous_loop($delete_id);
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
