<?php

/**
 * 友情链接管理
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_links
{
    /**
     * 获得友情链接列表
     * @return <array>
     */
    public static function get_links_list( $is_show = FALSE )
    {
        $and_sql = "";
        ($is_show) && $and_sql = " WHERE `is_show`=1";
        app_db::query("SELECT * FROM `ylmf_links` $and_sql ORDER BY `sort` ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * 获得一个友情链接信息
     * @return <array>
     */
    public static function get_links_info($id)
    {
        app_db::query("SELECT * FROM `ylmf_links` WHERE `id`='{$id}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * 友情链接 删除,接受数组格式
     * @return <array>
     */
    public static function links_delete($ids)
    {
        if (!is_array($ids))
        {
            exit("请选择删除数据.");
        }
        if ($ids = checkselid($ids))
        {
            app_db::query("DELETE FROM `ylmf_links` WHERE `id` IN($ids)");
            self::update_cache_links_js(); //更新缓存
        }
        else
        {
            exit("参数非法.");
        }
    }

    /**
     * 友情链接 排序
     * @return <array>
     */
    public static function links_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_links` SET `sort`='{$k}' WHERE `id`='{$v}'");
            }
        }
    }

    /**
     * 友情链接 是否显示首页操作
     * @return <array>
     */
    public static function links_is_show( $is_show )
    {
        //全部设为0
        app_db::query("UPDATE `ylmf_links` SET `is_show`='0'");
        //勾选上的设为1
        if (!empty($is_show))
        {
            foreach($is_show as $id)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_links` SET `is_show`='1' WHERE `id`='{$id}'");
            }
        }
    }
    
    /**
     * 友情链接 保存添加数据
     * @param <array> $form  添加的POST数据
     */
    public static function links_save_add($data)
    {
        if (empty($data['site_name']))
        {
            throw new Exception("请输入站点名称");
        }
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];
        $data['site_name'] = Char_cv($data['site_name']);
        if (!preg_match("#^http://#", $data['site_url']))
        {
            throw new Exception("网站地址不能为空或请以http://开头");
        }
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        $data['add_time'] = time();
        $data['remarks'] = char_cv(trim($data['remarks']));
        if (app_db::insert('ylmf_links', array_keys($data), array_values($data)))
        {
            self::update_cache_links_js(); //更新缓存
            return true;
        }
        return false;
    }

    /**
     * 友情链接 保存修改数据
     * @param <array> $data
     */
    public static function links_save_edit($data)
    {
        if (!is_numeric($data['id']))
        {
            throw new Exception("非法参数");
        }
        $data['id'] = intval($data['id']);
        $info = app_db::query("SELECT * FROM `ylmf_links` WHERE id='{$data['id']}' ");
        $info = app_db::fetch_one();
        if (!$info)
        {
            throw new Exception("没有这个站点");
        }
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];
        $data['site_name'] = trim($data['site_name']);
        if ($data['site_name'] == '')
        {
            throw new Exception("请输入站点名称");
        }
        $data['site_name'] = Char_cv($data['site_name']);
        if (!preg_match("#^http://#", $data['site_url']))
        {
            throw new Exception("网站地址不能为空或请以http://开头");
        }
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        $data['remarks'] = char_cv(trim($data['remarks']));
        if (app_db::update('ylmf_links', $data, "id='{$data['id']}'"))
        {
            self::update_cache_links_js(); //更新缓存
            return true;
        }
        return false;
    }

    /**
     * 检查网站是否已存在 未使用该方法
     *
     * @param int $site 网站名称或 URL
     */
    public static function check_exists($site)
    {
        $data = app_db::select('ylmf_links', 'id', "`site_name` = '{$site['site_name']}' OR `site_url` = '{$site['site_url']}'");
        return (empty($data)) ? false : true;
    }

    /**
     * 将友情链接生成为 JS
     *
     * @return viod
     */
    public static function update_cache_links_js()
    {
        // 广告合并成
        $tmp = "var m=1;\r\nvar n=Math.floor(Math.random()*m+1);\r\nswitch(n)\r\n{\r\n";
        $tmp .= "case 1:\r\n";
        $html = "<li class='bd'>";
        $html .= "<strong><a href='" .URL_HTML. "/catalog/links.htm'>友情连接</a> </strong>";
        $data = self::get_links_list(TRUE);
        if (!$data)
        {
            return false;
        }
        foreach ($data as $value)
        {
            $html .= "<a title='{$value['site_name']}' href='{$value['site_url']}'>{$value['site_name']}</a>";
        }
        $html .= "<span class='more'><a href='" .URL_HTML. "/catalog/links.htm'>更多 ?</a></span></li>";
        $tmp .= 'document.writeln("' . $html . '");' . "\r\n";
        $tmp .= "break;\r\n";
        $tmp .= "}\r\n";
        mod_file::write(PATH_ROOT . '/static/js/links.js', $tmp);
        mod_make_html::make_html_links();
        return true;
    }

}