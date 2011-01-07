<?php
/**
 * 网站收录
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_url_add
{
	/**
	 * 返回列表
	 *
	 * @param int $type
	 * @param int $start[optional]
	 * @param int $page_rows[optional]
	 * @return array
	 */
	public static function get_list($type, $start = 0, $num = 0)
	{
		$limit = '';
		if ($start > -1 && $num > 0)
		{
			$limit = " LIMIT {$start}, {$num}";
		}
		if ($type == -1)
		{
		    $data = app_db::select('ylmf_urladd', 'SQL_CALC_FOUND_ROWS *', "1 {$limit}");
		}
		else
		{
		    $data = app_db::select('ylmf_urladd', 'SQL_CALC_FOUND_ROWS *', "`type` = {$type}{$limit}");
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
		foreach ($output['data'] as &$row)
		{
		    $tmp = unserialize($row['info']);
		    $row = array_merge($row, $tmp);
		    unset($row['info']);
		}
		return $output;
	}


	/**
	 * 获取一条记录
	 *
	 * @param int $id
	 * @return array
	 */
	public static function get_one($id)
	{
		$id = (int)$id;
		if ($id < 1)
		{
			return false;
		}

		$data = app_db::select('ylmf_urladd', '*', "id = {$id}");
		if (empty($data))
		{
		    return false;
		}
		$data = array_merge($data[0], unserialize($data[0]['info']));
		unset($data['info']);
		return $data;
	}


	/**
	 * 获取处于某一种状态的记录数量，0: 未审核，1: 通过审核，2: 未通过审核
	 *
	 * @param int $type
	 */
	public static function get_total($type = 0)
	{
	    $type = (int)$type;
	    if ($type < 0 || $type > 2)
	    {
	        return false;
	    }

        return app_db::get_rows_num('ylmf_urladd',  "`type` = {$type}");
	}
}
?>