<?php

/**
 * 搜索引擎管理
 *
 * @since 2010-11-29
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class mod_search_keyword
{
    /**
     * 获得搜索引擎列表
     * @return <array>
     */
    public static function get_search_keyword_list($classid = '')
    {
        $and_sql = "";
        ($classid) && $and_sql = "WHERE class = '{$classid}'";
        app_db::query("SELECT a.*,b.classname FROM `ylmf_search_keyword` as a LEFT JOIN `ylmf_searchclass` as b ON a.class=b.classid  {$and_sql} ORDER BY a.sort ASC");
        $data = app_db::fetch_all();
        return (empty($data)) ? false : $data;
    }

    /**
     * 获得一个搜索引擎信息
     * @return <array>
     */
    public static function get_search_keyword_info($id)
    {
        app_db::query("SELECT * FROM `ylmf_search_keyword` WHERE `id`='{$id}'");
        $data = app_db::fetch_one();
        return (empty($data)) ? false : $data;
    }

    /**
     * 搜索引擎 删除,接受数组格式
     * @return <array>
     */
    public static function search_keyword_delete($ids)
    {
        if (!is_array($ids))
        {
            exit("请选择删除数据.");
        }
        if ($ids = checkselid($ids))
        {
            app_db::query("DELETE FROM `ylmf_search_keyword` WHERE `id` IN($ids)");
        }
        else
        {
            exit("参数非法.");
        }
    }

    /**
     * 搜索引擎关键字 排序
     * @return <array>
     */
    public static function search_keyword_sort( $sort )
    {
        if (!empty($sort))
        {
            foreach($sort as $v=>$k)
            {
                $k = intval($k);
                app_db::query("UPDATE `ylmf_search_keyword` SET `sort`='{$k}' WHERE `id`='{$v}'");
            }
        }
    }

    /**
     * 搜索引擎 保存添加数据
     * @param <array> $form  添加的POST数据
     */
    public static function search_keyword_save_add($data)
    {
        $data['class'] = (empty($data['class'])) ? '' : $data['class'];
        if (empty($data['class']))
        {
            throw new Exception('请选择分类', 10);
        }

        $data['name'] = (empty($data['name'])) ? '' : htmlspecialchars($data['name'], ENT_QUOTES);
        if (empty($data['name']))
        {
            throw new Exception('关键字名称不能为空', 10);
        }

        $data['url'] = (empty($data['url'])) ? '' : $data['url'];
        if (empty($data['url']) || !preg_match('#^http[s]?://#', $data['url']))
        {
            throw new Exception('网站地址不能为空或请以http://开头', 10);
        }

        $data['namecolor'] = (empty($data['namecolor'])) ? '' : trim($data['namecolor']);
        if (!empty($data['namecolor']) && !preg_match("/^#?([a-f]|[0-9]){3}(([a-f]|[0-9]){3})?$/i", $data['namecolor']))
        {
            throw new Exception('颜色代码不正确，（正确方式：#FF0000）', 10);
        }

        $data['sort'] = (empty($data['sort'])) ? 100 : $data['sort'];

        $data['starttime'] = (empty($data['starttime'])) ? 0 : strtotime($data['starttime']);

        $data['endtime'] = (empty($data['endtime'])) ? 0 : strtotime($data['endtime']);
        if ($data['endtime'] < $data['starttime'])
        {
            throw new Exception('结束时间不能早于开始时间', 10);
        }

        $data['remarks'] = (empty($data['remarks'])) ? '' : trim($data['remarks']);

        if (app_db::insert('ylmf_search_keyword', array_keys($data), array_values($data)))
        {
            return true;
        }
        return false;
    }

    /**
     * 搜索引擎 保存修改数据
     * @param <array> $data
     */
    public static function search_keyword_save_edit($data)
    {
        $data['class'] = (empty($data['class'])) ? '' : $data['class'];
        if (empty($data['class']))
        {
            throw new Exception('请选择分类', 10);
        }

        $data['name'] = (empty($data['name'])) ? '' : htmlspecialchars($data['name'], ENT_QUOTES);
        if (empty($data['name']))
        {
            throw new Exception('关键字名称不能为空', 10);
        }

        $data['url'] = (empty($data['url'])) ? '' : $data['url'];
        if (empty($data['url']) || !preg_match('#^http[s]?://#', $data['url']))
        {
            throw new Exception('网站地址不能为空或请以http://开头', 10);
        }

        $data['namecolor'] = (empty($data['namecolor'])) ? '' : trim($data['namecolor']);
        if (!empty($data['namecolor']) && !preg_match("/^#?([a-f]|[0-9]){3}(([a-f]|[0-9]){3})?$/i", $data['namecolor']))
        {
            throw new Exception('颜色代码不正确，（正确方式：#FF0000）', 10);
        }

        $data['sort'] = (empty($data['sort'])) ? 100 : $data['sort'];

        $data['starttime'] = (empty($data['starttime'])) ? 0 : strtotime($data['starttime']);

        $data['endtime'] = (empty($data['endtime'])) ? 0 : strtotime($data['endtime']);
        if ($data['endtime'] < $data['starttime'])
        {
            throw new Exception('结束时间不能早于开始时间', 10);
        }

        $data['remarks'] = (empty($data['remarks'])) ? '' : trim($data['remarks']);

        if (app_db::update('ylmf_search_keyword', $data, "id='{$data['id']}'"))
        {
            return true;
        }
        return false;
    }

}
