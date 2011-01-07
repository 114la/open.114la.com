<?php
/**
 * 地方服务首页站点管理类
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 * @version    $Id: mod_local_index.php 172 2009-11-19 01:03:44Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_local_index
{
	/**
	 * 站点缓存
	 *
	 * @param array $local_index_data 站点数据
	 * @return void
	 */
	public static function update_cache_local_index($local_index_data = array())
	{
        if(!empty($local_index_data))
        {
            usort($local_index_data, "cmp");
        }
		mod_cache::set_cache('cache_local_index', $local_index_data);
	}


	/**
	 * 获取站点列表
	 *
	 * @return array
	 */
	public static function get_local_index_list()
	{
		if (false == $output = mod_cache::get_cache('cache_local_index'))
		{
			self::update_cache_local_index();
			$output = mod_cache::get_cache('cache_local_index');
		}
		return $output;
	}

	/**
	 * 添加站点工具
	 *
	 * @param array $local_index 新站点数据
	 * @return array
	 */
	public static function add_local_index($local_index = array())
	{
        if(empty($local_index))
        {
            return false;
        }
        $list = self::get_local_index_list();
        $list[] = $local_index;
        self::update_cache_local_index($list);
    }

	/**
	 * 排序站点
	 *
	 * @param array $order 站点顺序
	 * @return array
	 */
	public static function order_local_index($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_local_index_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_local_index($list);
    }

	/**
	 * 修改站点
	 *
	 * @param int $id 站点id
	 * @param array $local_index 站点数据
	 * @return array
	 */
	public static function edit_local_index($id = null, $local_index = array())
	{
        if($id === null || empty($local_index))
        {
            return false;
        }
        $list = self::get_local_index_list();
        $list[$id] = $local_index;
        self::update_cache_local_index($list);
    }

	/**
	 * 获取一个站点的信息
     *
	 * @param int $id 站点id
	 * @return array
	 */
	public static function get_local_index($id)
	{
        $list = self::get_local_index_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * 删除站点
     *
	 * @param int/array $id 站点id
	 * @return array
	 */
	public static function delete_local_index($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_local_index_list();
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
        self::update_cache_local_index($list);
    }

}
?>
