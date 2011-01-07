<?php
/**
 * 名站头部标签管理类
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_famous_tab
{
	/**
	 * 名站头部标签缓存
	 *
	 * @param array $famous_tab_data 标签数据
	 * @return void
	 */
	public static function update_cache_famous_tab($famous_tab_data = array())
	{
        if(!empty($famous_tab_data))
        {
            usort($famous_tab_data, "cmp");
        }
		mod_cache::set_cache('cache_famous_tab', $famous_tab_data);
	}


	/**
	 * 获取名站头部标签列表
	 *
	 * @return array
	 */
	public static function get_famous_tab_list()
	{
		if (false == $output = mod_cache::get_cache('cache_famous_tab'))
		{
			self::update_cache_famous_tab();
			$output = mod_cache::get_cache('cache_famous_tab');
		}
		return $output;
	}

	/**
	 * 添加名站头部标签
	 *
	 * @param array $famous_tab 新标签数据
	 * @return array
	 */
	public static function add_famous_tab($famous_tab = array())
	{
        if(empty($famous_tab))
        {
            return false;
        }
        $list = self::get_famous_tab_list();
        $list[] = $famous_tab;
        self::update_cache_famous_tab($list);
    }

	/**
	 * 修改名站头部标签
	 *
	 * @param int $id 标签id
	 * @param array $famous_tab 标签数据
	 * @return array
	 */
	public static function edit_famous_tab($id = null, $famous_tab = array())
	{
        if($id === null || empty($famous_tab))
        {
            return false;
        }
        $list = self::get_famous_tab_list();
        $list[$id] = $famous_tab;
        self::update_cache_famous_tab($list);
    }

	/**
	 * 排序名站头部标签
	 *
	 * @param array $order 标签顺序
	 * @return array
	 */
	public static function order_famous_tab($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_famous_tab_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_famous_tab($list);
    }

	/**
	 * 获取一个标签的信息
     *
	 * @param int $id 标签id
	 * @return array
	 */
	public static function get_famous_tab($id)
	{
        $list = self::get_famous_tab_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * 删除标签
     *
	 * @param int/array $id 标签id
	 * @return array
	 */
	public static function delete_famous_tab($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_famous_tab_list();
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
        self::update_cache_famous_tab($list);
    }
}
?>
