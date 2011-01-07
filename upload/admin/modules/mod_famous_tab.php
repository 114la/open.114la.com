<?php
/**
 * ��վͷ����ǩ������
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_famous_tab
{
	/**
	 * ��վͷ����ǩ����
	 *
	 * @param array $famous_tab_data ��ǩ����
	 * @return void
	 */
	public static function update_cache_famous_tab($famous_tab_data = array())
	{
        if(!empty($famous_tab_data))
        {
            usort($famous_tab_data, "cmp");
        }
		mod_cache::set_cache('cache_famous_tab', $famous_tab_data);
	}


	/**
	 * ��ȡ��վͷ����ǩ�б�
	 *
	 * @return array
	 */
	public static function get_famous_tab_list()
	{
		if (false == $output = mod_cache::get_cache('cache_famous_tab'))
		{
			self::update_cache_famous_tab();
			$output = mod_cache::get_cache('cache_famous_tab');
		}
		return $output;
	}

	/**
	 * �����վͷ����ǩ
	 *
	 * @param array $famous_tab �±�ǩ����
	 * @return array
	 */
	public static function add_famous_tab($famous_tab = array())
	{
        if(empty($famous_tab))
        {
            return false;
        }
        $list = self::get_famous_tab_list();
        $list[] = $famous_tab;
        self::update_cache_famous_tab($list);
    }

	/**
	 * �޸���վͷ����ǩ
	 *
	 * @param int $id ��ǩid
	 * @param array $famous_tab ��ǩ����
	 * @return array
	 */
	public static function edit_famous_tab($id = null, $famous_tab = array())
	{
        if($id === null || empty($famous_tab))
        {
            return false;
        }
        $list = self::get_famous_tab_list();
        $list[$id] = $famous_tab;
        self::update_cache_famous_tab($list);
    }

	/**
	 * ������վͷ����ǩ
	 *
	 * @param array $order ��ǩ˳��
	 * @return array
	 */
	public static function order_famous_tab($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_famous_tab_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_famous_tab($list);
    }

	/**
	 * ��ȡһ����ǩ����Ϣ
     *
	 * @param int $id ��ǩid
	 * @return array
	 */
	public static function get_famous_tab($id)
	{
        $list = self::get_famous_tab_list();
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
	public static function delete_famous_tab($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_famous_tab_list();
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
        self::update_cache_famous_tab($list);
    }
}
?>
