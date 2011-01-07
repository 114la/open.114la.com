<?php
/**
 * 专题管理
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_zhuanti
{
	/**
	 * 返回搜索结果
	 *
	 * @param string $keyword
	 * @param int $start[optional]
	 * @param int $num[optional]
	 * @return array
	 */
	public static function search($keyword, $search_type, $start = 0, $num = 20)
	{
	    if (!file_exists(PATH_DATA . '/conf/zhuantidb.php'))
	    {
	        return false;
	    }

		require PATH_DATA . '/conf/zhuantidb.php';
		$condition = '';
        $condition .= " and a.{$search_type} LIKE '%{$keyword}%'";
		$condition .= ' ORDER BY a.class, a.displayorder';
		if ($start > -1 && $num > 0)
		{
			$condition .= " LIMIT {$start}, {$num}";
		}
		$tmp_type = ' AND b.type != "keyword" ';
		//$data = app_db::select('ylmf_tool', 'SQL_CALC_FOUND_ROWS *', $contition);

		$sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.id AS class_id, b.name AS class_name, a.name, a.url, a.displayorder,
                       a.inindex, a.indexdisplayorder, a.starttime, a.endtime, a.namecolor, b.type
                FROM ylmf_tool AS a, ylmf_toolclass AS b
                WHERE a.class = b.id ' . $tmp_type . $condition;
		$query = app_db::query($sql);
		$data = array();
		while ($rt = app_db::fetch_one())
		{
		    $rt['zhuanti_name'] = (empty($zhuantidb[$rt['type']])) ? '' : $zhuantidb[$rt['type']];
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
	 * 获取列表
	 *
	 * @param int $class_id
	 * @param boolean $isend
	 * @param boolean $inindex
	 * @param int $start[optional]
	 * @param int $num[optional]
	 * @return array
	 */
	public static function get_list($class_id = 0, $isend = false, $inindex = false, $start = 0, $num = 0, $extends = '')
	{
	    if (!file_exists(PATH_DATA . '/conf/zhuantidb.php'))
	    {
	        return false;
	    }

		require PATH_DATA . '/conf/zhuantidb.php';
		$condition = '';
		// 分类
		if ($class_id > 0)
		{
			$condition .= (!empty($condition)) ? " AND a.`class` = {$class_id}" :
												 " AND a.`class` = {$class_id}";
		}
		// 过期
		if ($isend)
		{
			$condition .= (!empty($condition)) ? ' AND a.`endtime` > 0 AND a.`endtime` < ' . time() :
												 ' AND a.`endtime` > 0 AND a.`endtime` < ' . time();
		}
		elseif ($inindex)
		{
			$condition .= (!empty($condition)) ? ' AND a.inindex = 1 ' : ' AND a.inindex = 1 ' ;
		}

		$condition .= ' ORDER BY a.class, a.displayorder';
		if ($start > -1 && $num > 0)
		{
			$condition .= " LIMIT {$start}, {$num}";
		}

		$tmp_type = ' AND b.type != "keyword" AND b.type != "mztop" ';
		if ($extends == 'keyword')
		{
		    $tmp_type = ' AND b.type = "keyword" ';
		}
		elseif ($extends == 'mztop')
		{
		    $tmp_type = ' AND b.type = "mztop" ';
		}


		$sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.id AS class_id, b.name AS class_name, a.name, a.url, a.displayorder,
                       a.inindex, a.indexdisplayorder, a.starttime, a.endtime, a.namecolor, b.type
                FROM ylmf_tool AS a, ylmf_toolclass AS b
                WHERE a.class = b.id ' . $tmp_type . $condition;
		$query = app_db::query($sql);

		$data = array();
		while ($rt = app_db::fetch_one())
		{
		    $rt['zhuanti_name'] = (empty($zhuantidb[$rt['type']])) ? '' : $zhuantidb[$rt['type']];
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
	 * 获取一个的信息
	 */
	public static function get_one($id)
	{
		if ($id < 1)
		{
			return false;
		}
		$id = (int)$id;

		$data = app_db::select('ylmf_tool', '*', "id = {$id}");
		return (empty($data)) ? false : $data[0];
	}
}
?>
