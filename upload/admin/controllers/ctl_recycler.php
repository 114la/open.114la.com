<?php
/**
 * 网址回收站
 *
 * @since 2009-7-14
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_recycler
{
    /**
     * 列表
     *
     * @return array
     */
	public static function index()
	{
	    try
	    {
            app_tpl::assign( 'npa', array('网址管理', '网址回收站') );
	        $start = (empty($_GET['start'])) ? 0 : (int)$_GET['start'];

		    $result = mod_recycler::get_list($start, PAGE_ROWS);
	        if (!empty($result))
            {
                app_tpl::assign('page_url', "?c=recycler");
                app_tpl::assign('pages', mod_pager::get_page_number_list($result['total'], $start, PAGE_ROWS));
                app_tpl::assign('list', $result['data']);

                app_tpl::assign('referer', $_SERVER['REQUEST_URI']);
            }
	    }
	    catch (Exception $e)
	    {

	    }
        app_tpl::display('recycler_list.tpl');
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
            $referer = (empty($_POST['referer'])) ? '?c=zhuanti' : $_POST['referer'];

            // 还原
            if (!empty($_POST['restore']))
            {
                $condition = '';
                foreach ($_POST['restore'] as $key => $val)
                {
                    $key = (int)$key;
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::query("INSERT INTO ylmf_site (name, url, adduser, class, namecolor, good, good2, displayorder, gooddisplayorder,remark)
                    			SELECT sitename, siteurl, '" . mod_login::get_username() . "', oldclass, namecolor, good, good2, displayorder, gooddisplayorder, remark FROM ylmf_recycler
                    			WHERE id IN ($condition) AND table_name = 'ylmf_site'");
                    app_db::query("INSERT INTO ylmf_indexsite (name, url, class, namecolor, displayorder, remark)
                    			SELECT sitename, siteurl, oldclass, namecolor, displayorder,remark FROM ylmf_recycler
                    			WHERE id IN ($condition) AND table_name = 'ylmf_indexsite'");

                    app_db::delete('ylmf_recycler', "id IN ($condition)");
                }
            }


            // 删除
            if (!empty($_POST['delete']))
            {
                $condition = '';
                foreach ($_POST['delete'] as $key => $val)
                {
                    $key = (int)$key;
                    $condition .= (empty($condition)) ? "{$key}" : ", {$key}";
                }
                if (!empty($condition))
                {
                    app_db::delete('ylmf_recycler', "id IN ($condition)");
                }
            }

            mod_login::message('操作成功', $referer);
	    }
	    catch (Exception $e)
	    {

	    }
	}
}
?>
