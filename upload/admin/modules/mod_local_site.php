<?php
/**
 * 地方服务管理类
 *
 * @copyright http://www.114la.com
 * @version    $Id: mod_local_site.php 170 2009-11-19 00:41:25Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_local_site
{
	/**
	 * 返回搜索结果
	 *
	 * @param string $keyword
	 * @param string $search_type
	 * @param int $start[optional]
	 * @param int $num[optional]
	 * @return array
	 */
	public static function search($keyword, $search_type, $start = 0, $num = 0)
	{
		if ($search_type != 'url' && $search_type != 'name')
		{
			return false;
		}

		$condition = " AND a.`{$search_type}` LIKE '%{$keyword}%'";
		if ($start > -1 && $num > 0)
		{
			$condition .= " LIMIT {$start}, {$num}";
		}

	    $sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.classid AS class_id, b.classname AS class_name, a.name, a.url, a.displayorder, a.starttime, a.endtime, a.namecolor, a.adduser, a.good
                FROM ylmf_localsite AS a, ylmf_localclass AS b
                WHERE a.class = b.classid ' . $condition;
		$query = app_db::query($sql);


		$data = array();
		while ($rt = app_db::fetch_one($query))
		{
		    $data[] = $rt;
		}
		if (empty($data))
		{
			return false;
		}
		/*
		$data = app_db::select('ylmf_localsite', 'SQL_CALC_FOUND_ROWS *', $contition);
		if (empty($data))
		{
			return false;
		}*/

		$output = array();
		$total = app_db::query('SELECT FOUND_ROWS() AS rows');
		$total = app_db::fetch_one();
		$output['total'] = $total['rows'];
		$output['data'] = $data;
		return $output;
	}


	/**
	 * 获取列表
	 *
	 * @param int $class_id
	 * @param int $isend
	 * @param int $start[optional]
	 * @param int $num[optional]
	 * @return array
	 */
	public static function get_list($class_id = 0, $isend = false, $start = 0, $num = 20)
	{
		$condition = '';

		$cache_main_class = mod_local_class::get_class_list();
		// 分类
		if ($class_id > 0)
		{
            $condition .=  " AND `class` = {$class_id}";
		}

		// 过期
		if ($isend)
		{
			$condition .= (!empty($condition)) ? ' AND `endtime` > 0 AND `endtime` < ' . time() :
												 ' AND `endtime` > 0 AND `endtime` < ' . time();
		}

		$condition .= ' ORDER BY class, a.displayorder';
		if ($start > -1 && $num > 0)
		{
			$condition .= " LIMIT {$start}, {$num}";
		}

	    $sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.classid AS class_id, b.classname AS class_name, a.name, a.url, a.displayorder, a.starttime, a.endtime, a.namecolor, a.adduser, a.good
                FROM ylmf_localsite AS a, ylmf_localclass AS b
                WHERE a.class = b.classid ' . $condition;
		$query = app_db::query($sql);

		$data = array();
		while ($rt = app_db::fetch_one())
		{
		    $data[] = $rt;
		}
		if (empty($data))
		{
			return false;
		}

		$output = array();
		$total = app_db::query('SELECT FOUND_ROWS() AS rows');
		$total = app_db::fetch_one();
		$output['total'] = $total['rows'];
		$output['data'] = $data;
		return $output;
	}


	/**
	 * 获取一个站点的信息
	 */
	public static function get_one($id)
	{
		if ($id < 1)
		{
			return false;
		}
		$id = (int)$id;

		$data = app_db::select('ylmf_localsite', '*', "id = {$id}");
		return (empty($data)) ? false : $data[0];
	}


	/**
	 * 检查网站是否已存在
	 *
	 * @param int $class_id
	 * @param int $site 网站名或 URL
	 */
	public static function check_exists($class_id, $site)
	{
		$class_id = (int)$class_id;
		$data = app_db::select('ylmf_localsite', 'id', "`class` = {$class_id} AND (`name` = '{$site}' OR url = '{$site}')");
		return (empty($data)) ? false : true;
	}


	/**
	 * 删除分类的所有网站
	 *
	 * @param int $class_id 分类ID
	 */
	public static function delete_by_class($class_id)
	{
		$class_id = (int)$class_id;
		if ($class_id < 1)
		{
			return false;
		}

		return app_db::delete('ylmf_localsite', "class = {$class_id}");
	}
}
?>
