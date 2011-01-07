<?php
/**
 * ��վ���й�����
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_mztop
{
	/**
	 * ��վͷ����ǩ����
	 *
	 * @param array $mztop_data ��ǩ����
	 * @return void
	 */
	public static function update_cache_mztop($mztop_data = array())
	{
        if(!empty($mztop_data))
        {
            usort($mztop_data, "cmp");
        }
		mod_cache::set_cache('cache_mztop', $mztop_data);
	}


	/**
	 * ��ȡ��վͷ����ǩ�б�
	 *
	 * @return array
	 */
	public static function get_mztop_list()
	{
		if (false == $output = mod_cache::get_cache('cache_mztop'))
		{
			self::update_cache_mztop();
			$output = mod_cache::get_cache('cache_mztop');
		}
		return $output;
	}

	/**
	 * �����վͷ����ǩ
	 *
	 * @param array $mztop �±�ǩ����
	 * @return array
	 */
	public static function add_mztop($mztop = array())
	{
        if(empty($mztop))
        {
            return false;
        }
        $list = self::get_mztop_list();
        $list[] = $mztop;
        self::update_cache_mztop($list);
    }

	/**
	 * �޸���վͷ����ǩ
	 *
	 * @param int $id ��ǩid
	 * @param array $mztop ��ǩ����
	 * @return array
	 */
	public static function edit_mztop($id = null, $mztop = array())
	{
        if($id === null || empty($mztop))
        {
            return false;
        }
        $list = self::get_mztop_list();
        $list[$id] = $mztop;
        self::update_cache_mztop($list);
    }

	/**
	 * ����/��ʾ��վͷ����ǩ
	 *
	 * @param array $order ������վ˳��
	 * @param array $order ������վ��ʾ
	 * @return array
	 */
	public static function order_mztop($order = null, $show = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_mztop_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
            $list[$i]['show'] = $show[$i] ? 1 : 0;
        }
        self::update_cache_mztop($list);
    }

	/**
	 * ��ȡһ����ǩ����Ϣ
     *
	 * @param int $id ��ǩid
	 * @return array
	 */
	public static function get_mztop($id)
	{
        $list = self::get_mztop_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * ɾ����ǩ
     *
	 * @param int/array $id ��ǩid
	 * @return array
	 */
	public static function delete_mztop($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_mztop_list();
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
        self::update_cache_mztop($list);
    }
}
?>
