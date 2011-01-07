<?php
/**
 * 专题分类管理
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_zhuanti_class
{
	/**
	 * 返回搜索结果
	 *
	 * @param string $keyword
	 * @param int $start[optional]
	 * @param int $num[optional]
	 * @return array
	 */
	public static function search($keyword, $start = 0, $num = 20)
	{
		$contition = " `name` LIKE '%{$keyword}%'";
		if ($start > -1 && $num > 0)
		{
			$contition .= " LIMIT {$start}, {$num}";
		}
		$data = app_db::select('ylmf_toolclass', 'SQL_CALC_FOUND_ROWS *', $contition);
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
	 * @param string $type
	 * @param int $start[optional]
	 * @param int $num[optional]
	 * @return array
	 */
	public static function get_list($type = '', $start = 0, $num = 0)
	{
	    if (!file_exists(PATH_DATA . '/conf/zhuantidb.php'))
	    {
	        return false;
	    }
	    require PATH_DATA . '/conf/zhuantidb.php';
	    if (!is_array($zhuantidb) || empty($zhuantidb))
		{
		    return false;
		}

		$condition = '';
		if (!empty($type))
		{
		    $condition .= " `type` = '{$type}'";
		}
		if (empty($condition))
		{
		    $tmp = implode('", "', array_keys($zhuantidb));
			$condition = " type in (\"{$tmp}\")";
		}

		$condition .= " ORDER BY type, displayorder";
		if ($start > -1 && $num > 0)
		{
			$condition .= " LIMIT {$start}, {$num}";
		}

		$result = app_db::query('select SQL_CALC_FOUND_ROWS * from ylmf_toolclass where ' . $condition);
        while($tmp = app_db::fetch_one())
        {
            $data[$tmp['id']] = $tmp;
        }

		if (empty($data))
		{
			return false;
		}

		$output = array();
		$total = app_db::query('SELECT FOUND_ROWS() AS rows');
		$total = app_db::fetch_one();
		$output['total'] = $total['rows'];

		foreach ($data as &$row)
		{
		    $row['type_zh'] = (empty($zhuantidb[$row['type']])) ? '' : $zhuantidb[$row['type']];
		}
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

		$data = app_db::select('ylmf_toolclass', '*', "id = {$id}");
		return (empty($data)) ? false : $data[0];
	}
}
?>
