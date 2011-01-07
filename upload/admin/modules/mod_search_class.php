<?php

/**
 * 搜索栏分类管理
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_search_class
{
    /**
     * 获得搜索栏分类列表
     * @return <array>
     */
    public static function get_search_class_list()
    {
        app_db::query("SELECT * FROM `ylmf_searchclass` ORDER BY `sort` ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * 获得一个搜索栏分类信息
     * @return <array>
     */
    public static function get_search_class_info($classid)
    {
        app_db::query("SELECT * FROM `ylmf_searchclass` WHERE `classid`='{$classid}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * 获得一个搜索栏分类options
     * @return <array>
     */
    public static function get_search_class_options()
    {
        $sql = "SELECT `classid`,`classname` FROM `ylmf_searchclass` ORDER BY `sort` ASC";
        app_db::query($sql);
        $rows = app_db::fetch_all();
        $class = array();
        foreach ($rows as $row)
        {
            $class[$row['classid']] = $row['classname'];
        }
        return $class;
    }

    /**
     * 搜索栏分类 删除,接受数组格式
     * @return <array>
     */
    public static function search_class_delete($ids)
    {
        if (!is_array($ids))
        {
            exit("请选择删除数据.");
        }
        if ($ids = checkselid($ids))
        {
            //检查删除的分类下面是否有数据
            app_db::query("SELECT * FROM `ylmf_search` WHERE `class` IN($ids)");
            $have_ylmf_search = app_db::fetch_one();
            app_db::query("SELECT * FROM `ylmf_search_keyword` WHERE `class` IN($ids)");
            $have_ylmf_search_keyword = app_db::fetch_one();
            if (!empty($have_ylmf_search) || !empty($have_ylmf_search_keyword))
            {
                exit("此分类下有搜索引擎网址或关键字，不能被删除！");
            }

            //如果删除的分类中有一个是设为默认的,把一个没有删除的设为默认，要不然就没有默认的了
            app_db::query("SELECT * FROM `ylmf_searchclass` WHERE `classid` IN($ids) AND `is_default`=1");
            $have = app_db::fetch_one();
            if ($have)
            {
                app_db::query("UPDATE `ylmf_searchclass` SET `is_default`=1 WHERE `classid` NOT IN($ids) LIMIT 1");
            }
            app_db::query("DELETE FROM `ylmf_searchclass` WHERE `classid` IN($ids)");
        }
        else
        {
            exit("参数非法.");
        }
    }

    /**
     * 搜索栏分类 排序
     * @return <array>
     */
    public static function search_class_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_searchclass` SET `sort`='{$k}' WHERE `classid`='{$v}'");
            }
        }
    }

    /**
     * 搜索栏分类 是否显示首页操作
     * @return <array>
     */
    public static function search_class_set_default( $classid )
    {
        //勾选上的设为1
        if (!empty($classid))
        {
            //全部设为0
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`='0'");
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`='1' WHERE `classid`='{$classid}'");
        }
    }
    
    /**
     * 搜索栏分类 保存添加数据
     * @param <array> $form  添加的POST数据
     */
    public static function search_class_save_add($data)
    {
        if (empty($data['classname']))
        {
            throw new Exception("请输入分类名称");
        }
        $data['is_default'] = empty($data['is_default']) ? 0 : $data['is_default'];
        if ($data['is_default'])
        {   //如果当前分类设为默认，其他就都不是默认，全部设为0
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`=0");
        }
        $data['classname'] = Char_cv($data['classname']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::insert('ylmf_searchclass', array_keys($data), array_values($data)))
        {
            return true;
        }
        return false;
    }

    /**
     * 搜索栏分类 保存修改数据
     * @param <array> $data
     */
    public static function search_class_save_edit($data)
    {
        if (!is_numeric($data['classid']))
        {
            throw new Exception("非法参数");
        }
        $data['classid'] = intval($data['classid']);
        $info = app_db::query("SELECT * FROM `ylmf_searchclass` WHERE classid='{$data['classid']}' ");
        $info = app_db::fetch_one();
        if (!$info)
        {
            throw new Exception("没有这个搜索引擎分类");
        }
        $data['is_default'] = empty($data['is_default']) ? 0 : $data['is_default'];
        if ($data['is_default'])
        {   //如果当前分类设为默认，其他就都不是默认，全部设为0
            app_db::query("UPDATE `ylmf_searchclass` SET `is_default`=0");
        }
        $data['classname'] = trim($data['classname']);
        if ($data['classname'] == '')
        {
            throw new Exception("请输入搜索引擎分类名称");
        }
        $data['classname'] = Char_cv($data['classname']);
        $data['sort'] = trim($data['sort']);
        !is_numeric($data['sort']) && $data['sort'] = 100;
        if (app_db::update('ylmf_searchclass', $data, "classid='{$data['classid']}'"))
        {
            return true;
        }
        return false;
    }

}
