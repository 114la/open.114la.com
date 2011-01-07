<?php
/**
 * 名站轮播
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_famous_loop
{
	/**
	 * 名站轮播缓存
	 *
	 * @param array $famous_loop_data 标签数据
	 * @return void
	 */
	public static function update_cache_famous_loop($famous_loop_data = array())
	{
        if(!empty($famous_loop_data))
        {
            usort($famous_loop_data, "cmp");
        }
		mod_cache::set_cache('cache_famous_loop', $famous_loop_data);
	}


	/**
	 * 获取名站轮播列表
	 *
	 * @return array
	 */
	public static function get_famous_loop_list()
	{
		if (false == $output = mod_cache::get_cache('cache_famous_loop'))
		{
			self::update_cache_famous_loop();
			$output = mod_cache::get_cache('cache_famous_loop');
		}
		return $output;
	}

	/**
	 * 添加名站轮播
	 *
	 * @param array $famous_loop 新名站轮播数据
	 * @return array
	 */
	public static function add_famous_loop($famous_loop = array())
	{
        if(empty($famous_loop))
        {
            return false;
        }
        $list = self::get_famous_loop_list();
        $list[] = $famous_loop;
        self::update_cache_famous_loop($list);
    }

	/**
	 * 排序名站轮播
	 *
	 * @param array $order 名站轮播顺序
	 * @return array
	 */
	public static function order_famous_loop($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_famous_loop_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_famous_loop($list);
    }

	/**
	 * 修改名站轮播
	 *
	 * @param int $id 名站轮播id
	 * @param array $famous_loop 名站轮播数据
	 * @return array
	 */
	public static function edit_famous_loop($id = null, $famous_loop = array())
	{
        if($id === null || empty($famous_loop))
        {
            return false;
        }
        $list = self::get_famous_loop_list();
        $list[$id] = $famous_loop;
        self::update_cache_famous_loop($list);
    }

	/**
	 * 获取一个名站轮播的信息
     *
	 * @param int $id 名站轮播id
	 * @return array
	 */
	public static function get_famous_loop($id)
	{
        $list = self::get_famous_loop_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * 删除名站轮播
     *
	 * @param int/array $id 名站轮播id
	 * @return array
	 */
	public static function delete_famous_loop($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_famous_loop_list();
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
        self::update_cache_famous_loop($list);
    }

}
?>
