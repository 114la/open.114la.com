<?php

/**
 * 搜索引擎管理
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_search
{
    /**
     * 获得搜索引擎列表
     * @return <array>
     */
    public static function get_search_list($classid = '')
    {
        $and_sql = "";
        ($classid) && $and_sql = "WHERE class = '{$classid}'";
        app_db::query("SELECT a.*,b.classname FROM `ylmf_search` as a LEFT JOIN `ylmf_searchclass` as b ON a.class=b.classid  {$and_sql} ORDER BY a.`sort` ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * 获得一个搜索引擎信息
     * @return <array>
     */
    public static function get_search_info($id)
    {
        app_db::query("SELECT * FROM `ylmf_search` WHERE `id`='{$id}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * 搜索引擎 删除,接受数组格式
     * @return <array>
     */
    public static function search_delete($ids, $classid)
    {
        if (!is_array($ids))
        {
            exit("请选择删除数据.");
        }
        if ($ids = checkselid($ids))
        {
            //如果删除的搜索引擎中有一个是设为默认的,把一个没有删除的设为默认，要不然就没有默认的了
            app_db::query("SELECT * FROM `ylmf_search` WHERE `class`='{$classid}' AND `id` IN($ids) AND `is_default`=1");
            $have = app_db::fetch_one();
            if ($have)
            {
                app_db::query("UPDATE `ylmf_search` SET `is_default`=1 WHERE `class`='{$classid}' AND `id` NOT IN($ids) LIMIT 1");
            }
            app_db::query("DELETE FROM `ylmf_search` WHERE `class`='{$classid}' AND `id` IN($ids)");
        }
        else
        {
            exit("参数非法.");
        }
    }

    /**
     * 搜索引擎 排序
     * @return <array>
     */
    public static function search_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_search` SET `sort`='{$k}' WHERE `id`='{$v}'");
            }
        }
    }

     /**
     * 搜索引擎 是否显示首页操作
     * @return <array>
     */
    public static function search_is_show( $is_show, $classid )
    {
        //本栏目下全部设为0
        app_db::query("UPDATE `ylmf_search` SET `is_show`='0' WHERE `class`='{$classid}'");
        //本栏目下勾选上的设为1
        if (!empty($is_show))
        {
            foreach($is_show as $id)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_search` SET `is_show`='1' WHERE `class`='{$classid}' AND `id`='{$id}'");
            }
        }
    }

    /**
     * 搜索引擎 是否设为默认操作
     * @return <array>
     */
    public static function search_set_default( $id, $classid )
    {
        if (!empty($id))
        {
            //本栏目下全部设为0
            app_db::query("UPDATE `ylmf_search` SET `is_default`='0' WHERE `class`='{$classid}'");
            //栏目下勾选上的设为1
            app_db::query("UPDATE `ylmf_search` SET `is_default`='1' WHERE `class`='{$classid}' AND `id`='{$id}'");
        }
    }
    
    /**
     * 搜索引擎 保存添加数据
     * @param <array> $form  添加的POST数据
     */
    public static function search_save_add($data)
    {
        $classid = $data['class'];
        if (empty($data['search_select']))
        {
            throw new Exception("请输入名称");
        }
        if (empty($data['action']))
        {
            throw new Exception("请输入接口地址");
        }
        if (empty($data['name']))
        {
            throw new Exception("请输入搜索字段名");
        }
        if (empty($data['img_url']))
        {
            throw new Exception("请输入LOGO连接");
        }
        if (empty($data['btn']))
        {
            throw new Exception("请输入按钮文字");
        }
        //是否显示
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];

        //如果 "本栏目" 下不存在默认，设当前为默认
        app_db::query("SELECT * FROM `ylmf_search` WHERE `class`='{$classid}' AND `is_default`=1");
        $have_default = app_db::fetch_all();
        if (!$have_default)
        {
            $data['is_default'] = 1; 
        }
        
        //过滤html标签
        $data['search_select'] = Char_cv($data['search_select']);
        $data['action'] = Char_cv($data['action']);
        $data['name'] = Char_cv($data['name']);
        $data['url'] = Char_cv($data['url']);
        $data['img_url'] = Char_cv($data['img_url']);
        $data['img_text'] = Char_cv($data['img_text']);
        $data['btn'] = Char_cv($data['btn']);
        $data['params'] = addslashes($data['params']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::insert('ylmf_search', array_keys($data), array_values($data)))
        {
            return true;
        }
        return false;
    }

    /**
     * 搜索引擎 保存修改数据
     * @param <array> $data
     */
    public static function search_save_edit($data)
    {
        $classid = $data['class'];
        if (!is_numeric($data['id']))
        {
            throw new Exception("非法参数");
        }
        $data['id'] = intval($data['id']);
        $info = app_db::query("SELECT * FROM `ylmf_search` WHERE id='{$data['id']}' ");
        $info = app_db::fetch_one();
        if (!$info)
        {
            throw new Exception("没有这个搜索引擎");
        }
        //验证表单输入
        if (empty($data['search_select']))
        {
            throw new Exception("请输入名称");
        }
        if (empty($data['action']))
        {
            throw new Exception("请输入接口地址");
        }
        if (empty($data['name']))
        {
            throw new Exception("请输入搜索字段名");
        }
        if (empty($data['img_url']))
        {
            throw new Exception("请输入LOGO连接");
        }
        if (empty($data['btn']))
        {
            throw new Exception("请输入按钮文字");
        }
        //是否显示
        $data['is_show'] = empty($data['is_show']) ? 0 : $data['is_show'];
        //如果 "本栏目" 下不存在默认，设当前为默认
        app_db::query("SELECT * FROM `ylmf_search` WHERE `class`='{$classid}' AND `is_default`=1");
        $have_default = app_db::fetch_all();
        if (!$have_default)
        {
            $data['is_default'] = 1; 
        }

        //过滤html标签
        $data['search_select'] = Char_cv($data['search_select']);
        $data['action'] = Char_cv($data['action']);
        $data['name'] = Char_cv($data['name']);
        $data['url'] = Char_cv($data['url']);
        $data['img_url'] = Char_cv($data['img_url']);
        $data['img_text'] = Char_cv($data['img_text']);
        $data['btn'] = Char_cv($data['btn']);
        $data['params'] = addslashes($data['params']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::update('ylmf_search', $data, "id='{$data['id']}'"))
        {
            return true;
        }
        return false;
    }

}
