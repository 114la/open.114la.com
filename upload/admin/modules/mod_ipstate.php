<?php
/**
 * IP 统计
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_ipstate
{
	/**
	 * 获取某年每个月统计
	 *
	 * @param string $year
	 * @return array
	 */
	public static function get_year_state($year)
	{
		$c_month = date('Y-n');
		$c_year = is_numeric($year) ? $year : date('Y');
		$p_year = $c_year - 1;
		$n_year = $c_year + 1;

		$summip = $ispdx = $ispwt = $qvod = 0;

		$m_ipdb = array();
		$rt = app_db::select('ylmf_ipstates', 'month, sum(nums) AS nums, sum(isp_dx) AS isp_dx, sum(isp_wt) AS isp_wt, sum(qvod) AS qvod',
												  "month LIKE '{$c_year}%' GROUP BY month");
		if (empty($rt))
		{
			return false;
		}

		foreach ($rt as $row)
		{
			$summip += $row['nums'];
			$ispdx += $row['isp_dx'];
			$ispwt += $row['isp_wt'];
			$qvod += $row['qvod'];
			$key = substr($row['month'], strrpos($row['month'], '-') + 1);
			$row['_month'] = str_replace('-', '_', $row['month']);
			$m_ipdb[$key] = $row;
		}
		for($i = 1; $i <= 12; $i++)
		{
			empty($m_ipdb[$i]) && $m_ipdb[$i] = array('month' => $c_year . '-' . $i, '_month' => $c_year . '_' . $i, 'nums' => '0');
		}
		ksort($m_ipdb);

		return $m_ipdb;
	}


	/**
	 * 获取某月每天的统计
	 */
	public static function get_month_state($month)
	{
		$c_month = $month ? str_replace('_' , '-', $month) : date('Y-n');
		list($Y, $M) = explode('-', $c_month);
		if(!is_numeric($Y) || !is_numeric($M))
		{
			return false;
			//throw new Exception('非法操作，请返回重试！');
			//Showmsg('undefined_action');
		}
		if($M == 1)
		{
			$p_month = ($Y - 1) . '_12';
			$n_month = $Y . '_2';
		}
		elseif ($M == 12)
		{
			$p_month = $Y . '_11';
			$n_month = ($Y + 1) . '_1';
		}
		else
		{
			$p_month = $Y . '_' . ($M - 1);
			$n_month = $Y . '_' . ($M + 1);
		}

		$sumip = $ispdx = $ispwt = $qvod = 0;
		$d_ipdb = array();

		$rt = app_db::select('ylmf_ipstates', 'day, nums, isp_dx, isp_wt, qvod', "month = '{$c_month}' ORDER BY day");
		if (empty($rt)){
			return false;
		}

		foreach ($rt as $row)
		{
			$sumip += $row['nums'];
			$ispdx += $row['isp_dx'];
			$ispwt += $row['isp_wt'];
			$qvod += $row['qvod'];
			$key = substr($row['day'], strrpos($row['day'], '-') + 1);
			$d_ipdb[$key] = $row;
		}
		for($i=1; $i <= date('t', strtotime($c_month . '-1')); $i++)
		{
			empty($d_ipdb[$i]) && $d_ipdb[$i] = array('day' => "{$c_month}-{$i}", 'nums' => '0');
		}
		ksort($d_ipdb);

		return $d_ipdb;
	}
}