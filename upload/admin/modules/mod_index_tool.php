<?php
/**
 * 首页工具
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_index_tool
{
	/**
	 * 首页工具缓存
	 *
	 * @param array $index_tool_data 标签数据
	 * @return void
	 */
	public static function update_cache_index_tool($index_tool_data = array())
	{
        if(!empty($index_tool_data))
        {
            usort($index_tool_data, "cmp");
        }
		mod_cache::set_cache('cache_index_tool', $index_tool_data);
	}


	/**
	 * 获取首页工具列表
	 *
	 * @return array
	 */
	public static function get_index_tool_list()
	{
		if (false == $output = mod_cache::get_cache('cache_index_tool'))
		{
			self::update_cache_index_tool();
			$output = mod_cache::get_cache('cache_index_tool');
		}
		return $output;
	}

	/**
	 * 添加首页工具
	 *
	 * @param array $index_tool 新首页工具数据
	 * @return array
	 */
	public static function add_index_tool($index_tool = array())
	{
        if(empty($index_tool))
        {
            return false;
        }
        $list = self::get_index_tool_list();
        $list[] = $index_tool;
        self::update_cache_index_tool($list);
    }

	/**
	 * 排序首页工具
	 *
	 * @param array $order 首页工具顺序
	 * @return array
	 */
	public static function order_index_tool($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_index_tool_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_index_tool($list);
    }

	/**
	 * 修改首页工具
	 *
	 * @param int $id 首页工具id
	 * @param array $index_tool 首页工具数据
	 * @return array
	 */
	public static function edit_index_tool($id = null, $index_tool = array())
	{
        if($id === null || empty($index_tool))
        {
            return false;
        }
        $list = self::get_index_tool_list();
        $list[$id] = $index_tool;
        self::update_cache_index_tool($list);
    }

	/**
	 * 获取一个首页工具的信息
     *
	 * @param int $id 首页工具id
	 * @return array
	 */
	public static function get_index_tool($id)
	{
        $list = self::get_index_tool_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * 删除首页工具
     *
	 * @param int/array $id 首页工具id
	 * @return array
	 */
	public static function delete_index_tool($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_index_tool_list();
        if(is_array($id))
        {
            foreach($id as $i)
            {
                unset($list[$i]);
            }
        }
        else
        {
            unset($list[$id]);
        }
        self::update_cache_index_tool($list);
    }

}
?>
