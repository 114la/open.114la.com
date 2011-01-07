<?php
/**
 * 网站管理类
 *
 * @copyright http://www.114la.com
 * @version    $Id: mod_site_manage.php 1534 2009-12-10 00:32:48Z syh $
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_site_manage
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

	    $sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.classid AS class_id, b.classname AS class_name, a.name, a.url, a.displayorder,
                       a.gooddisplayorder, a.starttime, a.endtime, a.namecolor, a.adduser, a.good
                FROM ylmf_site AS a, ylmf_class AS b
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
		$data = app_db::select('ylmf_site', 'SQL_CALC_FOUND_ROWS *', $contition);
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

		$cache_main_class = mod_class::get_class_list();
		// 分类
		if ($class_id > 0)
		{
			if ($cache_main_class[$class_id]['parentid'] == 0)
			{
				$tmp = '';
				foreach ($cache_main_class as $key => $val)
				{
					if (!empty($cache_main_class[$val['parentid']]) && $cache_main_class[$val['parentid']]['parentid'] == $class_id)
					{
						$tmp .= $key . ',';
					}
				}
				if ($tmp != '')
				{
					$tmp = substr($tmp, 0, -1);
					$condition .= (!empty($condition)) ? " AND `class` IN({$tmp})" :
														" AND `class` IN({$tmp})";
				}
			}
			//2级分类
			elseif ($cache_main_class[$cache_main_class[$class_id]['parentid']]['parentid'] == 0)
			{
				$tmp = '';
				foreach ($cache_main_class as $key => $val)
				{
					if ($val['parentid'] == $class_id)
					{
						$tmp .= $key . ',';
					}
				}
				if ($tmp != '')
				{
					$tmp = substr($tmp, 0, -1);
					$condition .= (!empty($condition)) ? " AND `class` IN({$tmp})" :
														" AND `class` IN({$tmp})";
				}
			}
			//3级分类
			else
			{
				$condition .= (!empty($condition)) ? " AND `class` = {$class_id}" :
													" AND `class` = {$class_id}";
			}
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

	    $sql = 'SELECT SQL_CALC_FOUND_ROWS a.id, b.classid AS class_id, b.classname AS class_name, a.name, a.url, a.displayorder,
                       a.gooddisplayorder, a.starttime, a.endtime, a.namecolor, a.adduser, a.good
                FROM ylmf_site AS a, ylmf_class AS b
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

		$data = app_db::select('ylmf_site', '*', "id = {$id}");
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
		$data = app_db::select('ylmf_site', 'id', "`class` = {$class_id} AND (`name` = '{$site}' OR url = '{$site}')");
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

		return app_db::delete('ylmf_site', "class = {$class_id}");
	}


	/**
	 * 批量添加网站
	 *
	 * @param array $sites 网址数组
	 */
	public static function multi_add($sites)
	{
        if(is_array($sites) && !empty($sites))
        {
            $class = intval($sites['classid']);
            if(!empty($sites['sites']))
            {
                foreach($sites['sites'] as $site)
                {
                    $name = htmlspecialchars(trim($site['name']));
                    $url = htmlspecialchars(trim($site['url']));
                    if(empty($name) || empty($url))
                    {
                        continue;
                    }
                    $remark = htmlspecialchars(trim($site['remark']));
                    app_db::query("INSERT INTO `ylmf_site` ( `name` , `url` , `class` , `remark` ) VALUES ( '$name', '$url', '$class', '$remark')");
                }
            }
        }
	}

    /**
	 * 批量导入网站
	 *
	 * @param array $data 网址数组
	 */
	public static function import($data)
	{
        $sites['classid'] = $data['classid'];
        //解析字符串
        preg_match_all("/<a.*?href=.?[\'\"](.*?).?[\'\"].*?>(.*?)<\/a>/is", $data['sites'], $result);
        foreach($result[2] as $i => $name)
        {
            $name = trim(strip_tags($name));
            $url = $result[1][$i];
            if(empty($name) || empty($url))
            {
                unset($result[1][$i]);
                unset($result[2][$i]);
                continue;
            }
            $sites['sites'][] = array('name' => $name, 'url' => $url, 'remark' => '');
        }
        self::multi_add($sites);
	}
}
?>
