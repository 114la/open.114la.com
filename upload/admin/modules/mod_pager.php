<?php
/**
 * �����������
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_pager
{
	/**
	 * Ĭ����ʾҳ��
	 *
	 * @var int
	 */
	public static $default_pages = 15;


	/**
	 * ��ȡҳ���б�
	 *
	 * @param int $total ��¼����
	 * @param int $start �ӵڼ�����¼��ʼ
	 * @param int $page_rows ÿҳ��ʾ��¼��
	 * @return array
	 */
	public static function get_page_number_list($total, $start, $page_rows)
	{
		if ($total < 1 || $start < 0 || $page_rows < 1) return false;

		// ����ҳ��βҳʱ����ǰҳ����������ʾ��ҳ��
		$least = (self::$default_pages - 5) / 2;

		if ($start < $page_rows) $start = 0;
		if ($start >= $total) $start = $total - 1;
		$page_num = ceil($total/$page_rows);

		$current_page = ceil($start/$page_rows);
		if ($start%$page_rows == 0) $current_page++;
		if ($current_page < 1) $current_page = 1;
		$output = array();
		// ���С����ʾĬ����ʾҳ��
		if ($page_num <= self::$default_pages) {
			// ��һҳ
			$prev = ($current_page-2) * $page_rows;
			if ($prev < 0) $prev = 0;
			if ($start > 0) $output['prev'] = $prev;
			for ($i=0; $i<$page_num; ++$i) {
				$tmp = $i * $page_rows;
				$t = $i + 1;
				if ($t == $current_page) $output[$t] = -1;
				else $output[$t] = $tmp;
			}
			// ��һҳ
			$next = $current_page * $page_rows;
			if ($next < $total) $output['next'] = $next;
		} else {
			// �����Ҫʡ��ĳЩҳ
			if ($current_page - $least - 1 > 1 || $current_page + $least + 1 < $page_num) {
				// ��һҳ
				$prev = ($current_page - 2) * $page_rows;
				if ($prev < 0) $prev = 0;
				if ($start > 0) $output['prev'] = $prev;
				for ($i = 0; $i < $page_num; ++$i) {
					$tmp = $i * $page_rows;
					$t = $i + 1;
					if ($t < $current_page - $least && $page_num - self::$default_pages + 2 > $t && $t != 1) {
						$output['omitf'] = true;
						continue;
					}
					if ($t > $current_page + $least && $t > self::$default_pages - 1 && $t != $page_num) {
						$output['omita'] = true;
						continue;
					}
					if ($t == $current_page) $output[$t] = -1;
					else $output[$t] = $tmp;
				}
				// ��һҳ
				$next = $current_page * $page_rows;
				if ($next < $total) $output['next'] = $next;
			} else {
				// ��һҳ
				$prev = ($current_page-2) * $page_rows;
				if ($prev < 0) $prev = 0;
				if ($start > 0) $output['prev'] = $prev;
				for ($i=0; $i<$page_num; ++$i) {
					$tmp = $i * $page_rows;
					$t = $i + 1;
					if ($t == $current_page) $output[$t] = -1;
					else $output[$t] = $tmp;
				}
				// ��һҳ
				$next = $current_page * $page_rows;
				if ($next < $total) $output['next'] = $next;
			}
		}
		return $output;
	}

}
?>