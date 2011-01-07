<?php
/**
 * 网址回收站
 *
 * @since 2009-7-14
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_recycler
{
	/**
	 * 获取列表
	 *
	 * @param int $start[optional]
	 * @param int $num[optional]
	 * @return array
	 */
	public static function get_list($start = 0, $num = 0)
	{
		if ($start > -1 && $num > 0)
		{
			$limit = " LIMIT {$start}, {$num}";
		}
		$data = app_db::select('ylmf_recycler', 'SQL_CALC_FOUND_ROWS *,
												IF(table_name = "ylmf_indexsite", "酷站导航", "网站管理表") AS table_name',
												"1 ORDER BY table_name {$limit}");
		if (empty($data))
		{
			return false;
		}

		$output = array();
		$total = app_db::query('SELECT FOUND_ROWS() AS rows');
		$total = app_db::fetch_one();
		$output['total'] = $total['rows'];
		$output['data'] = $data;
		$cache_main_class = mod_class::get_class_list();
		foreach ($output['data'] as &$row) {
			(isset($cache_main_class[$row['oldclass']]['classname'])) &&
			    $row['class_name'] = $cache_main_class[$row['oldclass']]['classname'];
		}

		return $output;
	}


	/**
	 * 获取一条记录
	 *
	 * @param $id
	 * @return array
	 */
	public static function get_one($id)
	{
		$id = (int)$id;
		if ($id < 1)
		{
			return false;
		}

		$data = app_db::select('ylmf_recycler', '*', "id = {$id}");
		return (empty($data)) ? false : $data[0];
	}
}
?>
