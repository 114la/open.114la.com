<?php
/**
 * 名站首行管理类
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_mztop
{
	/**
	 * 名站头部标签缓存
	 *
	 * @param array $mztop_data 标签数据
	 * @return void
	 */
	public static function update_cache_mztop($mztop_data = array())
	{
        if(!empty($mztop_data))
        {
            usort($mztop_data, "cmp");
        }
		mod_cache::set_cache('cache_mztop', $mztop_data);
	}


	/**
	 * 获取名站头部标签列表
	 *
	 * @return array
	 */
	public static function get_mztop_list()
	{
		if (false == $output = mod_cache::get_cache('cache_mztop'))
		{
			self::update_cache_mztop();
			$output = mod_cache::get_cache('cache_mztop');
		}
		return $output;
	}

	/**
	 * 添加名站头部标签
	 *
	 * @param array $mztop 新标签数据
	 * @return array
	 */
	public static function add_mztop($mztop = array())
	{
        if(empty($mztop))
        {
            return false;
        }
        $list = self::get_mztop_list();
        $list[] = $mztop;
        self::update_cache_mztop($list);
    }

	/**
	 * 修改名站头部标签
	 *
	 * @param int $id 标签id
	 * @param array $mztop 标签数据
	 * @return array
	 */
	public static function edit_mztop($id = null, $mztop = array())
	{
        if($id === null || empty($mztop))
        {
            return false;
        }
        $list = self::get_mztop_list();
        $list[$id] = $mztop;
        self::update_cache_mztop($list);
    }

	/**
	 * 排序/显示名站头部标签
	 *
	 * @param array $order 首行名站顺序
	 * @param array $order 首行名站显示
	 * @return array
	 */
	public static function order_mztop($order = null, $show = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_mztop_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
            $list[$i]['show'] = $show[$i] ? 1 : 0;
        }
        self::update_cache_mztop($list);
    }

	/**
	 * 获取一个标签的信息
     *
	 * @param int $id 标签id
	 * @return array
	 */
	public static function get_mztop($id)
	{
        $list = self::get_mztop_list();
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
	public static function delete_mztop($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_mztop_list();
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
        self::update_cache_mztop($list);
    }
}
?>
