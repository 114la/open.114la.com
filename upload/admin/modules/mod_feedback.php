<?php
/**
 * �����������
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_feedback
{
	/**
	 * ��ȡһ�����
	 *
	 * @param int $fid
	 * @return array
	 */
	public static function get_one($fid)
	{
		$fid = (int)$fid;
		if ($fid < 1)
		{
			return false;
		}

		$data = app_db::select('ylmf_feedback', '*', "fid = {$fid}");
		return (empty($data)) ? false : $data[0];
	}


	/**
	 * ��ȡ�б�
	 *
	 * @param int $start ��ʼ
	 * @param int $num ����
	 * @return array
	 */
	public static function get_list($start = 0, $num = 0)
	{
		$start = (int)$start;
		$num = (int)$num;

		$limit = '';
		if ($start > -1 && $num > 0) {
			$limit = " LIMIT {$start},{$num}";
		}

		$data = app_db::select('ylmf_feedback', 'SQL_CALC_FOUND_ROWS *', "1 {$limit}");
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

}