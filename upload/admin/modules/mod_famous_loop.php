<?php
/**
 * ��վ�ֲ�
 *
 * @since 2009-7-11
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') &&exit('Forbidden');
class mod_famous_loop
{
	/**
	 * ��վ�ֲ�����
	 *
	 * @param array $famous_loop_data ��ǩ����
	 * @return void
	 */
	public static function update_cache_famous_loop($famous_loop_data = array())
	{
        if(!empty($famous_loop_data))
        {
            usort($famous_loop_data, "cmp");
        }
		mod_cache::set_cache('cache_famous_loop', $famous_loop_data);
	}


	/**
	 * ��ȡ��վ�ֲ��б�
	 *
	 * @return array
	 */
	public static function get_famous_loop_list()
	{
		if (false == $output = mod_cache::get_cache('cache_famous_loop'))
		{
			self::update_cache_famous_loop();
			$output = mod_cache::get_cache('cache_famous_loop');
		}
		return $output;
	}

	/**
	 * �����վ�ֲ�
	 *
	 * @param array $famous_loop ����վ�ֲ�����
	 * @return array
	 */
	public static function add_famous_loop($famous_loop = array())
	{
        if(empty($famous_loop))
        {
            return false;
        }
        $list = self::get_famous_loop_list();
        $list[] = $famous_loop;
        self::update_cache_famous_loop($list);
    }

	/**
	 * ������վ�ֲ�
	 *
	 * @param array $order ��վ�ֲ�˳��
	 * @return array
	 */
	public static function order_famous_loop($order = null)
	{
        if($order === null)
        {
            return false;
        }
        $list = self::get_famous_loop_list();
        foreach($order as $i => $o)
        {
            $list[$i]['order'] = $o;
        }
        self::update_cache_famous_loop($list);
    }

	/**
	 * �޸���վ�ֲ�
	 *
	 * @param int $id ��վ�ֲ�id
	 * @param array $famous_loop ��վ�ֲ�����
	 * @return array
	 */
	public static function edit_famous_loop($id = null, $famous_loop = array())
	{
        if($id === null || empty($famous_loop))
        {
            return false;
        }
        $list = self::get_famous_loop_list();
        $list[$id] = $famous_loop;
        self::update_cache_famous_loop($list);
    }

	/**
	 * ��ȡһ����վ�ֲ�����Ϣ
     *
	 * @param int $id ��վ�ֲ�id
	 * @return array
	 */
	public static function get_famous_loop($id)
	{
        $list = self::get_famous_loop_list();
        if(array_key_exists($id, $list))
        {
            return $list[$id];
        }
        return false;
	}

	/**
	 * ɾ����վ�ֲ�
     *
	 * @param int/array $id ��վ�ֲ�id
	 * @return array
	 */
	public static function delete_famous_loop($id = null)
	{
        if($id === null)
        {
            return false;
        }
        $list = self::get_famous_loop_list();
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
        self::update_cache_famous_loop($list);
    }

}
?>
